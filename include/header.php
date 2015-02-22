<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<!-- if it is subpage then link this css in -->
		<?php 
			if($subpage) {
				echo '<link rel="stylesheet" type="text/css" href="css/subpage.css">';
				$subpage = false;
			}
			if ($detailPage) {
				echo '<link rel="stylesheet" type="text/css" href="css/full-detail-page.css">';
				$detailPage = false;
			}
			if ($checkoutPage) {
				echo '<link rel="stylesheet" type="text/css" href="css/checkout.css">';
				$checkoutPage = false;
			}
		?>
		<script type="text/javascript" src="js/jquery.js"></script>
		<?php 
			$no_of_item = count($_SESSION['cart']);
			if ($no_of_item) {
				echo '<script type="text/javascript">
						$( function() {
							$("div.cart span").text('.$no_of_item.').show();
						});
					  </script>';
			}
		?>
	</head>

	<body >
		<!-- header section -->
		<header>
				<div class="col-md-12">
					<a href="index.php"><img class='logo' style="height:60px;" src="img/abc-opt.png"></a>
					<input type='text' name='search_box' placeholder='Search for a product, category or brand'>
					<input type='button' class='btn btn-primary' name='search' value='SEARCH'>
					<a href='checkout.php'><div class='cart btn'>
						<span></span>
						<img src="img/cart.png">
					</div></a>
					<div class='account btn'>
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						My Account
						<span class='caret'></span>
					</div>
				</div>
		</header>