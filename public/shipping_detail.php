<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
	if (isset($_GET['id'])) {
		remove_from_cart($_GET['id']);
		header("location: checkout.php");
	}
	
	if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}
?>

<!-- body of the page -->

<section class='container'>
	<div class="row">
		<h2>Shipping Detail</h2>
		<form method='post' name='shipping' class='shipping'>
			<div>
				<label>Name:</label><br />
				<input type='text' name='name'>
			</div>
			<div>
				<label>Email:</label><br />
				<input type='text' name='email' value=''>
			</div>
			<div>
				<label>Shipping Address:</label><br />
				<textarea class='address' name='address'></textarea>
			</div>
			<div>
				<label>State:</label>
				<select>
				</select>
			</div>
			<div>
				<label>City:</label>
				<select>
				</select>
			</div>
			<div>
				<label>Postcode:</label><br />
				<input type='text' name='postcode'>
			</div>
			<div>
				<label>Mobile number:</label><br />
				<input type='text' name='postcode' value=''>
			</div>
			
		</form>
	</div>
	
</section> <!-- main body section-->
	
<?php include(INC_PATH.DS."footer.php"); ?>