<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'computer_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {

	$updated_computer['id']          = htmlspecialchars($_POST['id']);
	$updated_computer['brand_id'] 	 = htmlspecialchars($_POST['brand']);
	$updated_computer['model'] 	     = htmlspecialchars($_POST['model']);
	$updated_computer['cpu_id']      = htmlspecialchars($_POST['cpu']);
	$updated_computer['hdd_id']      = htmlspecialchars($_POST['hdd']);
	$updated_computer['ram_id'] 	 = htmlspecialchars($_POST['ram']);
	$updated_computer['graphic_id']  = htmlspecialchars($_POST['graphic']);
	$updated_computer['mornitor_id'] = htmlspecialchars($_POST['mornitor']);
	$updated_computer['os'] 	     = htmlspecialchars($_POST['os']);
	$updated_computer['price'] 		 = htmlspecialchars($_POST['price']);
	$updated_computer['mfg'] 		 = htmlspecialchars($_POST['mfg']);
	$updated_computer['quantity'] 	 = htmlspecialchars($_POST['quantity']);
	$updated_computer['visibility']  = htmlspecialchars($_POST['visibility']);
$updated_computer['show_at_index_page']  = htmlspecialchars($_POST['show_at_index_page']);

	$location = "..".DS."img".DS."computer".DS;
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
		$updated_computer['img_thumb'] = htmlspecialchars($file_name);
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
		$updated_computer['img_front'] = htmlspecialchars($file_name);
	}

	if (!empty($_FILES['img_left_side']['tmp_name'])) {
		$file_name = $_FILES['img_left_side']['name'];
		$new_file = $location.$_FILES['img_left_side']['name']; 
		
		if(file_exists($new_file)) {
			
			$file_name = substr($file_name,0,strlen($file_name)-4)."(1)".substr($file_name,strlen($file_name)-4);
			$new_file = $location.$file_name;
		}

		if (!move_uploaded_file($_FILES['img_left_side']['tmp_name'], $new_file)) {
				$reports[] = "<p class='danger'>Back image was failed to upload</p>";
			}
		unlink($location.$_POST['current_img_left_side']);
		$updated_computer['img_left_side'] = htmlspecialchars($file_name);
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
		$updated_computer['img_back'] = htmlspecialchars($file_name);
	}

	if(ComputerObject::update($updated_computer)) {
		$reports[] = "<p class='success'>The computer <em><span>".$updated_computer['model']."</spam></em> has been editted successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Failed to edit</p>";
	}

	$_SESSION['report'] = $reports;
	header("location: product-add.php?category=Computers");

}

