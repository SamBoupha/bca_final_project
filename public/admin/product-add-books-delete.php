<?php
	require_once("../../include/initialize.php");
	require_once(INC_PATH.DS."book_object.php");
	if (isset($_GET['id'])) {
		$id = $db->prep_sql($_GET['id']);

		if(BookObject::delete($id)) {
			$_SESSION['report'][0] = "<p class='success'>The book <b>".$_GET['title']."</b>
				has been deleted successfully.</p>";
			header("location: product-add.php?category=Books");
		} else {
			echo "There is an error. Cannot delete the selected book";
		}
	}
?>