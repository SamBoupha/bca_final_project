<?php
require_once("../include/initialize.php");
$customer_session->log_out();
header('location: '.$_GET['from']);

?>