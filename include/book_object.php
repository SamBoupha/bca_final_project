<?php
require_once(INC_PATH.DS.'db_connection.php');

class bookObject {
	private $id,
			$title,
			$author,
			$price,
			$quantity,
			$year,
			$length,
			$intro,
			$category,
			$publisher,
			$img_front;
			$img_back;
	protected static $table_name = "books_title";

}

?>