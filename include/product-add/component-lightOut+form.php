<?php
if(isset($_POST['add'])) {
	unset($_POST['add']);
	$table_name = $_POST['table_name'];
	unset($_POST['table_name']);

	DatabaseObject::insert($_POST,$table_name);
} 
?>

<div class='lightOut'>
	<!-- A master quick add form that will change according to the link clicked -->
	<form id='add_new' name='add_new' method='post' action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id'] ?>">
		
		
		<input type='button' id='cancel' value='Cancel' class='btn btn-default'>
		<input type='submit' name='add' value='Add' class='btn btn-default'>
		<input type="hidden" name="table_name" id="table_name">
	</form>
</div>

