<?php
	require_once("../../include/initialize.php");
	require_once(INC_PATH.DS."book_object.php");
	if(!$session->is_logged_in()) header("location: login.php");
	
	if (isset($_GET['id'])) {
		$id = $db->prep_sql($_GET['id']);

		if(BookObject::delete($id)) {
			$_SESSION['report'][0] = "<p class='success'>The book <b>".$_GET['title']."</b>
				with id=".$id." has been deleted successfully.</p>";
			
		} else {
			$_SESSION['report'][0] = "<p class='danger'>There is an error. Cannot delete the selected book 
			with id = ".$id."</p>";
		}

		header("location: product-add.php?category=Books");
	}
?>