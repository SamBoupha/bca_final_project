<?php
	require_once(INC_PATH.DS.'db_connection.php');

	class Admin extends DatabaseObject {

		protected static $table_name = 'admin';
		public $id,
			   $first_name,
			   $last_name,
			   $username;
		

		static function find_admin($username, $password) {
			global $db;

			$sql  = "SELECT * FROM admin WHERE ";
			$sql .= "username = '".$db->prep_sql($username);
			$sql .= "' AND password='".$db->prep_sql($password)."'";

			return self::instanciate($sql);
		} 

		
	}
?>