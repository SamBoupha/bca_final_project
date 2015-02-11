<?php 
require_once("../../include/initialize.php");
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {
	$tmp_file = $_FILES['new_img']['tmp_name'];
	$file_name = $_POST['index']."_".$_POST['page_name']."_".$_FILES['new_img']['name'];

	$location = "..".DS."img".DS."product_slides".DS.$file_name;
	
	if (move_uploaded_file($tmp_file, $location)) {
		$_SESSION['report'] = "Upload successfully";
		header('location: carousel-edit.php');
	} else {
		
	}
}
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<div class='carousel-edit-add'>
		<h2>Carousel Editing: Add new pictures</h2>
		<form class='carousel-edit-add-edit' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
			<label>Index:</label><br />
			<input type='text' name='index' value="<?php echo $_POST['index']?>" placeholder='This is the position of the slide which to be shown'><br />
			<label>Page name:</label><br />
			<input type='text' name='page_name'><label>.php</label><br /><br />
			<label>Select Image (730x300px):</label><br /><br />
			<input type='file' name='new_img'><br /><br /><br />
			<input type='submit' class='btn btn-default' name='submit' value='Upload'>
		</form>
	</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>