<?php
require_once(INC_PATH.DS.'db_connection.php');

class ClothObject extends DatabaseObject {

	public 	$id,
			$section,
			$category,
			$brand,
			$name,
			$price,
			$description,
			$img_thumb,
			$img_front,
			$img_whole,
			$visibility,
			$show_at_index_page;

	protected static $table_name = "clothing";

	public static function select_all($id) {
		global $db;

		$sql = "select 
					book.id, 
					book.title,
					book.price, 
					book.quantity, 
					book.year, 
					book.length, 
					book.intro, 
					books_author.name as author,
					books_author.about as author_about, 
					books_category.name as category, 
					books_publisher.name as publisher, 
					book.img_front, 
					book.img_back,
					book.img_thumb,
					book.visibility,
					book.show_at_index_page 
				from 
					book, 
					books_author, 
					books_category, 
					books_publisher 
				where 
					book.author_id = books_author.id 
				and 
					book.category_id = books_category.id 
				and 
					book.publisher_id = books_publisher.id
				and 
					book.id = ";
			$sql .= $id;

		return self::instanciate($sql);

	}

	public static function select($category_id, $section_id, $limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " WHERE clothing.visibility = 1 " :
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

}

?>