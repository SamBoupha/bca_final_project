<?php
require_once(INC_PATH.DS.'db_connection.php');

class BookObject extends DatabaseObject {

	public 	$id,
			$title,
			$author,
			$author_about,
			$price,
			$quantity,
			$year,
			$length,
			$intro,
			$category_id,
			$publisher_id,
			$img_front,
			$img_back,
			$img_thumb,
			$visibility,
			$show_at_index_page;

	protected static $table_name = "books_title";

	public static function select_all($id) {
		global $db;

		$sql = "select 
					books_title.id, 
					books_title.title,
					books_title.price, 
					books_title.quantity, 
					books_title.year, 
					books_title.length, 
					books_title.intro, 
					books_author.name as author,
					books_author.about as author_about, 
					books_category.name as category, 
					books_publisher.name as publisher, 
					books_title.img_front, 
					books_title.img_back,
					books_title.img_thumb,
					books_title.visibility,
					books_title.show_at_index_page 
				from 
					books_title, 
					books_author, 
					books_category, 
					books_publisher 
				where 
					books_title.author_id = books_author.id 
				and 
					books_title.category_id = books_category.id 
				and 
					books_title.publisher_id = books_publisher.id
				and 
					books_title.id = ";
			$sql .= $id;

		return self::instanciate($sql);

	}

	public static function select($limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " WHERE books_title.visibility = 1 " :
					 " ORDER BY books_title.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND books_title.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					books_title.id,
					books_title.title,
					books_author.name as author,
					books_title.price,
					books_title.img_thumb,
					books_title.visibility,
					books_title.show_at_index_page 
	
				FROM books_title LEFT JOIN books_author
				ON
					books_title.author_id = books_author.id".$public.$highlight.$limit;

		return self::instanciate($sql);
		
	}

}

?>