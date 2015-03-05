<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php
if (!$customer_session->is_logged_in() || get_items_in_the_cart() == 0) {
		header('location: index.php');
	}
		
require_once(INC_PATH.DS.'order_object.php');
$products = $_SESSION['cart'];
$new['customer_id'] = $order['customer_id'] = $update['id'] = $customer_session->id;

if ($_POST['success'] == 1) {
	
	$order['amount'] = $_SESSION['sum'];
	$order['shipping_address'] = $customer_session->shipping_address;
	$order['shipping_state'] = $customer_session->shipping_state_id;
	$order['shipping_city'] = $customer_session->shipping_city_id;
	$new['order_id'] = $update['recent_order'] = Order::insert($order, '`order`');
	foreach ($products as $product) {
		$new['product_id'] = $product['id'];
		$new['qty'] = $product['quantity'];
		$new['price'] = $product['price'];
		if ($product['type'] == 'book') {
				DatabaseObject::insert($new, 'order_on_book');
			}
		if ($product['type'] == 'computer') {
				DatabaseObject::insert($new, 'order_on_computer');
			}	
	}

$update['total_order'] = $customer_session->total_order+1;
if(Customer::update($update)){
	$customer_session->re_log_in($customer_session->id);
}

$_SESSION['cart'] = $_SESSION['sum'] = array();
unset($_POST['success']);
}

?>
<?php include(INC_PATH.DS."header.php"); ?>
<!-- body of the page -->

<section class='thankyou'>
	<br />
	<div>
		<h2>Your order with <em>OrderID #OD<?php echo $update['recent_order'] ?></em>  has been successfully placed </h2>
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