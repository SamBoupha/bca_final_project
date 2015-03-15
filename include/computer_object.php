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

	protected static $table_name = "computer";

	public static function select($limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " WHERE computer.visibility = 1 " :
					 " ORDER BY computer.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND computer.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					computer.id,
					computer_brand.name as brand,
					computer.model,
					computer.price,
					computer.quantity,
					computer.img_thumb,
					computer.visibility,
					computer.show_at_index_page
					
				FROM 
					computer
				LEFT JOIN
					computer_brand 
				ON
					computer.brand_id    = computer_brand.id ";

			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);
	}

	public static function select_all($id=null, $limit=null, $public=false, $highlight=false) {
		global $db;

		$id = $id != null ? " and ".static::$table_name.".id = ".$id : "";

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " AND computer.visibility = 1 " :
					 " ORDER BY computer.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND computer.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					computer.id,
					computer_brand.name as brand,
					computer.model,
					computer.price,
					computer.quantity,
					computer.mfg,
					computer_spec_cpu.family as cpu,
					computer_spec_hdd.capacity as hdd,
					computer_spec_ram.capacity as ram,
					computer_spec_ram.ram_type, 
					computer_spec_os.name as os,
					computer_spec_graphic.processor as graphic,
					computer_spec_graphic.capacity as graphic_capacity,
					computer_spec_mornitor.inch as mornitor,
					computer_spec_mornitor.resolution,
					computer.img_thumb,
					computer.img_front,
					computer.img_left_side,
					computer.img_back,
					computer.visibility,
					computer.show_at_index_page
					from 
					computer,
					computer_spec_hdd,
					computer_spec_ram,
					computer_spec_cpu,
					computer_spec_graphic,
					computer_spec_os,
					computer_spec_mornitor,
					computer_brand 
					where 
					computer.brand_id    = computer_brand.id and 
					computer.cpu_id      = computer_spec_cpu.id and 
					computer.graphic_id  = computer_spec_graphic.id and 
					computer.hdd_id      = computer_spec_hdd.id and 
					computer.mornitor_id = computer_spec_mornitor.id and 
					computer.os          = computer_spec_os.id and 
					computer.ram_id      = computer_spec_ram.id ";
	
			$sql .= $id;
			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);

	}

	public static function order_select($id) {
		$sql = "SELECT
					computer_brand.name as brand,
					computer.model,
					computer.price,
					computer.img_thumb
				FROM 
					computer
				LEFT JOIN
					computer_brand 
				ON
					computer.brand_id    = computer_brand.id 
				WHERE 
					computer.id = ".$id;

		return self::select_by_query($sql);
	}

	public static function search($values) {

		$sql = "SELECT 
					computer.id,
					computer_brand.name as brand,
					computer.model,
					computer.price,
					computer.quantity,
					computer.mfg,
					computer_spec_cpu.family as cpu,
					computer_spec_hdd.capacity as hdd,
					computer_spec_ram.capacity as ram,
					computer_spec_ram.ram_type, 
					computer_spec_os.name as os,
					computer_spec_graphic.processor as graphic,
					computer_spec_graphic.capacity as graphic_capacity,
					computer_spec_mornitor.inch as mornitor,
					computer_spec_mornitor.resolution,
					computer.img_thumb,
					computer.img_front,
					computer.img_left_side,
					computer.img_back,
					computer.visibility,
					computer.show_at_index_page
					from 
					computer,
					computer_spec_hdd,
					computer_spec_ram,
					computer_spec_cpu,
					computer_spec_graphic,
					computer_spec_os,
					computer_spec_mornitor,
					computer_brand 
					where 
					computer.brand_id    = computer_brand.id and 
					computer.cpu_id      = computer_spec_cpu.id and 
					computer.graphic_id  = computer_spec_graphic.id and 
					computer.hdd_id      = computer_spec_hdd.id and 
					computer.mornitor_id = computer_spec_mornitor.id and 
					computer.os          = computer_spec_os.id and 
					computer.ram_id      = computer_spec_ram.id
				AND 
					computer.visibility = 1
			AND
				  	computer.id in ( ";
				  
				foreach ($values as $value) {
					$sql .= $value.",";
				}

		$sql = substr($sql, 0, strlen($sql)-1);

		$sql .=	")";
		
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
		return $results;
	}

}

?>