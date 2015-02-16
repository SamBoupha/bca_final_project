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
					computer_brand.name,
					computer_model.model,
					computer_model.price,
					computer_model.quantity,
					from 
					computer_model,
					left join
					computer_brand 
					on
					computer_model.brand_id    = computer_brand.id ";

			$sql .= $public.$highlight.$limit;

		return self::instanciate($sql);
	}


}

?>