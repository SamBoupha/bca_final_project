<?php 
	if(isset($_POST['add'])) {
		$new['name'] = trim($_POST['name']);
		$table_name = $_POST['table_name'];
		if (!empty($new['name'])) {
			if (isset($_POST['about'])) {
				$about = trim($_POST['about']);
				if (!empty($about)) {
					$new['about'] = $about;
				}
			}
			DatabaseObject::insert($new,$table_name);
		}
	} 
?>

<div class='lightOut'>
	<!-- A master quick add form that will change according to the link clicked -->
	<form id='add_new' name='add_new' method='post' action="<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id'] ?>">
		<input type="text" name="name" class="name">
		
		<input type='button' id='cancel' value='Cancel' class='btn btn-default'>
		<input type='submit' name='add' value='Add' class='btn btn-default'>
		<input type="hidden" name="table_name" id="table_name">
	</form>
</div>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">

$( function() {
	function position() {
		$('#add_new').css( "margin-top" ,function() {
			return ($(this).height()+128)/(-2.0);
			}
		);
		$('#add_new').css( "margin-left" ,function() {
			return ($(this).width()+128)/(-2.0);
			}
		);
	};

	// When a link with ID new_author is click the above form should be populated
	// with below elements
	$('a#new_author').click( function() {
		$('div.lightOut').fadeIn();
		$('<label>Author Name:</label><br />').insertBefore('input.name');
		$('<label>About Author:</label><br /><textarea cols="60" rows="10" name="about"></textarea><br /><br /><br />')
			.insertBefore('input#cancel');
			position();
		$('input#table_name').attr("value","books_author");
	});

	$('a#new_category').click( function() {
		$('div.lightOut').fadeIn();
		$('<label>Category Name:</label><br />').insertBefore('input.name');
		position();
		$('input#table_name').attr("value","books_category");
	});

	$('a#new_publisher').click( function() {
		$('div.lightOut').fadeIn();
		$('<label>Publisher Name:</label><br />').insertBefore('input.name');
		position();
		$('input#table_name').attr("value","books_publisher");
	});


	$('input#cancel').click( function() {
		$('div.lightOut').fadeOut();
		// once elements are inserted they will be there so to reuse the form I have 
		// to remove the elements that are specific to a link so that new elements 
		// can be shown
		$('form#add_new label, form#add_new textarea, form#add_new br ').remove();
	});
});
	
</script>