<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'order_object.php');
if(!$session->is_logged_in()) header("location: login.php");
if (isset($_GET['q'])) {
	$table_name = 'order_on_'.$_GET['q'];
	$orders = Order::select_all_from($table_name,$limit=10);
}
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section class='view-order'>
		<div >
			<h2>All orders on <?php echo htmlspecialchars($_GET['q'])?></h2>
			<?php
			
				$date = explode(",",date("d M Y H:i:s",strtotime($orders[0]->order_date)));
				echo "<table class='order'>";
				echo "<tr>";
				echo "<th>ID</th>";
				echo "<th>Date and Time</th>";
				echo "<th>".$_GET['q']." ID</th>";
				echo "<th>Quantity</th>";
				echo "<th>Customer ID</th>";
				echo "</tr>";
				
				foreach ($orders as $order) {
					$date = explode(",",date("d M Y H:i:s",strtotime($order->order_date)));
					echo "<tr>";
					echo "<td>".$order->id."</td>";
					echo "<td>".date("d M Y,H:i:s",strtotime($order->order_date))."</td>";
					echo "<td>".$order->product_id."</td>";
					echo "<td>".$order->qty."</td>";
					echo "<td>".$order->customer_id."</td>";
					echo "</tr>";
				}
				echo "</table>";
			?>
		</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>

