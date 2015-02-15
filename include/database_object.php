<?php
	require_once(INC_PATH.DS.'db_connection.php');

	class DatabaseObject {
		protected static $table_name;

		public static function insert($new, $table_name=null) {
			global $db;
			$sql1 = "";
			$sql2 = "";

			foreach ($new as $key => $value) {
				$sql1 .= "`".$db->prep_sql($key)."`,";
				$sql2 .= "'".$db->prep_sql($value)."',";
			}

			$sql1 = substr($sql1, 0,strlen($sql1)-1);
			$sql2 = substr($sql2, 0,strlen($sql2)-1);

			$sql  = "INSERT INTO ";
			$sql .= $table_name == null ? static::$table_name : $table_name;
			$sql .= " (";
			$sql .= $sql1;
			$sql .= ") VALUES (";
			$sql .= $sql2;
			$sql .= ")";

			$result = $db->execute_query($sql);
			$db->close_connection();
			return $result;
		}
	}
?>