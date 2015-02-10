<?php
	require_once("../../include/initialize.php");
	$file = "..".DS."img1".DS."product_slides".DS.$_GET['fn'];
	if(file_exists($file)) {
		if (unlink($file)) {
			header("location: carousel-edit.php");
		} else {
			echo "error: file cannot be deleted";
		}
	} else {
		echo "Error: file doesn't exist";
	}
?>