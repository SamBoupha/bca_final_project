<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'computer_object.php');
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

	$location = "..".DS."img".DS."books".DS;
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

	if(BookObject::update($updated_book)) {
		$reports[] = "<p class='success'>The book <em><span>".$updated_book['title']."</spam></em> has been editted successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Technical problem. Failed to edit</p>";
	}

	$_SESSION['report'] = $reports;
	header("location: product-add.php?category=Books");

}

$computer = ComputerObject::select_all_by_id($_GET['id']);
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>
<!-- handle the quick add functionality -->
<?php include_once(INC_PATH.DS."product-add".DS."component-lightOut+form.php") ?>
	<section>
		<div class='product-add-book-form'>
		<h2>Computer Editing: Edit a computer</h2>
		<form class='product-add-books' 
			  action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' 
			  method='post' enctype='multipart/form-data'>
			<div>
				<label>Show on first page:</label>
				<select name='show_at_index_page'>
					<?php
						if ($computer->show_at_index_page == 1) {
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
						if ($computer->visibility == 1) {
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
				<label>Brand:</label><br />
				<select name='author'>
					<?php 
						$brands = ComputerObject::select_from_table("computer_brand");
						echo "<option value='0'>Unknown</option>";
						foreach ($brands as $brand) {
							echo "<option value='".$brand->id;

							if (strpos($brand->name,'--')) {
								$brand->name = str_replace("--", " ─────", $brand->name);
								$brand->name = "───── ".$brand->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->brand == $brand->name) {
								echo " selected ";
							}

							echo ">";
							echo $brand->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_author'>+ Quick add new author</a>
			</div>
			<div>
				<label>Model:</label><br />
				<input type='text' name='title' value="<?php echo $book->title ?>">
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
							echo "<option value='".$category->id;

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
			<img src='../img/books/<?php 
						echo $book->img_thumb == null ? "product_image_not_available_200x200.jpg" : $book->img_thumb
						?>'><br /><br />
			
			<!-- Front cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Front Image of the book (400x400px):</label>
				<input type='file' name='img_front'>
				<input type='hidden' name='current_img_front' value='<?php echo $book->img_front ?>'>
			</div>
			<img src='../img/books/<?php echo $book->img_front == null ? "product_image_not_available_400x400.jpg" : $book->img_front ?>'><br /><br />
			
			<!-- Back cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Back Image of the book (400x400px):</label>
				<input type='file' name='img_back'>
				<input type='hidden' name='current_img_back' value='<?php echo $book->img_back ?>'>
			</div>
			<img src='../img/books/<?php echo $book->img_back == null ? "product_image_not_available_400x400.jpg" : $book->img_back ?>'><br /><br />

			<input type='hidden' name='id' value='<?php echo $book->id ?>'>
			<input type='submit' class='btn btn-default' name='submit' value='Upload'>
		</form>
	</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>