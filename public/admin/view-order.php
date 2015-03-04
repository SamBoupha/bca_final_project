<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'order_object.php');
require_once(INC_PATH.DS.'book_object.php');
require_once(INC_PATH.DS.'computer_object.php');
if(!$session->is_logged_in()) header("location: login.php");
$table = htmlspecialchars($_GET['q']);
if (isset($table)) {
	if ($table !== 'all') {
		Order::set_table_name("order_on_".$table);
	}

	$orders = Order::select_all($limit=10);
	if (is_object($orders)) {
		$temp = clone $orders;
		$orders = array($temp);
	}
}
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section class='view-order'>
		<div >
			<h2>All orders 
			<?php 

				if($table == 'all') {
					echo "</h2>";
					$sql = "SELECT 	`order`.id,
									`order`.amount,
									`order`.order_date,
									`order`.shipping_address, 
									customer_city.city_name as shipping_city,
									customer_state.state_name as shipping_state 
							FROM 
									`order`,customer_city, customer_state 
							WHERE 
									visibility = 1 
							AND 
									customer_city.id = `order`.shipping_city 
							AND 
									customer_state.id = `order`.shipping_state 
							LIMIT 10 ";

					$orders = Order::select_by_query($sql);
			
					foreach ($orders as $order) {
						// $order->product_id field contains irrelevant values
						// so I reuse it to store more details coming from database
						$order->product_id = array();
						Order::set_table_name("order_on_book");
						$order->product_id[] = Order::select_by_order_id($order->id);
						Order::set_table_name("order_on_computer");
						$order->product_id[] = Order::select_by_order_id($order->id);
					}

					// after foreach $orders[0]->product_id[0] = book category
					// whereas $orders[0]->product_id[1] indicates computer

					foreach ($orders as $order) {
						echo "<table class='all-order'>";
						echo "<tr><th colspan='3'>#OD".$order->id."<span> placed on ". $order->order_date."</span></th></tr>";
						
						echo "<tr><td>";
						for ($i=0; $i < 2; $i++) { 
							if ($i==0 && !empty($order->product_id[$i])) {
								foreach ($order->product_id[$i] as $item ) {
									echo "BookID = ".$item->product_id."<br />";
								}
							} elseif ($i==1 && !empty($order->product_id[$i])) {
								foreach ($order->product_id[$i] as $item ) {
									echo "ComputerID = ".$item->product_id."<br />";
								}
							}
						}
						echo "</td>";
						echo "<td >";
						echo "Ship to: ";
						echo $order->shipping_address." ".$order->shipping_city." ";
						echo $order->shipping_state;
						echo "</td>";
						echo "<td> Total: ";
						echo number_format($order->amount);
						echo "</td>";

						echo "</tr></table>";

					}

				
				} else {
					echo "on ".htmlspecialchars($table)."</h2>";
			
					echo "<table class='order'>";
					echo "<tr>";
					echo "<th>index</th>";
					echo "<th></th>";
					echo "<th>Date and Time</th>";
					echo "<th>Order ID</th>";
					if ($table !== 'all') {
						echo "<th>".$table." ID</th>";
						echo "<th>Quantity</th>";
					}
					echo "<th>Customer ID</th>";
					echo "</tr>";
					$i = 0;
					foreach ($orders as $order) {
						echo "<tr data-id=".$order->id.">";
						echo "<td>".++$i."</td>";
						echo "<td><a href='#'>HIDE<a/></td>";
						echo "<td>".date("d M Y H:i:s",strtotime($order->order_date))."</td>";
						if ($table == 'all') {
							echo "<td>OD".$order->id."</td>";
						} else {
							echo "<td>OD".$order->order_id."</td>";
							echo "<td>".$order->product_id."</td>";
							echo "<td>".$order->qty."</td>";
						}	
						echo "<td>".$order->customer_id."</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			?>
		</div>
	</section>
<script type="text/javascript">
	$('a').click( function() {
		$(this).parents("tr").fadeOut(1000);
		$.get('hide-order.php?id='+$(this).parents("tr").data('id')+'&table='+<?php echo "'".$table."'" ?>, function(data) {
			$('<h4 class="success">Done</h4>').appendTo('h2');
			console.log(data);
		});
	});
</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>

