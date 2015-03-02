<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'order_object.php');
if(!$session->is_logged_in()) header("location: login.php");
if (isset($_GET['q'])) {
	$table = 'order_on_'.$_GET['q'];
	$orders = Order::select_all_from($table,$limit=10);
}
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section class='view-order'>
		<div >
			<h2>All orders on <?php echo htmlspecialchars($_GET['q'])?></h2>
			<?php
			
				$date = explode(",",date("d M Y,H:i:s",strtotime($orders[0]->order_date)));
			?>
		</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>

