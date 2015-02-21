<?php
require_once(INC_PATH.DS.'db_connection.php');

class Customer extends DatabaseObject {
	public $id,
		   $email,
		   $name,
		   $shipping_address,
		   $shipping_state_id,
		   $shipping_city_id,
		   $phone_number,
		   $postcode,
		   $username;

	protected static $table_name = 'customer';

	public function select_by($username, $password) {
		global $db;
		$username = $db->prep_sql($username);
		$password = $db->prep_sql($password);
		$sql = "SELECT id, first_name FROM ".static::$table_name." WHERE username='$username' and password = '$password'";

		return self::instanciate($sql); 
	}
}

?>