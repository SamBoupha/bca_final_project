<?php
require_once(INC_PATH.DS.'db_connection.php');

class Order extends DatabaseObject {
	public $id,
		   $product_id,
		   $customer_id,
		   $order_date,
		   $qty;


	public function select_by($email, $password) {
		global $db;
		$email = $db->prep_sql($email);
		$password = $db->prep_sql($password);
		$sql = "SELECT id, name, email, shipping_address, shipping_state_id, shipping_city_id, mobile_number, postcode FROM ".static::$table_name." WHERE email='$email' and password = '$password' LIMIT 1";

		return self::instanciate($sql); 
	}

	public function select_all_from($table_name, $limit=null) {
		
		global $db;
		$limit = $limit == null ? "" : " LIMIT {$limit}";

		$table_name = $db->prep_sql($table_name);
		$sql = "SELECT * FROM {$table_name} ".$limit;

		return self::instanciate($sql);
	}
}

?>