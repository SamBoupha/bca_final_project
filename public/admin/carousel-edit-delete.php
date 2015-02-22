<?php
	require_once("../../include/initialize.php");
	if(!$session->is_logged_in()) header("location: login.php");
	$file = "..".DS."img".DS."product_slides".DS.$_GET['fn'];
	if(file_exists($file)) {
		if (unlink($file)) {
			$_SESSION['report'] = "The selected slide has been deleted successfully.";
			header("location: carousel-edit.php");
		} else {
			echo "error: file cannot be deleted";
		}
	} else {
		echo "Error: file doesn't exist";
	}
?>