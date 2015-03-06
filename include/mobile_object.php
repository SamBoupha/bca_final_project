<?php
require_once(INC_PATH.DS.'db_connection.php');

class MobileObject extends DatabaseObject {

	public 	$id,
			$category_id,
			$model,
			$price,
			$quantity,
			$cpu,
			$hdd,
			$external,
			$ram,
			$screen,
			$screen_type,
			$resolution,
			$os,
			$brand,
			$img_thumb,
			$img_front,
			$visibility,
			$show_at_index_page;

	protected static $table_name = "wireless_product";

	public static function select($limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " WHERE wireless_product.visibility = 1 " :
					 " ORDER BY wireless_product.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND wireless_product.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					wireless_product.id,
					wireless_product_manufacturer.name as brand,
					wireless_product.model,
					wireless_product.price,
					wireless_product.quantity,
					wireless_product.img_thumb,
					wireless_product.visibility,
					wireless_product.show_at_index_page
					
				FROM 
					wireless_product
				LEFT JOIN
					wireless_product_manufacturer 
				ON
					wireless_product.manufacturer_id = wireless_product_manufacturer.id ";

			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);
	}

	public static function select_all($id=null, $limit=null, $public=false, $highlight=false) {
		global $db;

		$id = $id != null ? " and ".static::$table_name.".id = ".$id : "";

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " AND wireless_product.visibility = 1 " :
					 " ORDER BY wireless_product.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND wireless_product.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					wireless_product.id,
					wireless_product_manufacturer.name as brand,
					wireless_product.model,
					wireless_product.price,
					wireless_product.quantity,
					wireless_product_cpu.processor as cpu,
					wireless_product_hdd.internal as hdd,
					wireless_product_ram.capacity as ram,
					wireless_product_os.name as os,
					wireless_product_screen.size as screen,
					wireless_product_screen.type as screen_type,
					wireless_product.img_thumb,
					wireless_product.img_front,
					wireless_product.visibility,
					wireless_product.show_at_index_page
					from 
					wireless_product,
					wireless_product_hdd,
					wireless_product_ram,
					wireless_product_cpu,
					wireless_product_os,
					wireless_product_screen,
					wireless_product_manufacturer 
					where 
					wireless_product.manufacturer_id = wireless_product_manufacturer.id and 
					wireless_product.cpu_id      = wireless_product_cpu.id and 
					wireless_product.hdd_id      = wireless_product_hdd.id and 
					wireless_product.screen_id   = wireless_product_screen.id and 
					wireless_product.os_id       = wireless_product_os.id and 
					wireless_product.ram_id      = wireless_product_ram.id ";
	
			$sql .= $id;
			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);

	}

	public static function order_select($id) {
		$sql = "SELECT
					wireless_product_brand.name as brand,
					wireless_product.model,
					wireless_product.price,
					wireless_product.img_thumb
				FROM 
					wireless_product
				LEFT JOIN
					wireless_product_brand 
				ON
					wireless_product.brand_id    = wireless_product_brand.id 
				WHERE 
					wireless_product.id = ".$id;

		return self::select_by_query($sql);
	}

}

?>