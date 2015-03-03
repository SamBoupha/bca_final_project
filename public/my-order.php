<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}

	require_once(INC_PATH.DS."order_object.php");

	$orders = array();

	if ($customer_session->last_batch_no == 0) {
		echo "You haven't placed any order yet ";
	} else {
		if ($book_orders = Order::select_order_of_user($customer_session->id,"book")) {
			$orders = array_merge($orders, $book_orders);
		} 

		if ($computer_orders = Order::select_order_of_user($customer_session->id,"Computer")) {
			$orders = array_merge($orders, $computer_orders);
		} 
	}

?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='my-order'>
		<h2>My Order</h2>
		<?php
		
			for ($i=$customer_session->last_batch_no; $i > 0 ; $i--) { 

				$j = 0;
				
				foreach ($orders as $order) {
					
					if ($order->batch_no == $i) {
						
						if ($j == 0) {
							echo "<div class='date'>".$order->order_date."</div><br />";
							$j++;
							echo "<div class='order'>";
						}
					
						echo $order->product_id." x".$order->qty."<br />";
						
					}
				}
				echo "</div>";
			}
		?>
	</div>
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		