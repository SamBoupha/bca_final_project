<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'cloth_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {
	$updated_cloth['id'] = $new_cloth_img['cloth_id'] = $_POST['id'];
	$updated_cloth['brand_id'] 	  = htmlspecialchars($_POST['brand']);
	$updated_cloth['name'] 		  = htmlspecialchars($_POST['name']);
	$updated_cloth['price']	      = htmlspecialchars($_POST['price']);
	$updated_cloth['qty_s'] 	  = htmlspecialchars($_POST['qty_s']);
	$updated_cloth['qty_m'] 	  = htmlspecialchars($_POST['qty_m']);
	$updated_cloth['qty_l'] 	  = htmlspecialchars($_POST['qty_l']);
	$updated_cloth['description'] = $_POST['description'];
	$updated_cloth['visibility'] = htmlspecialchars($_POST['visibility']);
	$updated_cloth['show_at_index_page'] = htmlspecialchars($_POST['show_at_index_page']);
	$updated_cloth['category_id'] = $_POST['category'];
	$updated_cloth['section_id']  = $_POST['section'];

	$location = "..".DS."img".DS."clothing".DS;
	$reports = array();

	if(ClothObject::update($updated_cloth)) {
		$reports[] = "<p class='success'>The selected cloth has been updated successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Technical problem. Failed to upload</p>";
	}

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
		
		$new_cloth_img['img'] = htmlspecialchars($file_name);
		
		ClothObject::update($new_cloth_img,'clothing_img', 'cloth_id', $new_cloth_img['cloth_id'], $new_cloth_img['type_id'] = 1);
		
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
	
		$new_cloth_img['img'] = htmlspecialchars($file_name);
		
		ClothObject::update($new_cloth_img,'clothing_img', 'cloth_id', $new_cloth_img['cloth_id'], $new_cloth_img['type_id'] = 2);
	
	}

	if (!empty($_FILES['img_body']['tmp_name'])) {
		$file_name = $_FILES['img_body']['name'];
		$new_file = $location.$_FILES['img_body']['name']; 
		
		if(file_exists($new_file)) {
			
			$file_name = substr($file_name,0,strlen($file_name)-4)."(1)".substr($file_name,strlen($file_name)-4);
			$new_file = $location.$file_name;
		}

		if (!move_uploaded_file($_FILES['img_body']['tmp_name'], $new_file)) {
				$reports[] = "<p class='danger'>Whole body image was failed to upload</p>";
			}
		unlink($location.$_POST['current_img_body']);
		
		$new_cloth_img['img'] = htmlspecialchars($file_name);
		
		ClothObject::update($new_cloth_img,'clothing_img', 'cloth_id', $new_cloth_img['cloth_id'], $new_cloth_img['type_id'] = 3);
		
	}

	
$_SESSION['report'] = $reports;
header("location: product-add.php?category=Clothing");
}

$clothing = ClothObject::select_all($_GET['id']);
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>
<!-- Click quick add and form will appear  -->
<?php include(INC_PATH.DS."product-add".DS."component-lightOut+form.php") ?>
	<section>
		<div class='product-add-book-form'>
		<h2>cloth Editing: Add new cloths</h2>
		<form class='product-add-books' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' method='post' enctype='multipart/form-data'>
			<div>
				<label>Show on first page:</label>
				<select name='show_at_index_page'>
					<?php
						if ($clothing->show_at_index_page == 1) {
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
						if ($clothing->visibility == 1) {
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
				<label>Section:</label><br />
				<select name='section'>
					<?php 
						$sections = ClothObject::select_from_table("clothing_section");
						echo "<option value='0'>Unknown</option>";
						foreach ($sections as $section) {
							echo "<option value='".$section->id;

							if (strpos($section->name,'--')) {
								$section->name = str_replace("--", " ─────", $section->name);
								$section->name = "───── ".$section->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($clothing->section == $section->id) {
								echo " selected ";
							}

							echo ">";
							echo $section->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_section'>+ Quick add new section</a>
			</div>
			<div>
				<label>Category:</label><br />
				<select name='category'>
					<?php 
						$categories = ClothObject::select_from_table("clothing_category");
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

							if ($clothing->category == $category->id) {
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
				<label>Brand:</label><br />
				<select name='brand'>
					<?php 
						$brands = ClothObject::select_from_table("clothing_brand");
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

							if ($clothing->brand == $brand->id) {
								echo " selected ";
							}

							echo ">";
							echo $brand->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_brand'>+ Quick add new brand</a>
			</div>
			<div>
				<label>Name:</label><br />
				<input type='text' name='name' value="<?php echo $clothing->name ?>" placeholder='Name of this clothes'>
			</div>
			<div class='input-price'>
				<label>Price:</label><br />
				<span>Rs.</span><input type="text" name='price' value="<?php echo $clothing->price ?>">
			</div>
			
			<div>
				<label>Quantity: S Size</label><br />
				<input type='text' name='qty_s' value="<?php echo $clothing->qty_s ?>"><br />
			</div>
			<div>
				<label>Quantity: M Size</label><br />
				<input type='text' name='qty_m' value="<?php echo $clothing->qty_m ?>"><br />
			</div>
			<div>
				<label>Quantity: L Size</label><br />
				<input type='text' name='qty_l' value="<?php echo $clothing->qty_l ?>"><br />
			</div>
			<div>
				<label>Product Description</label><br />
				<textarea name='description' cols='100' rows='20'><?php echo $clothing->description ?></textarea>
			</div>
			<div>
				<label>Select Thumbnail Image of the cloth (200x200px):</label>
				<input type='file' name='img_thumb'>
				<input type='hidden' name='current_img_thumb' value='<?php echo $clothing->img_thumb ?>'>
			</div>
			<div>
				<label>Select Front Image of the cloth (400x400px):</label>
				<input type='file' name='img_front'>
				<input type='hidden' name='current_img_front' value='<?php echo $clothing->img_front ?>'>
			</div>
			<div>
				<label>Select Whole body Image of the cloth (400x400px):</label>
			<input type='file' name='img_body'>
			<input type='hidden' name='current_img_whole_body' value='<?php echo $clothing->img_whole_body ?>'>
			</div>
			<input type='hidden' name='id' value='<?php echo $_GET['id'] ?>'>
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
	$('a#new_brand').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" id="name" name="brand" class="name">').insertBefore('input#cancel');
		$('<label>Brand Name:</label><br />').insertBefore('input.name');

			position();
		$('input#table_name').attr("value","clothing_brand");
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