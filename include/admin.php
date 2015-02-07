<?php
	require_once(INC_PATH.DS.'db_connection.php');

	class admin extends databaseObject {

		protected static $table_name = 'admin';

		static function find_admin($username, $password) {
			global $db;

			$sql  = "SELECT * FROM admin WHERE ";
			$sql .= "username = '".$db->prep_sql($username);
			$sql .= "' AND password='".$db->prep_sql($password)."'";

			$result = $db->execute_query($sql);

			return $db->db_fetch_assoc($result);
		} 
	}
?>