<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'book_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {

	$new_book['title'] = htmlspecialchars($_POST['title']);
	$new_book['author_id'] = htmlspecialchars($_POST['author']);
	$new_book['category_id'] = htmlspecialchars($_POST['category']);
	$new_book['publisher_id'] = htmlspecialchars($_POST['publisher']);
	$new_book['price'] = htmlspecialchars($_POST['price']);
	$new_book['length'] = htmlspecialchars($_POST['length']);
	$new_book['year'] = htmlspecialchars($_POST['year']);
	$new_book['quantity'] = htmlspecialchars($_POST['quantity']);
	$new_book['intro'] = htmlspecialchars($_POST['intro']);

	$location = "..".DS."img".DS."book".DS;
	$reports = array();

	if (isset($_FILES['img_thumb']['tmp_name'])) {
		$location .= $_FILES['img_thumb']['name']; 
		if (move_uploaded_file($_FILES['img_thumb']['tmp_name'], $location)) {
			$new_book['img_thumb'] = htmlspecialchars($_POST['img_thumb']);
		} else {
			$reports[] = "<p class='danger'>Thumbnail image was failed to upload</p>";
		}
	}

	if (isset($_FILES['img_front']['tmp_name'])) {
		$location .= $_FILES['img_front']['name']; 
		if (move_uploaded_file($_FILES['img_front']['tmp_name'], $location)) {
			$new_book['img_front'] = htmlspecialchars($_POST['img_front']);
		} else {
			$reports[] = "<p class='danger'>Front image was failed to upload</p>";
		}
	}

	if (isset($_FILES['img_back']['tmp_name'])) {
		$location .= $_FILES['img_back']['name']; 
		if (move_uploaded_file($_FILES['img_back']['tmp_name'], $location)) {
			$new_book['img_back'] = htmlspecialchars($_POST['img_back']);
		} else {
			$reports[] = "<p class='danger'>Back image was failed to upload</p>";
		}
	}

	if(BookObject::insert($new_book)) {
		$reports[] = "<p class='success'>A new book has been added successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Technical problem. Failed to upload</p>";
	}

$_SESSION['report'] = $reports;
header("location: product-add.php?category=Books");
}

?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>
<!-- Click quick add and form will appear  -->
<?php include(INC_PATH.DS."product-add".DS."component-lightOut+form.php") ?>
	<section>
		<div class='product-add-book-form'>
		<h2>Book Editing: Add new books</h2>
		<form class='product-add-books' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
			<div>
				<label>Show on first page:</label>
				<select name='show_at_index_page'>
					<option value='0' > NO </option>	
					<option value='1' > YES </option>
				</select>
			</div>
			<div>
				<label>Visibility:</label>
				<select name='visibility'>
					<option value='0' class='danger'>HIDE</option>	
					<option value='1' class='success'>SHOW</option>
				</select>
			</div>
			<div>
				<label>Title:</label><br />
				<input type='text' name='title' value="<?php echo $_POST['title']?>" placeholder='Title of a book'>
			</div>
			<div>
				<label>Author:</label><br />
				<select name='author'>
					<?php 
						$authors = BookObject::select_from_table("books_author");
						echo "<option value='0'>Unknown</option>";
						foreach ($authors as $author) {
							echo "<option value='".$author->id;

							if (strpos($author->name,'--')) {
								$author->name = str_replace("--", " ─────", $author->name);
								$author->name = "───── ".$author->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							echo ">";
							echo $author->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_author'>+ Quick add new author</a>
			</div>
			<div>
				<label>Category:</label><br />
				<select name='category'>
					<?php 
						$categories = BookObject::select_from_table("books_category");
						echo "<option value='0'>Unknown</option>";
						foreach ($categories as $category) {
							echo "<option value='".$category->id;

							if (strpos($category->name,'--')) {
								$category->name = str_replace("--", " ─────", $category->name);
								$category->name = "───── ".$category->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							echo ">";
							echo $category->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_category'>+ Quick add new category</a>
			</div>
			<div>
				<label>Publisher:</label><br />
				<select name='publisher'>
					<?php 
						$publishers = BookObject::select_from_table("books_publisher");
						echo "<option value='0'>Unknown</option>";
						foreach ($publishers as $publisher) {
							echo "<option value='".$category->id;

							if (strpos($publisher->name,'--')) {
								$publisher->name = str_replace("--", " ─────", $publisher->name);
								$publisher->name = "───── ".$publisher->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							echo ">";
							echo $publisher->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_publisher'>+ Quick add new publisher</a>
			</div>
			<div class='input-price'>
				<label>Price:</label><br />
				<span>Rs.</span><input type="text" name='price'>
			</div>
			<div>
				<label>Number of Page:</label><br />
				<input type='text' name='length'><br />
			</div>
			<div>
				<label>Publication Year:</label><br />
				<input type='text' name='year'><br />
			</div>
			<div>
				<label>Quantity:</label><br />
				<input type='text' name='quantity'><br />
			</div>
			<div>
				<label>Intro:</label><br />
				<textarea name='intro' cols='100' rows='20'></textarea>
			</div>
			<div>
				<label>Select Thumbnail Image of the book (200x200px):</label>
				<input type='file' name='img_thumb'>
			</div>
			<div>
				<label>Select Front Image of the book (400x400px):</label>
			<input type='file' name='img_front'>
			</div>
			<div>
				<label>Select Back Image of the book (400x400px):</label>
				<input type='file' name='img_back'>
			</div>
			<input type='submit' class='btn btn-default' name='submit' value='Upload'>
		</form>
	</div>
	</section>
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
		console.log('hi');
		$('div.lightOut').fadeIn();
		$('<input type="text" id="name" name="name" class="name">').insertBefore('input#cancel');
		$('<label>Author Name:</label><br />').insertBefore('input.name');
		$('<label>About Author:</label><br /><textarea cols="60" rows="10" name="about"></textarea><br /><br /><br />')
			.insertBefore('input#cancel');
			position();
		$('input#table_name').attr("value","books_author");
	});

	$('a#new_category').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" id="name" name="name" class="name">').insertBefore('input#cancel');
		$('<label>Category Name:</label><br />').insertBefore('input.name');
		position();
		$('input#table_name').attr("value","books_category");
	});

	$('a#new_publisher').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" id="name" name="name" class="name">').insertBefore('input#cancel');
		$('<label>Publisher Name:</label><br />').insertBefore('input.name');
		position();
		$('input#table_name').attr("value","books_publisher");
	});


	$('input#cancel').click( function() {
		$('div.lightOut').fadeOut();
		// once elements are inserted they will be there so to reuse the form I have 
		// to remove the elements that are specific to a link so that new elements 
		// can be shown
		$('form#add_new label, form#add_new textarea, form#add_new br, form#add_new input#name ').remove();
	});
});

</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>