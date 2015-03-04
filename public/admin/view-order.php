<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'order_object.php');
if(!$session->is_logged_in()) header("location: login.php");
if (isset($_GET['q'])) {
	Order::set_table_name("_on_".$_GET['q']);

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
			<h2>All orders on <?php echo htmlspecialchars($_GET['q'])?></h2>
			<?php
		
				echo "<table class='order'>";
				echo "<tr>";
				echo "<th>index</th>";
				echo "<th></th>";
				echo "<th>Order ID</th>";
				echo "<th>Date and Time</th>";
				echo "<th>".$_GET['q']." ID</th>";
				echo "<th>Quantity</th>";
				echo "<th>Customer ID</th>";
				echo "</tr>";
				$i = 0;
				foreach ($orders as $order) {
					echo "<tr data-id=".$order->id.">";
					echo "<td>".++$i."</td>";
					echo "<td><a href='#'>HIDE<a/></td>";
					echo "<td>OD".$order->order_id."</td>";
					echo "<td>".date("d M Y H:i:s",strtotime($order->order_date))."</td>";
					echo "<td>".$order->product_id."</td>";
					echo "<td>".$order->qty."</td>";
					echo "<td>".$order->customer_id."</td>";
					echo "</tr>";
				}
				echo "</table>";
			?>
		</div>
	</section>
<script type="text/javascript">
	$('a').click( function() {
		$(this).parents("tr").fadeOut(1000);
		$.get('hide-order.php?id='+$(this).parents("tr").data('id')+'&table='+<?php echo "'".$_GET['q']."'" ?>, function(data) {
			$('<h4 class="success">Done</h4>').appendTo('h2');
			console.log(data);
		});
	});
</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>

