<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
	if (isset($_GET['id'])) {
		remove_from_cart($_GET['id']);
		header("location: checkout.php");
	}
	if (isset($_POST['quantity']) && $_POST['quantity'] > 0) {
		$_SESSION['cart'][$_POST['index']]['quantity'] = htmlspecialchars($_POST['quantity']);
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
		$sum = $sub_total = 0;

		if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
			$products = $_SESSION['cart'];
			for ($i=0, $j=sizeof($products); $i < $j ; $i++) { 
				echo "<div class='row product-detail'>";
					echo "<div class='col-md-3 product-img'>";
						echo "<br /><img src='img".DS.$products[$i]['type'].DS.$products[$i]['thumbnail']."'>";
					echo "</div>";
					echo "<div class='col-md-9'>";
						echo "<div class='row product-name'>";
							echo $products[$i]['name'];
						echo "</div>";
						echo "<div class='row product-delivery'>";
							echo "Free Delivery.<br />Delivered in 3 business days.";
						echo "</div>";
						echo "<div class='row product-quantity'>";
							echo "Quantity: <input type='number' min='1' name='quantity' value='";
							echo $products[$i]['quantity'];
							echo "' data-index=";
							echo $i;
							echo ">&nbsp;&nbsp;<span>save</span>";
						echo "</div>";
						echo "<div class='row product-price'>Rs. ";
							echo number_format($products[$i]['price']);
							$sub_total = $products[$i]['price']*$products[$i]['quantity'];
							echo "<p>Sub total: ".number_format($sub_total)."</p>";
						echo "<span><a href='".$_SERVER['PHP_SELF']."?id=".$i.
						"'><p>REMOVE</p></a></span>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
				$sum += $sub_total;
			}
			$_SESSION['sum'] = $sum;
		} else {
			echo "<h2>Your cart is empty</h2>";
		}
		?>
		</div>
		<div class='col-md-4 order-total'>
			<div class='order-summary'>
				<h2>Cart Summary:</h2>
				<p>Total: <span><?php echo "Rs. ".number_format($sum) ?></span></p>
				<p>Discount: <span><?php echo "Rs. 0" ?></span></p>
				<p>Delivery: <span class='success'><?php echo "Free" ?></span></p>
				<h4>Order total: <span><?php echo "Rs. ".number_format($sum) ?></h4>
				<?php if (get_items_in_the_cart()): ?>
					<a id='go_checkout' href='shipping_detail.php'><div class="btn buy-now">PLACE ORDER</div></a>
				<?php endif ?>
			</div>	
		</div>
	</div>
</section> <!-- main body section-->

<script type="text/javascript">
	<?php 
		if ($customer_session->is_logged_in()) {
			echo "var is_logged_in = true";
		} else {
			echo "var is_logged_in = false";
		}
	 ?>

	$qty_span = $('.product-quantity span');
	$('div.buy-now').click( function() {
		if (!is_logged_in) {
			$('a#go_checkout').attr('href','#');
			$('div.lightOut').show();
		}
	});

	$('.product-quantity input').change( function() {
		$quantity = $(this).val();
		$item_index = $(this).data('index');

		$qty_span
			.css( { 'color' : '#235182' , 'cursor' : 'pointer'})
			.attr('onclick','post("checkout.php",{quantity:"'+$quantity+'",index:"'+$item_index+'"})');
	});

	function post(path, params, method) {
	    method = method || "post"; // Set method to post by default if not specified.

	    // The rest of this code assumes you are not using a library.
	    // It can be made less wordy if you use one.
	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", path);

	    for(var key in params) {
	        if(params.hasOwnProperty(key)) {
	            var hiddenField = document.createElement("input");
	            hiddenField.setAttribute("type", "hidden");
	            hiddenField.setAttribute("name", key);
	            hiddenField.setAttribute("value", params[key]);

	            form.appendChild(hiddenField);
	         }
	    }

	    document.body.appendChild(form);
	    form.submit();
	}

</script>
<?php include(INC_PATH.DS."footer.php"); ?>