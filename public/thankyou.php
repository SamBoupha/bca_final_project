<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php
if (!$customer_session->is_logged_in() || get_items_in_the_cart() == 0) {
		header('location: index.php');
	}
		
$products = $_SESSION['cart'];
$new['customer_id'] = $update['id'] = $customer_session->id;
$new['batch_no'] = $update['last_batch_no'] = $customer_session->last_batch_no+1;
if ($_POST['success'] == 1) {
	foreach ($products as $product) {
		$new['product_id'] = $product['id'];
		$new['qty'] = $product['quantity'];

		if ($product['type'] == 'book') {
				DatabaseObject::insert($new, 'order_on_book');
			}
		if ($product['type'] == 'computer') {

				DatabaseObject::insert($new, 'order_on_computer');
			}	
	}

Customer::update($update);
$customer_session->re_log_in($customer_session->id);
$_SESSION['cart'] = array();
}

?>
<?php include(INC_PATH.DS."header.php"); ?>
<!-- body of the page -->

<section class='thankyou'>
	<br />
	<div>
		<h2>Your order has been successfully placed </h2>
		<h3>Thank you for shopping with us!</h3>

	</div>
	<?php
		
		echo "<div class='product'>";
			for ($i=0, $j=sizeof($products); $i < $j ; $i++) { 
					echo "<div class='product-img'>";
						echo "<br /><img height='100px' src='img".DS.$products[$i]['type'].DS.$products[$i]['thumbnail']."'>";
					echo "</div>";
			}
		echo "</div>";
	?>
	
</section>
	
<?php include(INC_PATH.DS."footer.php"); ?>