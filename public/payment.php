<?php require_once("../include/initialize.php"); ?>
<?php $detailPage = true; $checkout_page = true; ?> 
<?php include(INC_PATH.DS."header.php"); ?>
<?php
if (!$customer_session->is_logged_in()) {
		header('location: index.php');
	}
?>
<!-- body of the page -->

<section><br />
	<div><h2>Payment Gateway</h2></div><br />
	<div class='payment'>
		<img src='img/payment.png'>
	</div>
		<a href='thank_you.php'><div class='btn example'></div></a>
	<div class='order-summary'>
	</div>
	<br />
	<br />
</section> <!-- main body section-->
<script type="text/javascript">
	var i=1;
	$('div.payment').click( function() {
		if (i%2 == 1) {
			$('div.payment img').attr('src','img/cod.png');
		} else {
			$('div.payment img').attr('src','img/payment.png');
		}
		i++;
	});
</script>
<?php include(INC_PATH.DS."footer.php"); ?>