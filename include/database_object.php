<?php
	require_once(INC_PATH.DS.'db_connection.php');

	class DatabaseObject {
		protected static $table_name;

		protected static function get_column_names($sql) {
			global $db;
			if (!$db->is_connected()) {
				$db->open_connection();
			}

			$db_rows = array();
			// The idea here is to reduce the number of times needed to go to the database
			// So the work-around is to use one associative array that contains two arrays
			$result_n_fieldName = array();

			$result = $db->execute_query($sql);
			// This assoc 'result' will contain the array of rows of result 
			// retrieved from the database
			while ($row = $db->db_fetch_assoc($result)) {
				$db_rows[] = $row; 
			}
			$result_n_fieldName['result'] = $db_rows;

			$field_names = array();
			while($field = $db->get_field($result)) {
					$field_names[] = $field->name;
				}
			// While this assoc 'field_names' contains the column names of the executed sql table
			$result_n_fieldName['field_names'] = $field_names;

			//$db->close_connection();
			// so that it can do 2 opearations and return 2 results from one function
			return $result_n_fieldName;
		}

		protected static function instanciate($sql) {

			$classname = get_called_class();

			$result_n_fieldName = self::get_column_names($sql);

			// To make it clear I separate the two 
			$db_rows = $result_n_fieldName['result'];
			$field_names = $result_n_fieldName['field_names'];
			
			$array_of_objects = array();
			
			// This will determine the number of objects that has to be created
			// upon the numbers of rows received from the database
			for ($i=0, $size = sizeof($db_rows) ; $i < $size; $i++) { 

				$object = new $classname();

				foreach ($field_names as $field_name) {
					$object->$field_name = $db_rows[$i][$field_name];
				}
				$array_of_objects[] = $object;
			}
			// If sql query returns only one row then just returns one object
			// Else the array of objects 
			return sizeof($array_of_objects) > 1 ? $array_of_objects : $array_of_objects[0];
		}

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
			//$db->close_connection();
			return $result;
		}

		public static function delete($id) {
			global $db;

			$sql = "DELETE FROM ".static::$table_name." WHERE id=".$id." LIMIT 1";

			$result = $db->execute_query($sql);
			//$db->close_connection();
			return $result;
		}

		// updates should come in a form assoc array
		public static function update($updates) {
			global $db;

			$sql = "UPDATE ".static::$table_name." SET ";
			$sql1 = "";
			foreach ($updates as $key => $value) {
				$sql1 .= "`".$db->prep_sql($key)."`"."='".$db->prep_sql($value)."',";
			}
			$sql1 = substr($sql1, 0, strlen($sql1)-1);

			$sql .= $sql1." WHERE id=".$db->prep_sql($updates['id']);

			$result = $db->execute_query($sql);
			//$db->close_connection();

			return $result;
		}
	}
?>