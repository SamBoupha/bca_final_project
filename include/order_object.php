<?php
require_once(INC_PATH.DS.'db_connection.php');

class Order extends DatabaseObject {
	public $id,
		   $product_id,
		   $customer_id,
		   $order_date,
		   $qty,
		   $amount,
		   $size,
		   $order_id,
		   $shipping_address,
		   $shipping_state,
		   $shipping_city,
		   $postcode;
		   
	protected static $table_name = "`order`";

	public function select_all($limit=null) {
		
		$limit = $limit == null ? "" : " LIMIT {$limit}";

		$sql = "SELECT * FROM ".static::$table_name." WHERE visibility = 1 ".$limit;

		return self::instanciate($sql);
	}

	public static function select_by_order_id($order_id) {
		$sql = "SELECT * FROM ".static::$table_name." WHERE order_id = ".$order_id;

		return self::instanciate($sql);
	}

	public static function set_table_name($table) {
		static::$table_name = $table;
	}

	public static function select_order_of_user($customer_id, $table_name, $recent_order_id, $min) {
		if ($table_name == 'clothing') {
			$size = ', size';
		}

		$sql = "SELECT  id, 
						order_id, 
						product_id, 
						order_date, 
						qty, 
						price {$size} 
				FROM order_on_".$table_name." where order_id <= ".$recent_order_id." and order_id >= ".$min." and customer_id = ".$customer_id;
		
		return self::instanciate($sql);
	}

	public static function get_last_x_orders($customer_id, $recent_order_id, $offset=0, $limit=5) {
		global $db;
		$limit = " limit ".$limit;
		$offset = " offset ".$offset;

		$sql  = "SELECT 
					`order`.id, 
					`order`.amount, 
					`order`.shipping_address, 
					customer.postcode,
					customer_state.state_name as shipping_state, 
					customer_city.city_name as shipping_city 
				FROM 
					`order`, customer_state, customer_city, customer 
				WHERE 
					`order`.customer_id = ".$customer_id." 
				AND 
					`order`.id <= ".$recent_order_id." 
				AND 
					customer_city.id = `order`.shipping_city 
				AND 
					`order`.shipping_state = customer_state.id 
				AND 
					`order`.customer_id = customer.id
				ORDER BY 
					`order`.id DESC ".$limit.$offset;	
		
		return self::instanciate($sql);
	}

	// $new should come in the form of assoc array
	// public static function insert($new, $table_name=null) {
	// 	global $db;
	// 	$sql1 = "";
	// 	$sql2 = "";

	// 	foreach ($new as $key => $value) {
	// 		$sql1 .= "`".$db->prep_sql($key)."`,";
	// 		$sql2 .= "'".$db->prep_sql($value)."',";
	// 	}

	// 	$sql1 = substr($sql1, 0,strlen($sql1)-1);
	// 	$sql2 = substr($sql2, 0,strlen($sql2)-1);

	// 	$sql  = "INSERT INTO ";
	// 	$sql .= $table_name == null ? static::$table_name : $table_name;
	// 	$sql .= " (";
	// 	$sql .= $sql1;
	// 	$sql .= ") VALUES (";
	// 	$sql .= $sql2;
	// 	$sql .= ")";

	// 	$result = $db->execute_query($sql);
	// 	//$db->close_connection();
	// 	return $db->get_last_id();
	// }

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
			return $array_of_objects;
		}
}

?>