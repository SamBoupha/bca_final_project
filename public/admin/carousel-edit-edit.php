<?php 
require_once("../../include/initialize.php");
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {
	
	$file_name = $_POST['index']."__".$_POST['page_name']."__".$_POST['file_name'];
	$img_path = "..".DS."img".DS."product_slides".DS;

	if (rename($img_path.$_POST['old_file_name'], $img_path.$file_name)) {
		$_SESSION['report'] = "Editted successfully";
	} else {
		$_SESSION['report'] = "Edit failed";
	}
	header('location: carousel-edit.php');
}

$file_names = explode("__", $_GET['fn']);

$index = $file_names[0];
$page_name = $file_names[1];
$file_name = $file_names[2];

?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<div class='carousel-edit-add'>
		<h2>Carousel Editing: Edit this slide</h2>
		<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
			<label>Index:</label><br />
			<input type='text' name='index' value='<?php echo $index ?>'><br />
			<label>Page name:</label><br />
			<input type='text' name='page_name' value='<?php echo $page_name ?>'><label>.php</label><br /><br />
			<label>Select <b>new</b> Image (730x300px):</label><br /><br />
			<input type='file' name='new_img'><br /><br /><br />
			<input type='hidden' name='file_name' value='<?php echo $file_name ?>'>
			<input type='hidden' name='old_file_name' value="<?php echo $_GET['fn'] ?>">
			<input type='submit' class='btn btn-default' name='submit' value='Submit'>
		</form>
	</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>