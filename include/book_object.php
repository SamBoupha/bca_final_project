<?php
require_once(INC_PATH.DS.'db_connection.php');

class BookObject {

	public 	$id,
			$title,
			$author,
			$author_about,
			$price,
			$quantity,
			$year,
			$length,
			$intro,
			$category_id,
			$publisher_id,
			$img_front,
			$img_back,
			$img_thumb;

	protected static $table_name = "books_title";

	public static function select_all_by_id($id) {
		global $db;

		$sql = "select 
					books_title.id, 
					books_title.title,
					books_title.price, 
					books_title.quantity, 
					books_title.year, 
					books_title.length, 
					books_title.intro, 
					books_author.name as author,
					books_author.about as author_about, 
					books_category.category as category, 
					books_publisher.name as publisher, 
					books_title.img_front, 
					books_title.img_back 
				from 
					books_title, 
					books_author, 
					books_category, 
					books_publisher 
				where 
					books_title.author_id = books_author.id 
				and 
					books_title.category_id = books_category.id 
				and 
					books_title.publisher_id = books_publisher.id
				and 
					books_title.id = ";
			$sql .= $id;


		return self::instanciate($sql);
	}

	public static function select() {
		$sql = "SELECT 
					books_title.id,
					books_title.title,
					books_author.name as author,
					books_title.price,
					books_title.img_thumb
				FROM 
					books_title,
					books_author
				WHERE 
					books_title.author_id = books_author.id LIMIT 16";

		return self::instanciate($sql);
	}

	protected static function get_column_names($sql) {
		global $db;
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

		$db->close_connection();
		// so that it can do 2 opearations and return 2 results from one function
		return $result_n_fieldName;
	}

	protected static function instanciate($sql) {

		$result_n_fieldName = self::get_column_names($sql);

		// To make it clear I separate the two 
		$db_rows = $result_n_fieldName['result'];
		$field_names = $result_n_fieldName['field_names'];
		
		$array_of_objects = array();
		
		// This will determine the number of objects that has to be created
		// upon the numbers of rows received from the database
		for ($i=0, $size = sizeof($db_rows) ; $i < $size; $i++) { 

			$object = new bookObject();

			foreach ($field_names as $field_name) {
				$object->$field_name = $db_rows[$i][$field_name];
			}
			$array_of_objects[] = $object;
		}
		// If sql query returns only one row then just returns one object
		// Else the array of objects 
		return sizeof($array_of_objects) > 1 ? $array_of_objects : $array_of_objects[0];
	}
}

?>