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

	print_r($new_book);


	$location = "..".DS."img".DS."books".DS;
	$report = array();


	if (isset($_FILES['img_thumb']['tmp_name'])) {
		$location .= $_FILES['img_thumb']['name']; 
		if (move_uploaded_file($_FILES['img_thumb']['tmp_name'], $location)) {
			$report[] = "Thumbnail image was uploaded successfully";
			$new_book['img_thumb'] = htmlspecialchars($_POST['img_thumb']);
		} else {
			$report[] = "Thumbnail image was failed to upload";
		}
	}

	if (isset($_FILES['img_front']['tmp_name'])) {
		$location .= $_FILES['img_front']['name']; 
		if (move_uploaded_file($_FILES['img_front']['tmp_name'], $location)) {
			$report[] = "Front image was uploaded successfully";
			$new_book['img_front'] = htmlspecialchars($_POST['img_front']);
		} else {
			$report[] = "Back image was failed to upload";
		}
	}

	if (isset($_FILES['img_back']['tmp_name'])) {
		$location .= $_FILES['img_back']['name']; 
		if (move_uploaded_file($_FILES['img_back']['tmp_name'], $location)) {
			$report[] = "Back image was uploaded successfully";
			$new_book['img_back'] = htmlspecialchars($_POST['img_back']);
		} else {
			$report[] = "Back image was failed to upload";
		}
	}

	if(BookObject::insert($new_book)) {
		echo "Insert successfully";
	} else {
		echo "Technical problems";
	}
}
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<div class='product-add-book-form'>
		<h2>Book Editing: Add new books</h2>
		<form class='product-add-books' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
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
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="">+ Add new author</a>
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
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="">+ Add new category</a>
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
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="">+ Add new publisher</a>
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

<?php include(INC_PATH.DS.'footer-admin.php');?>