<?php require_once("../include/initialize.php"); ?>
<?php
	$detailPage = true;
	if (isset($_POST['submit'])) {
		
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);

		$customer = Customer::select_by($username, $password);

		if(empty($customer)) {
			$error = "<h4 class='error'>Username/password is not correct. Please, try again</h4>";
		} else {
			$customer->username = $customer->name;
			$session->log_in($customer);
			header("location: index.php");
		}

	} 
?>
<?php include(INC_PATH.DS."header.php"); ?>
<!-- body of the page -->
<section>
	<h2>Hi</h2>
</section> <!-- main body section-->
	
<?php include(INC_PATH.DS."footer.php"); ?>



