<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkoutPage = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
	if (isset($_GET['id'])) {
		remove_from_cart($_GET['id']);
		header("location: checkout.php");
	}
?>

<!-- body of the page -->
<section class='container'>
	<div class="row">
		<h2>My Shopping Cart</h2>

	</div>
	<div class="row head">&nbsp;</div>
	<div class="row">
		<div class='col-md-8 product-summary'>
		<?php
		$sum = 0;
		if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
			$products = $_SESSION['cart'];
			for ($i=0, $j=sizeof($products); $i < $j ; $i++) { 
				echo "<div class='row product-detail'>";
					echo "<div class='col-md-3 product-img'>";
						echo "<img src='img".DS.$products[$i]['type'].DS.$products[$i]['thumbnail']."'>";
					echo "</div>";
					echo "<div class='col-md-9'>";
						echo "<div class='row product-name'>";
							echo $products[$i]['name'];
						echo "</div>";
						echo "<div class='row product-delivery'>";
							echo "Free Delivery.<br />Delivered in 3 business days.";
						echo "</div>";
						echo "<div class='row product-quantity'>";
							echo "Quantity: 1";
						echo "</div>";
						echo "<div class='row product-price'>Rs. ";
							echo $products[$i]['price'];
						echo "<span><a href='".$_SERVER['PHP_SELF']."?id=".$i.
						"'>REMOVE</a></span>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
				$sum += $products[$i]['price'];
			}
		} else {
			echo "<h2>Your cart is empty</h2>";
		}
		?>
		</div>
		<div class='col-md-4 order-total'>
			<div class='order-summary'>
				<h2>Cart Summary:</h2>
				<p>Total: <span><?php echo "Rs. ".$sum ?></span></p>
				<p>Discount: <span><?php echo "Rs. 0" ?></span></p>
				<p>Delivery: <span class='success'><?php echo "Free" ?></span></p>
				<h4>Order total: <span><?php echo "Rs. ".$sum ?></h4>
			</div>	
		</div>
	</div>
</section> <!-- main body section-->
	
<?php include(INC_PATH.DS."footer.php"); ?>