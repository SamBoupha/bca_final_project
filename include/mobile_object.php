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
					wireless_product_brand.name as brand,
					wireless_product.model,
					wireless_product.price,
					wireless_product.quantity,
					wireless_product.mfg,
					wireless_product_spec_cpu.family as cpu,
					wireless_product_spec_hdd.capacity as hdd,
					wireless_product_spec_ram.capacity as ram,
					wireless_product_spec_ram.ram_type, 
					wireless_product_spec_os.name as os,
					wireless_product_spec_graphic.processor as graphic,
					wireless_product_spec_graphic.capacity as graphic_capacity,
					wireless_product_spec_mornitor.inch as mornitor,
					wireless_product_spec_mornitor.resolution,
					wireless_product.img_thumb,
					wireless_product.img_front,
					wireless_product.img_left_side,
					wireless_product.img_back,
					wireless_product.visibility,
					wireless_product.show_at_index_page
					from 
					wireless_product,
					wireless_product_spec_hdd,
					wireless_product_spec_ram,
					wireless_product_spec_cpu,
					wireless_product_spec_graphic,
					wireless_product_spec_os,
					wireless_product_spec_mornitor,
					wireless_product_brand 
					where 
					wireless_product.brand_id    = wireless_product_brand.id and 
					wireless_product.cpu_id      = wireless_product_spec_cpu.id and 
					wireless_product.graphic_id  = wireless_product_spec_graphic.id and 
					wireless_product.hdd_id      = wireless_product_spec_hdd.id and 
					wireless_product.mornitor_id = wireless_product_spec_mornitor.id and 
					wireless_product.os          = wireless_product_spec_os.id and 
					wireless_product.ram_id      = wireless_product_spec_ram.id ";
	
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