<?php
require_once(INC_PATH.DS.'db_connection.php');

class ClothObject extends DatabaseObject {

	public 	$id,
			$section,
			$category,
			$brand,
			$brand_name,
			$name,
			$price,
			$description,
			$qty_s,
			$qty_m,
			$qty_l,
			$img,
			$img_type,
			$img_thumb,
			$img_front,
			$img_whole_body,
			$visibility,
			$show_at_index_page;

	protected static $table_name = "clothing";

	public static function select_all($id) {
		global $db;

		$sql = " SELECT 
					clothing.id,
					clothing.category_id as category,
					clothing.section_id as section, 
					clothing_brand.id as brand, 
					clothing_brand.name as brand_name,
					clothing.name, 
					clothing.price, 
					clothing.description, 
					clothing.qty_s, 
					clothing.qty_m, 
					clothing.qty_l, 
					clothing.visibility, 
					clothing.show_at_index_page 
				FROM 
					clothing, 
					clothing_brand
				WHERE
					clothing.id = ".$id.
				"
				AND
					clothing.brand_id = clothing_brand.id";

		return self::instanciate($sql);

	}

	public static function select($category_id, $section_id, $limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " AND clothing.visibility = 1 " :
					 " ORDER BY clothing.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND clothing.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					clothing.id, 
					clothing_brand.name as brand, 
					clothing.name, 
					clothing.price, 
					clothing_img.img as img_thumb, 
					clothing.visibility, 
					clothing.show_at_index_page 
				FROM 
					clothing, 
					clothing_brand, 
					clothing_img 
				WHERE
					clothing.brand_id = clothing_brand.id 
				AND
					clothing_img.cloth_id = clothing.id 
				AND
					clothing.category_id = ".$category_id;
		$sql .=	
				" AND
					clothing.section_id = ".$section_id;
		$sql .= "
		         AND 
					clothing_img.type_id = 1 "
				.$public.$highlight.$limit;

		return self::instanciate($sql);
		
	}

	public static function order_select($id) {
		$sql = "SELECT book.title,
					   books_author.name as author,
					   book.price, 
					   book.img_thumb 
				FROM 
					   book 
				LEFT JOIN 
					   books_author
				ON 
					   book.author_id = books_author.id 
				WHERE
					   book.id = ".$id;
				
		return self::select_by_query($sql);
	}

	// updates should come in a form assoc array
	public static function update_img($updates, $table=null, $where_column=null, $where_value=null, $type_id=null) {
		global $db;
		if ($where_column == null && $where_value == null && $type_id == null) {
			$where = " WHERE id=".$db->prep_sql($updates['id']);
		} else {
			$where  = " WHERE ".$where_column." = ".$db->prep_sql($where_value);
			$where .= " AND type_id=".$type_id;
		}

		if ($table == null) {
			$table = static::$table_name;
		} 

		$sql = "UPDATE ".$table." SET ";
		$sql1 = "";
		foreach ($updates as $key => $value) {
			$sql1 .= "`".$db->prep_sql($key)."`"."='".$db->prep_sql($value)."',";
		}
		$sql1 = substr($sql1, 0, strlen($sql1)-1);

		$sql .= $sql1.$where;

		$result = $db->execute_query($sql);
		//$db->close_connection();

		return $sql;
		//return $db->get_affected_rows();
		
	}

	public static function select_cloth_img_of_id($cloth_id) {
		$sql = "SELECT type_id, img FROM clothing_img WHERE cloth_id = ".$cloth_id;

		// this will return objects of images because images are stored in different rows
		$cloth_imgs = self::instanciate($sql);
	
		foreach ($cloth_imgs as $cloth_img) {
			if ($cloth_img->type_id == 1) {
				$img['img_thumb']= $cloth_img->img;
			} elseif ($cloth_img->type_id == 2) {
				$img['img_front'] = $cloth_img->img;
			} elseif ($cloth_img->type_id == 3) {
				$img['img_whole_body'] = $cloth_img->img;
			} elseif ($cloth_img->type_id == 4) {
				$img['img_back'] = $cloth_img->img;
			}
		}
		// since images are stored in different rows. It's hard to merge it into the
		// one row. So the better way is to put it all in one assoc array
		// then retrieve that img according to its key
		return $img;
	}



}

?>