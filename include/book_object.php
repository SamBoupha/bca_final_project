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

	protected static $table_name = "book";

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

	public static function select($limit=null, $public=false, $highlight=false) {

		$limit = $limit == null ? "" : " LIMIT ".$limit;
		// The public page should not have shown all the books in the database
		$public = $public ? " WHERE book.visibility = 1 " :
					 " ORDER BY book.show_at_index_page DESC ";
		// Highlight at index page ?
		$highlight = $highlight ? " AND book.show_at_index_page = 1 " : "";

		$sql = "SELECT 
					book.id,
					book.title,
					books_author.name as author,
					book.price,
					book.img_thumb,
					book.visibility,
					book.show_at_index_page 
	
				FROM book LEFT JOIN books_author
				ON
					book.author_id = books_author.id".$public.$highlight.$limit;

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

	public static function search($values) {
		$sql = "SELECT 
					book.id,
					book.title,
					books_author.name as author,
					book.price,
					book.img_thumb
	
				FROM book 
				LEFT JOIN books_author
				ON
					book.author_id = books_author.id
				WHERE 
					book.visibility = 1 
				AND
					book.id IN (";

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