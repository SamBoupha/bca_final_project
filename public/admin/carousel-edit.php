<?php 
require_once("../../include/initialize.php");
include(INC_PATH.DS."helper.php");
if(!$session->is_logged_in()) header("location: login.php");
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<h2>Carousel Editing</h2>
		<a href='carousel-edit-add.php'>Add pictures</a><br />

		<?php
			$dirPath = "..".DS."img".DS."product_slides";
			$images = imgSrcAutoGen($dirPath,400);
			foreach ($images as $image) {
				echo "<a href='index.php".$link."'>".$image."</a><br />";
			}
		?>

	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>