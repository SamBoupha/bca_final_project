<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}
?>
<!-- body of the page -->

<section>
	<br />
	<div>
		<h2>Your order has been placed successfully</h2>
		<h3>Thank you for shopping with us!</h3>
	</div>
	<?php
		$products = $_SESSION['cart'];
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