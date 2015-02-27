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
		<div class='btn example' onclick='post("thankyou.php",{success: "1"})'></div>
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