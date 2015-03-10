<?php
	include("../include/initialize.php"); 
	$index = get_items_in_the_cart();
	$_SESSION['cart'][$index]['size'] = $_POST['size'];
?>