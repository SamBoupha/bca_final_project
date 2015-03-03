<?php
require_once(INC_PATH.DS.'db_connection.php');

class ComputerObject extends DatabaseObject {

	public 	$id,
			$model,
			$price,
			$quantity,
			$mfg,
			$cpu,
			$chip_set,
			$cache,
			$min_clock_speed,
			$max_clock_speed,
			$hdd,
			$hdd_type,
			$ram,
			$ram_frequency,
			$ram_type,
			$graphic,
			$graphic_capacity,
			$mornitor,
			$resolution,
			$os,
			$architecture,
			$brand,
			$img_thumb,
			$img_left_side,
			$img_right_side,
			$img_back,
			$img_front,
			$visibility,
			$show_at_index_page;

	protected static $table_name = "computer_model";

	public static function select($limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " WHERE computer_model.visibility = 1 " :
					 " ORDER BY computer_model.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND computer_model.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					computer_model.id,
					computer_brand.name as brand,
					computer_model.model,
					computer_model.price,
					computer_model.quantity,
					computer_model.img_thumb,
					computer_model.visibility,
					computer_model.show_at_index_page
					
				FROM 
					computer_model
				LEFT JOIN
					computer_brand 
				ON
					computer_model.brand_id    = computer_brand.id ";

			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);
	}

	public static function select_all($id=null, $limit=null, $public=false, $highlight=false) {
		global $db;

		$id = $id != null ? " and ".static::$table_name.".id = ".$id : "";

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " AND computer_model.visibility = 1 " :
					 " ORDER BY computer_model.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND computer_model.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					computer_model.id,
					computer_brand.name as brand,
					computer_model.model,
					computer_model.price,
					computer_model.quantity,
					computer_model.mfg,
					computer_spec_cpu.family as cpu,
					computer_spec_hdd.capacity as hdd,
					computer_spec_ram.capacity as ram,
					computer_spec_ram.ram_type, 
					computer_spec_os.name as os,
					computer_spec_graphic.processor as graphic,
					computer_spec_graphic.capacity as graphic_capacity,
					computer_spec_mornitor.inch as mornitor,
					computer_spec_mornitor.resolution,
					computer_model.img_thumb,
					computer_model.img_front,
					computer_model.img_left_side,
					computer_model.img_back,
					computer_model.visibility,
					computer_model.show_at_index_page
					from 
					computer_model,
					computer_spec_hdd,
					computer_spec_ram,
					computer_spec_cpu,
					computer_spec_graphic,
					computer_spec_os,
					computer_spec_mornitor,
					computer_brand 
					where 
					computer_model.brand_id    = computer_brand.id and 
					computer_model.cpu_id      = computer_spec_cpu.id and 
					computer_model.graphic_id  = computer_spec_graphic.id and 
					computer_model.hdd_id      = computer_spec_hdd.id and 
					computer_model.mornitor_id = computer_spec_mornitor.id and 
					computer_model.os          = computer_spec_os.id and 
					computer_model.ram_id      = computer_spec_ram.id ";
	
			$sql .= $id;
			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);

	}

	public static function order_select($id) {
		$sql = "SELECT
					computer_brand.name as brand,
					computer_model.model,
					computer_model.price,
					computer_model.img_thumb
				FROM 
					computer_model
				LEFT JOIN
					computer_brand 
				ON
					computer_model.brand_id    = computer_brand.id 
				WHERE 
					computer_model.id = ".$id;

		return self::select_by_query($sql);
	}

}

?>