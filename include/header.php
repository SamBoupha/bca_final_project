<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<!-- if it is a subpage then link this css in -->
		<?php 
			if($subpage) {
				echo '<link rel="stylesheet" type="text/css" href="css/subpage.css">';
				$subpage = false;
			}
			if ($detailPage) {
				echo '<link rel="stylesheet" type="text/css" href="css/full-detail-page.css">';
				$detailPage = false;
			}
			if ($checkout_page) {
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
		<?php if (!$customer_session->is_logged_in()): ?>
			<script type="text/javascript">
			$( function() {
				$('div.account, span.login').click( function() {
					$('div.lightOut').show();
				})
			});
			</script>
		<?php endif ?>
		
	</head>

	<body >

		<!-- header section -->
		<header>
				<div class="col-md-12">
					<a href="index.php"><img class='logo' style="height:54px;" src="img/abc-opt.png"></a>
					<input type='text' name='search_box' placeholder='Search for a product, category or brand'>
					<input type='button' class='btn btn-primary' name='search' value='SEARCH'>
					<a href='checkout.php'><div class='cart btn'>
						<span></span>
						<img src="img/cart.png">
					</div></a>
					
					<div class='dropdown btn account'>
						<a class='dropdown-toggle' data-toggle="dropdown">
							<?php if ($customer_session->name): ?>
								<span class="glyphicon glyphicon-user"></span>
								<?php echo $customer_session->name; ?>
								<span class='caret'></span>
							</a>
							<ul class='dropdown-menu'>
								<li><a href='#'>My Account</a></li>
								<li><a href='my-order.php'>My Order</a></li>
								<li><a href='#'>Track Order</a></li>
								<li class="divider"></li>
								<li><a href="log_out.php?from=<?php echo $_SERVER['REQUEST_URI'] ?>">Log out</a></li>
							</ul>
							<?php else: ?>
								<span class='login'>LOGIN / SIGN UP</span>
								</a>
							<?php endif ?>
					</div>					
				
				</div>
		</header>
<?php require_once(INC_PATH.DS.'customer-login-form.php'); ?>