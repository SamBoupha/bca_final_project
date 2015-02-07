<?php
	define('DB_HOST', 'localhost');
	define('DB_USERNAME', 'samboupha');
	define('DB_PASSWORD', 'boupha31');
	define('DB_NAME', 'mikart');

	class connect_database 
	{
		private $connection;

		function __construct() {
			$this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			if(!$this->connection) {
				die("Unable to connect to the database".$this->connection->connect_error);
			}
		}

		private function confirm_query($result) {
			if(!$result) {
				$output  = $this->connection->error."<br>";
				$output .= $this->last_query;
				die($output);
			}
		}

		function execute_query($query) {
			$result = $this->connection->query($query);
			$this->confirm_query($result);
			return $result;
		}

		function prep_sql($query) {
			$query = $this->connection->real_escape_string($query);
			return $query;
		}


		function db_fetch_assoc($result) {
			return $result->fetch_assoc();
		}

		function close_connection() {
			if($this->connection)
				$this->connection->close();
		}

		function get_field($result) {
			return $result->fetch_field();
		}
	}

	$db = new connect_database();

?>