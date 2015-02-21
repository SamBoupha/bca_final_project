<?php 
require_once("../../include/initialize.php");
if(!$session->is_logged_in()) header("location: login.php");
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<div class='index'>
			<h2>Hello <em><?php echo $session->username; ?></em>!. Welcome to the Admin area</h2>
		</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>

