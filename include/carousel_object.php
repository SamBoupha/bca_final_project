<?php
	require_once "db_connection.php";

	class Carousel {

		protected static $table_name = "slideshow";

		function insert() {
			$sql  = "INSERT INTO ";
			$sql .= static::$table_name;
			$sql .= " "; 
		}
	}
?>