$computer = ComputerObject::select_all($_GET['id']);

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
				<select name='brand'>
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
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_brand'>+ Quick add new brand</a>
			</div>
			<div>
				<label>Model:</label><br />
				<input type='text' name='model' value="<?php echo $computer->model ?>">
			</div>
			<div>
				<label>CPU:</label><br />
				<select name='cpu'>
					<?php 
						$cpus = ComputerObject::select_from_table("computer_spec_cpu","family","chip_model","min_clock_speed","max_clock_speed","cache");
						echo "<option value='0'>Unknown</option>";
						foreach ($cpus as $cpu) {
							echo "<option value='".$cpu->id;

							if (strpos($cpu->name,'--')) {
								$cpu->name = str_replace("--", " ─────", $cpu->name);
								$cpu->name = "───── ".$cpu->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->cpu == $cpu->name) {
								echo " selected ";
							}

							echo ">";
							echo $cpu->name." ".$cpu->chip_model." ".$cpu->min_clock_speed." ".$cpu->max_clock_speed." ".$cpu->cache;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_cpu'>+ Quick add new CPU</a>
			</div>
			<div>
				<label>HDD:</label><br />
				<select name='hdd'>
					<?php 
						$hdds = ComputerObject::select_from_table("computer_spec_hdd","capacity","hdd_type");
						echo "<option value='0'>Unknown</option>";
						foreach ($hdds as $hdd) {
							echo "<option value='".$hdd->id;

							if (strpos($hdd->name,'--')) {
								$hdd->name = str_replace("--", " ─────", $hdd->name);
								$hdd->name = "───── ".$hdd->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->hdd == $hdd->name) {
								echo " selected ";
							}

							echo ">";
							echo $hdd->name." ".$hdd->hdd_type;
							echo "</option>"; 
							print_r($hdd);
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_hdd'>+ Quick add new HDD</a>
			</div>
			<div>
				<label>RAM:</label><br />
				<select name='ram'>
					<?php 
						$rams = ComputerObject::select_from_table("computer_spec_ram","capacity","ram_type","ram_frequency");
						echo "<option value='0'>Unknown</option>";
						foreach ($rams as $ram) {
							echo "<option value='".$ram->id;

							if (strpos($ram->name,'--')) {
								$ram->name = str_replace("--", " ─────", $ram->name);
								$ram->name = "───── ".$ram->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->ram == $ram->name) {
								echo " selected ";
							}

							echo ">";
							echo $ram->name." ".$ram->ram_type." ".$ram->ram_frequency;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_ram'>+ Quick add new ram</a>
			</div>
			<div>
				<label>Graphic Card:</label><br />
				<select name='graphic'>
					<?php 
						$graphics = ComputerObject::select_from_table("computer_spec_graphic","processor");
						echo "<option value='0'>Unknown</option>";
						foreach ($graphics as $graphic) {
							echo "<option value='".$graphic->id;

							if (strpos($graphic->name,'--')) {
								$graphic->name = str_replace("--", " ─────", $graphic->name);
								$graphic->name = "───── ".$graphic->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->graphic == $graphic->name) {
								echo " selected ";
							}

							echo ">";
							echo $graphic->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_graphic'>+ Quick add new graphic</a>
			</div>
			<div>
				<label>Mornitor:</label><br />
				<select name='mornitor'>
					<?php 
						$mornitors = ComputerObject::select_from_table("computer_spec_mornitor","inch","resolution");
						echo "<option value='0'>Unknown</option>";
						foreach ($mornitors as $mornitor) {
							echo "<option value='".$mornitor->id;

							if (strpos($mornitor->name,'--')) {
								$mornitor->name = str_replace("--", " ─────", $mornitor->name);
								$mornitor->name = "───── ".$mornitor->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->mornitor == $mornitor->name) {
								echo " selected ";
							}

							echo ">";
							echo $mornitor->name." inch (".$mornitor->resolution.")";
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_mornitor'>+ Quick add new mornitor</a>
			</div>
			<div>
				<label>Operating System:</label><br />
				<select name='os'>
					<?php 
						$oss = ComputerObject::select_from_table("computer_spec_os","name","architecture");
						echo "<option value='0'>Unknown</option>";
						foreach ($oss as $os) {
							echo "<option value='".$os->id;

							if (strpos($os->name,'--')) {
								$os->name = str_replace("--", " ─────", $os->name);
								$os->name = "───── ".$os->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($computer->os == $os->name) {
								echo " selected ";
							}

							echo ">";
							echo $os->name." ".$os->architecture;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_os'>+ Quick add new os</a>
			</div>
			<div class='input-price'>
				<label>Price:</label><br />
				<span>Rs.</span><input type="text" name='price' value='<?php echo $computer->price ?>'>
			</div>
			<div>
				<label>Manufactoring Year:</label><br />
				<input type='text' name='mfg' value='<?php echo $computer->mfg ?>'><br />
			</div>
			<div>
				<label>Quantity:</label><br />
				<input type='text' name='quantity' value='<?php echo $computer->quantity ?>'><br />
			</div>
			
			<!-- Thumbnail upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Thumbnail Image of the computer (200x200px):</label>
				<input type='file' name='img_thumb'>
				<input type='hidden' name='current_img_thumb' value='<?php echo $computer->img_thumb ?>'>
			</div>
			<img src='../img/computer/<?php 
						echo $computer->img_thumb == null ? "product_image_not_available_200x200.jpg" : $computer->img_thumb
						?>'><br /><br />
			
			<!-- Front cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Front Image of the computer (400x400px):</label>
				<input type='file' name='img_front'>
				<input type='hidden' name='current_img_front' value='<?php echo $computer->img_front ?>'>
			</div>
			<img src='../img/computer/<?php echo $computer->img_front == null ? "product_image_not_available_400x400.jpg" : $computer->img_front ?>'><br /><br />
			
			<!-- Side imgae -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Side Image of the computer (400x400px):</label>
				<input type='file' name='img_left_side'>
				<input type='hidden' name='current_img_left_side' value='<?php echo $computer->img_left_side ?>'>
			</div>
			<img src='../img/computer/<?php echo $computer->img_left_side == null ? "product_image_not_available_400x400.jpg" : $computer->img_left_side ?>'><br /><br />
			
			<!-- Back cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Back Image of the computer (400x400px):</label>
				<input type='file' name='img_back'>
				<input type='hidden' name='current_img_back' value='<?php echo $computer->img_back?>'>
			</div>
			<img src='../img/computer/<?php echo $computer->img_back == null ? "product_image_not_available_400x400.jpg" : $computer->img_back ?>'><br /><br />

			<input type='hidden' name='id' value='<?php echo $computer->id ?>'>
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
		$('<input type="text" name="name" class="name">')
				.insertBefore('input#cancel');
		$('<label>Name:</label><br />').insertBefore('input.name');
		
			position();
		$('input#table_name').attr("value","computer_brand");
	});

	$('a#new_cpu').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" name="family" class="name" placeholder="Example: Intel Core i7(4th Gen) Haswell">')
			.insertBefore('input#cancel');
		$('<label>Family Name:</label><br />').insertBefore('input.name');
		$('<label>Chip Model:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="chip_model" class="name" placeholder="Example: 4510U, 3360M, etc.">')
			.insertBefore('input#cancel');
		$('<label>Min clock speed:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="min_clock_speed" class="name" placeholder="Example: 2GHz with turbo boost upto">')
			.insertBefore('input#cancel');
		$('<label>(optional)Max Speed:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="max_clock_speed" class="name" placeholder="3.5GHz">')
			.insertBefore('input#cancel');
		$('<label>Cache:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="cache" class="name" placeholder="Example: 4MB, 8MB, etc.">')
			.insertBefore('input#cancel');
		position();
		$('input#table_name').attr("value","computer_spec_cpu");
	});

	$('a#new_graphic').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" name="capacity" class="name" placeholder="Example: 2GB, 4GB, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Capacity:</label><br />').insertBefore('input.name');
		$('<label>Processor:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="processor" class="name" placeholder="Example: NVIDIA GeForce GT 840M ">')
			.insertBefore('input#cancel');
		$('<label>Type:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="type" class="name" placeholder="Example: DDR3 ">')
			.insertBefore('input#cancel');
		position();
		$('input#table_name').attr("value","computer_spec_graphic");
	});

	$('a#new_hdd').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" name="capacity" class="name" placeholder="Example: 1TB, 500GB, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Capacity:</label><br />').insertBefore('input.name');
		$('<label>HDD Type:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="hdd_type" class="name" placeholder="Example: SATA, SSD, Etc. ">')
			.insertBefore('input#cancel');
		
		position();
		$('input#table_name').attr("value","computer_spec_hdd");
	});

	$('a#new_mornitor').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" name="inch" class="name" placeholder="Example: 13.3, 15.6, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Inch:</label><br />').insertBefore('input.name');
		$('<label>Resolution:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="resolution" class="name" placeholder="Example: 1280x800 Etc. ">')
			.insertBefore('input#cancel');
		
		position();
		$('input#table_name').attr("value","computer_spec_mornitor");
	});

	$('a#new_os').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" name="name" class="name" placeholder="Example: Windows 7, Mac OSX Yosimite, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Name:</label><br />').insertBefore('input.name');
		$('<label>Architecture:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="architecture" class="name" placeholder="Example: 64 Bit, 32 Bit, Etc. ">')
			.insertBefore('input#cancel');
		
		position();
		$('input#table_name').attr("value","computer_spec_os");
	});

	$('a#new_ram').click( function() {
		$('div.lightOut').fadeIn();
		$('<input type="text" name="capacity" class="name" placeholder="Example: 4GB, 8GB, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Capacity:</label><br />').insertBefore('input.name');
		$('<label>Ram frequency:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="ram_frequency" class="name" placeholder="Example: 1600MHz ">')
			.insertBefore('input#cancel');
		$('<label>Ram type:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="ram_type" class="name" placeholder="Example: DDR3, DDR5, etc. ">')
			.insertBefore('input#cancel');
		
		position();
		$('input#table_name').attr("value","computer_spec_ram");
	});

	$('input#cancel').click( function() {
		$('div.lightOut').fadeOut();
		// once elements are inserted they will be there so to reuse the form I have 
		// to remove the elements that are specific to a link so that new elements 
		// can be shown
		$('form#add_new label, form#add_new textarea, form#add_new br, form#add_new input[type="text"] ').remove();
	});
});
	
</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>
