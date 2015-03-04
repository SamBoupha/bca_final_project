<?php
require_once(INC_PATH.DS.'db_connection.php');

class Order extends DatabaseObject {
	public $id,
		   $product_id,
		   $customer_id,
		   $order_date,
		   $qty,
		   $order_id;
		   
	protected static $table_name = "order";

	public function select_all($limit=null) {
		
		$limit = $limit == null ? "" : " LIMIT {$limit}";

		$sql = "SELECT * FROM ".static::$table_name." WHERE visibility = 1 ".$limit;

		return self::instanciate($sql);
	}

	public static function set_table_name($table) {
		static::$table_name .= $table;
	}

	public static function select_order_of_user($customer_id, $table_name, $recent_order_id, $min) {
	
		$sql = "SELECT id, order_id, product_id, order_date, qty, price 
				FROM order_on_".$table_name." where order_id <= ".$recent_order_id." and order_id >= ".$min." and customer_id = ".$customer_id;
		
		return self::instanciate($sql);
	}

	public static function get_last_5_orders($customer_id, $recent_order_id) {
		global $db;
		$sql  = "select id from `order` where customer_id = ";
		$sql .= $customer_id ." and id <= ";
		$sql .= $recent_order_id." order by id desc limit 5 ";
		
		$result = $db->execute_query($sql);
		$results = array();
		while($row = $db->db_fetch_assoc($result)) {
			$results[] = $row['id'];
		}
		return $results;
	}

	// $new should come in the form of assoc array
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
			return $db->get_last_id();
		}
}

?>