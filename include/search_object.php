<?php
require_once(INC_PATH.DS.'db_connection.php');

class SearchObject extends DatabaseObject {
	public $product_id,
		   $product_category;

	public static function search($keyword) {
		global $db;

		$keyword = $db->prep_sql($keyword);

		$sql = "SELECT 	
					DISTINCT(tag_of_product.product_id), 
					tag_of_product.product_category 
				FROM 
					tag_of_product,
					tag_value 
				WHERE
					tag_value.value LIKE '%{$keyword}%' 
				AND 
					tag_value.id = tag_of_product.tag_value_id";

		//return $sql;
		// because of my bad implementation (lack of consistency) 
		// of instanciate method which returns object
		// if there is one result
		// else returns an array of objects

		$results = self::instanciate($sql);
		if (is_object($results)) {
			$temp = array();
			$temp[] = $results;
			$results = $temp;
		}
		$products = array();	
		/*
			product_category
			1 = computer
			2 = wireless_product
			3 = clothing
			4 = book
		*/
		if($results) {
			foreach ($results as $result) {
				if ($result->product_category == 1) {
					$products['computer'][] = $result->product_id;
				} elseif ($result->product_category == 2) {
					$products['wireless_product'][] = $result->product_id;
				} elseif ($result->product_category == 3) {
					$products['clothing'][] = $result->product_id;
				} elseif ($result->product_category == 4) {
					$products['book'][] = $result->product_id;
				}
			}
		} 
		return $products;
	} 
}