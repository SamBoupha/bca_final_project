<?php
require_once(INC_PATH.DS.'db_connection.php');

class Order extends DatabaseObject {
	public $id,
		   $product_id,
		   $customer_id,
		   $order_date,
		   $qty;
		   
	protected static $table_name = "order_on_";

	public function select_by($email, $password) {
		global $db;
		$email = $db->prep_sql($email);
		$password = $db->prep_sql($password);
		$sql = "SELECT id, name, email, shipping_address, shipping_state_id, shipping_city_id, mobile_number, postcode FROM ".static::$table_name." WHERE email='$email' and password = '$password' LIMIT 1";

		return self::instanciate($sql); 
	}

	public function select_all($limit=null) {
		

		$limit = $limit == null ? "" : " LIMIT {$limit}";

		$sql = "SELECT * FROM ".static::$table_name." WHERE visibility = 1 ".$limit;

		return self::instanciate($sql);
	}

	public static function set_table_name($table) {
		static::$table_name .= $table;
	}
}

?>