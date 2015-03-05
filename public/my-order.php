<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}

	if ($customer_session->recent_order == 0) {
		$no_order = "You haven't placed any order yet";
	} else {
		require_once(INC_PATH.DS.'get_my_order.php');
	}
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='my-order'>
		<h2>My Order( <?php echo $customer_session->total_order ?> )</h2>
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
								echo "<h4><a href='book_detail.php?id=".$order->product_id->id."'>";
								echo $order->product_id->title."</a></h4>";
								echo "by ".$order->product_id->author;
							}
							elseif ($order->customer_id == 'computer') {
								echo "<h4><a href='computer_detail.php?id=".$order->product_id->id."'>";
								echo $order->product_id->brand." ".$order->product_id->model."</a></h4>";
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
					echo "<h4>Ship to address:</h4><br />";
					echo $list_of_order->shipping_address;
					echo "<br />";
					echo $list_of_order->shipping_city;
					echo "<br />";
					echo $list_of_order->shipping_state;
					echo "<br />";
					echo $list_of_order->postcode;
					echo "</div>";
					echo "</div></div>";
				}
				echo "<div class='btn more'>Load more</div>";
			}
			
		?>
	</div>
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		