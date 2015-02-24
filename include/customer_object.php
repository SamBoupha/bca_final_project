<?php
require_once(INC_PATH.DS.'db_connection.php');

class Customer extends DatabaseObject {
	public $id,
		   $email,
		   $name,
		   $shipping_address,
		   $shipping_state_id,
		   $shipping_city_id,
		   $mobile_number,
		   $postcode;

	protected static $table_name = 'customer';

	public function select_by($email, $password) {
		global $db;
		$email = $db->prep_sql($email);
		$password = $db->prep_sql($password);
		$sql = "SELECT id, name, email, shipping_address, shipping_state_id, shipping_city_id, mobile_number, postcode FROM ".static::$table_name." WHERE email='$email' and password = '$password' LIMIT 1";

		return self::instanciate($sql); 
	}
}

?>