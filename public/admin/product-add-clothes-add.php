<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'cloth_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {

	$new_cloth['brand_id'] = htmlspecialchars($_POST['brand']);
	$new_cloth['name'] = htmlspecialchars($_POST['name']);
	$new_cloth['price'] = htmlspecialchars($_POST['price']);
	$new_cloth['quantity'] = htmlspecialchars($_POST['quantity']);
	$new_cloth['description'] = htmlspecialchars($_POST['description']);

	$location = "..".DS."img".DS."clothing".DS;
	$reports = array();

	if (isset($_FILES['img_thumb']['tmp_name'])) {
		$location .= $_FILES['img_thumb']['name']; 
		if (move_uploaded_file($_FILES['img_thumb']['tmp_name'], $location)) {
			$new_cloth['img_thumb'] = htmlspecialchars($_POST['img_thumb']);
		} else {
			$reports[] = "<p class='danger'>Thumbnail image was failed to upload</p>";
		}
	}

	if (isset($_FILES['img_front']['tmp_name'])) {
		$location .= $_FILES['img_front']['name']; 
		if (move_uploaded_file($_FILES['img_front']['tmp_name'], $location)) {
			$new_cloth['img_front'] = htmlspecialchars($_POST['img_front']);
		} else {
			$reports[] = "<p class='danger'>Front image was failed to upload</p>";
		}
	}

	if (isset($_FILES['img_back']['tmp_name'])) {
		$location .= $_FILES['img_back']['name']; 
		if (move_uploaded_file($_FILES['img_back']['tmp_name'], $location)) {
			$new_cloth['img_back'] = htmlspecialchars($_POST['img_back']);
		} else {
			$reports[] = "<p class='danger'>Back image was failed to upload</p>";
		}
	}

	if(ClothObject::insert($new_cloth)) {
		$reports[] = "<p class='success'>A new cloth has been added successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Technical problem. Failed to upload</p>";
	}

$_SESSION['report'] = $reports;
header("location: product-add.php?category=clothing");
}

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
				<input type='text' name='name' value="<?php echo $_POST['title']?>" placeholder='Name of this clothes'>
			</div>
			<div class='input-price'>
				<label>Price:</label><br />
				<span>Rs.</span><input type="text" name='price'>
			</div>
			
			<div>
				<label>Quantity:</label><br />
				<input type='text' name='quantity'><br />
			</div>
			<div>
				<label>Product Description</label><br />
				<textarea name='description' cols='100' rows='20'></textarea>
			</div>
			<div>
				<label>Select Thumbnail Image of the cloth (200x200px):</label>
				<input type='file' name='img_thumb'>
			</div>
			<div>
				<label>Select Front Image of the cloth (400x400px):</label>
			<input type='file' name='img_front'>
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
	$('a#new_brand').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" id="name" name="name" class="name">').insertBefore('input#cancel');
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