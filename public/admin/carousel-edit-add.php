<?php 
require_once("../../include/initialize.php");
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {
	$tmp_file = $_FILES['new_img']['tmp_name'];
	$file_name = $_POST['index']."_".$_POST['page_name']."_".$_FILES['new_img']['name'];

	$location = "..".DS."img".DS."product_slides".DS.$file_name;
	
	if (move_uploaded_file($tmp_file, $location)) {
		echo "upload successfully";
		echo $file_name;
		print_r($names);
	} else {
		echo 'error';
	}
}
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<h2>Carousel Editing: Add new pictures</h2>
		<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
			<label>Index:</label>
			<input type='text' name='index'>
			<label>Page name:</label>
			<input type='text' name='page_name'><label>.php</label>
			<input type='file' name='new_img'>
			<input type='submit' name='submit' value='Upload'>
		</form>

	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>