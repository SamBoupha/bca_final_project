<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}

	require_once(INC_PATH.DS."order_object.php");
	require_once(INC_PATH.DS."book_object.php");
	require_once(INC_PATH.DS."computer_object.php");

	$orders = array();

	if ($customer_session->recent_order == 0) {
		$no_order = "You haven't placed any order yet";
	} else {
		$list_of_orders = Order::get_last_orders($customer_session->id, $customer_session->recent_order);
		$last_index = count($list_of_orders)-1;
		
		if ($book_orders = Order::select_order_of_user($customer_session->id,"book",$customer_session->recent_order,$list_of_orders[$last_index]->id)) {
			$orders = array_merge($orders, $book_orders);
			foreach ($orders as $order) {
				// the product _id will be replace by more meaningful details of that product id
				$order->product_id = BookObject::order_select($order->product_id);
				// since this id prop is free and not relevant here 
				// so I use it to store category identification instead
				$order->customer_id = "book";
			}
		} 

		if ($computer_orders = Order::select_order_of_user($customer_session->id,"computer",$customer_session->recent_order,$list_of_orders[$last_index]->id)) {
			
			foreach ($computer_orders as $order) {
				// the product _id will be replace by more meaningful details of that product id
				$order->product_id = ComputerObject::order_select($order->product_id);
				// since this id prop is free and not relevant here 
				// so I use it to store category identification instead
				$order->customer_id = "computer";
			}

			$orders = array_merge($orders, $computer_orders);
		} 
	}

?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='my-order'>
		<h2>My Order</h2>
		<?php

			if (isset($no_order)) {
				echo "<h3>".$no_order."</h3>";
			} else {
				foreach($list_of_orders as $list_of_order) { 

					$j = 0;
					
					foreach ($orders as $order) {
						
						if ($order->order_id == $list_of_order->id) {
							
							if ($j == 0) {

								echo "<div class='date'><span class='less_important'>Order id:</span> #OD".$order->order_id." <span class='less_important'><span>|</span> Placed on ".date("D, d M Y",strtotime($order->order_date))."</span></div><br />";
								$j++;
								echo "<div class='order row equal' >";
								echo "<div class='status'>PROCESSING . . .</div>";
								echo "<div class='col-md-8' >";
							}
										
							echo "<div class='row'>";
							echo "<div class='col-md-5 product-img '>";
							echo "<img height='100px' src='img".DS.$order->customer_id.DS.$order->product_id->img_thumb."'>";
							echo "</div>";
							echo "<div class='col-md-7' >";
							if ($order->customer_id == 'book') {
								echo "<h4>".$order->product_id->title."</h4>";
								echo "by ".$order->product_id->author;
							}
							elseif ($order->customer_id == 'computer') {
								echo "<h4>".$order->product_id->brand." ".$order->product_id->model."</h4>";
								echo "by ".$order->product_id->brand;
							}

							echo "<br />Quantity: ".$order->qty;
							echo "<br />Price per unit: ".number_format($order->price);
							echo "</div>";	
							echo "</div>";
						}
					}
					echo "</div>";
					echo "<div class='col-md-4 total'>";
					echo "<span class='total-order'>Total: ".number_format($list_of_order->amount)."</span>";
					echo "<div class='address'>";
					echo "ship to address:";
					echo $order->shipping_address;
					echo "</div>";
					echo "</div></div>";
				}
			}
			echo "<div class='btn more'>Load more</div>";
		?>
	</div>
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		