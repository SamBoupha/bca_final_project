<?php
	require_once("../../include/initialize.php");
	require_once(INC_PATH.DS.'order_object.php');
	
	$update['id'] = $_GET['id'];
	$update['visibility'] = 0;

	$_GET['table'] ? Order::set_table_name("_on_".$_GET['table']) : "";

	Order::update($update);
?>