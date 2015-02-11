<?php
	require_once("../../include/initialize.php");
	$session->log_out();
	header("location: login.php");
?>