<?php
require_once(INC_PATH.DS.'db_connection.php');

class ComputerObject extends DatabaseObject {

	public 	$id,
			$model,
			$price,
			$quantity,
			$mfg,
			$cpu,
			$hdd,
			$ram,
			$ram_type,
			$mornitor,
			$graphic,
			$os,
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

	public static function select_all_by_id($id) {
		global $db;

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
					computer_spec_ram.type as ram_type, 
					computer_spec_os.name as os,
					computer_spec_mornitor.inch as mornitor
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
					computer_model.ram_id      = computer_spec_ram.id and 
					computer_model.id = ";
			$sql .= $id;

		return self::instanciate($sql);
	}

	public static function select_from_table($table) {
		$sql = "SELECT id,name FROM ".$table." ORDER BY name ASC";

		return self::instanciate($sql);
	}

}

?>