<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'book_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {

	$updated_book['id']           = htmlspecialchars($_POST['id']);
	$updated_book['title'] 		  = htmlspecialchars($_POST['title']);
	$updated_book['author_id'] 	  = htmlspecialchars($_POST['author']);
	$updated_book['category_id']  = htmlspecialchars($_POST['category']);
	$updated_book['publisher_id'] = htmlspecialchars($_POST['publisher']);
	$updated_book['price'] 		  = htmlspecialchars($_POST['price']);
	$updated_book['length'] 	  = htmlspecialchars($_POST['length']);
	$updated_book['year'] 		  = htmlspecialchars($_POST['year']);
	$updated_book['quantity'] 	  = htmlspecialchars($_POST['quantity']);
	$updated_book['intro'] 		  = htmlspecialchars($_POST['intro']);
	$updated_book['visibility']   = htmlspecialchars($_POST['visibility']);
$updated_book['show_at_index_page']   = htmlspecialchars($_POST['show_at_index_page']);

	$location = "..".DS."img".DS."book".DS;
	$reports = array();

	if (!empty($_FILES['img_thumb']['tmp_name'])) {
		$file_name = $_FILES['img_thumb']['name'];
		$new_file = $location.$file_name; 
		
		if(file_exists($new_file)) {
			
			$file_name = substr($file_name,0,strlen($file_name)-4)."(1)".substr($file_name,strlen($file_name)-4);
			$new_file = $location.$file_name;
		}
		
		if (!move_uploaded_file($_FILES['img_thumb']['tmp_name'], $new_file)) {
			$reports[] = "<p class='danger'>Thumbnail image was failed to upload</p>";
		}
		unlink($location.$_POST['current_img_thumb']);
		$updated_book['img_thumb'] = htmlspecialchars($file_name);
	}	

	if (!empty($_FILES['img_front']['tmp_name'])) {
		$file_name = $_FILES['img_front']['name'];
		$new_file = $location.$_FILES['img_front']['name']; 
		if(file_exists($new_file)) {

			$file_name = substr($file_name,0,strlen($file_name)-4)."(1)".substr($file_name,strlen($file_name)-4);
			$new_file = $location.$file_name;
		}
		
		if (!move_uploaded_file($_FILES['img_front']['tmp_name'], $new_file)) {
			$reports[] = "<p class='danger'>Front image was failed to upload</p>";
		}
		unlink($location.$_POST['current_img_front']);
		$updated_book['img_front'] = htmlspecialchars($file_name);
	}

	if (!empty($_FILES['img_back']['tmp_name'])) {
		$file_name = $_FILES['img_back']['name'];
		$new_file = $location.$_FILES['img_back']['name']; 
		
		if(file_exists($new_file)) {
			
			$file_name = substr($file_name,0,strlen($file_name)-4)."(1)".substr($file_name,strlen($file_name)-4);
			$new_file = $location.$file_name;
		}

		if (!move_uploaded_file($_FILES['img_back']['tmp_name'], $new_file)) {
				$reports[] = "<p class='danger'>Back image was failed to upload</p>";
			}
		unlink($location.$_POST['current_img_back']);
		$updated_book['img_back'] = htmlspecialchars($file_name);
	}

	if($q=BookObject::update($updated_book)) {
		$reports[] = "<p class='success'>The book <em><span>".$updated_book['title']."</spam></em> has been editted successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Failed to edit</p>";
	}

	echo $q;


$_SESSION['report'] = $reports;
header("location: product-add.php?category=Books");

}

$book = BookObject::select_all($_GET['id']);
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>
<!-- handle the quick add functionality -->
<?php include_once(INC_PATH.DS."product-add".DS."component-lightOut+form.php") ?>
	<section>
		<div class='product-add-book-form'>
		<h2>Book Editing: Edit a book</h2>
		<form class='product-add-books' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
			<div>
				<label>Show on first page:</label>
				<select name='show_at_index_page'>
					<?php
						if ($book->show_at_index_page == 1) {
							$show = "selected";
						} else {
							$hide = "selected";
						}
					?>
					<option value='0' <?php echo $hide ?> >NO</option>	
					<option value='1' <?php echo $show ?> >YES</option>
				</select>
			</div>
			<div>
				<label>Visibility:</label>
				<select name='visibility'>
					<?php
						if ($book->visibility == 1) {
							$show = "selected";
						} else {
							$hide = "selected";
						}
					?>
					<option value='0' <?php echo $hide ?> class='danger'>HIDE</option>	
					<option value='1' <?php echo $show ?> class='success'>SHOW</option>
				</select>
			</div>
			<div>
				<label>Title:</label><br />
				<input type='text' name='title' value="<?php echo $book->title ?>">
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

							if ($book->author == $author->name) {
								echo " selected ";
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

							if ($book->category == $category->name) {
								echo " selected ";
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
							echo "<option value='".$publisher->id;

							if (strpos($publisher->name,'--')) {
								$publisher->name = str_replace("--", " ─────", $publisher->name);
								$publisher->name = "───── ".$publisher->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($book->publisher == $publisher->name) {
								echo " selected ";
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
				<span>Rs.</span><input type="text" name='price' value='<?php echo $book->price ?>'>
			</div>
			<div>
				<label>Number of Page:</label><br />
				<input type='text' name='length' value='<?php echo $book->length ?>'><br />
			</div>
			<div>
				<label>Publication Year:</label><br />
				<input type='text' name='year' value='<?php echo $book->year ?>'><br />
			</div>
			<div>
				<label>Quantity:</label><br />
				<input type='text' name='quantity' value='<?php echo $book->quantity ?>'><br />
			</div>
			<div>
				<label>Intro:</label><br />
				<textarea name='intro' cols='100' rows='20'><?php echo $book->intro ?></textarea>
			</div>
			<!-- Thumbnail upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Thumbnail Image of the book (200x200px):</label>
				<input type='file' name='img_thumb'>
				<input type='hidden' name='current_img_thumb' value='<?php echo $book->img_thumb ?>'>
			</div>
			<img src='../img/book/<?php 
						echo $book->img_thumb == null ? "product_image_not_available_200x200.jpg" : $book->img_thumb
						?>'><br /><br />
			
			<!-- Front cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Front Image of the book (400x400px):</label>
				<input type='file' name='img_front'>
				<input type='hidden' name='current_img_front' value='<?php echo $book->img_front ?>'>
			</div>
			<img src='../img/book/<?php echo $book->img_front == null ? "product_image_not_available_400x400.jpg" : $book->img_front ?>'><br /><br />
			
			<!-- Back cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Back Image of the book (400x400px):</label>
				<input type='file' name='img_back'>
				<input type='hidden' name='current_img_back' value='<?php echo $book->img_back ?>'>
			</div>
			<img src='../img/book/<?php echo $book->img_back == null ? "product_image_not_available_400x400.jpg" : $book->img_back ?>'><br /><br />

			<input type='hidden' name='id' value='<?php echo $book->id ?>'>
			<input type='submit' class='btn btn-default' name='submit' value='Update'>
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