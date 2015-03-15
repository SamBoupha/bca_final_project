<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'wireless_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {

	$updated_mobile['id']       		 = htmlspecialchars($_POST['id']);
	$updated_mobile['manufacturer_id'] 	 = htmlspecialchars($_POST['manufacturer']);
	$updated_mobile['model'] 	    	 = htmlspecialchars($_POST['model']);
	$updated_mobile['cpu_id']    		 = htmlspecialchars($_POST['cpu']);
	$updated_mobile['hdd_id']    		 = htmlspecialchars($_POST['hdd']);
	$updated_mobile['ram_id'] 			 = htmlspecialchars($_POST['ram']);
	$updated_mobile['screen_id']		 = htmlspecialchars($_POST['mornitor']);
	$updated_mobile['os_id'] 	    	 = htmlspecialchars($_POST['os']);
	$updated_mobile['price'] 			 = htmlspecialchars($_POST['price']);
	$updated_mobile['quantity'] 		 = htmlspecialchars($_POST['quantity']);
	$updated_mobile['visibility']  		 = htmlspecialchars($_POST['visibility']);
	$updated_mobile['show_at_index_page']= htmlspecialchars($_POST['show_at_index_page']);
	$updated_mobile['wireless_product_category_id'] = 1;

	$location = "..".DS."img".DS."mobile".DS;
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
		$updated_mobile['img_thumb'] = htmlspecialchars($file_name);
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
		$updated_['img_front'] = htmlspecialchars($file_name);
	}

	if(WirelessObject::update($updated_mobile)) {
		$reports[] = "<p class='success'>The mobile <em><span>".$updated_mobile['model']."</spam></em> has been added successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Failed to add</p>";
	}
	
$_SESSION['report'] = $reports;
header("location: product-add.php?category=Mobiles");

}

$mobile = WirelessObject::select_all($_GET['id']);


?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>
<!-- handle the quick add functionality -->
<?php include_once(INC_PATH.DS."product-add".DS."component-lightOut+form.php") ?>
	<section>
		<div class='product-add-book-form'>
		<h2>mobile Editing:</h2>
		<form class='product-add-books' 
			  action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' 
			  method='post' enctype='multipart/form-data'>
			<div>
				<label>Show on first page:</label>
				<select name='show_at_index_page'>
					<?php
						if ($mobile->show_at_index_page == 1) {
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
						if ($mobile->visibility == 1) {
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
				<select name='manufacturer'>
					<?php 
						$brands = WirelessObject::select_from_table("wireless_product_manufacturer");
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

							if ($mobile->brand == $brand->name) {
								echo " selected ";
							}

							echo ">";
							echo $brand->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_manufacturer'>+ Quick add new brand</a>
			</div>
			<div>
				<label>Model:</label><br />
				<input type='text' name='model' value="<?php echo $mobile->model ?>">
			</div>
			<div>
				<label>CPU:</label><br />
				<select name='cpu'>
					<?php 
						$cpus = WirelessObject::select_from_table("wireless_product_cpu","processor");
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

							if ($mobile->cpu == $cpu->name) {
								echo " selected ";
							}

							echo ">";
							echo $cpu->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_cpu'>+ Quick add new CPU</a>
			</div>
			<div>
				<label>Storage:</label><br />
				<select name='hdd'>
					<?php 
						$hdds = WirelessObject::select_from_table("wireless_product_hdd","internal","external");
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

							if ($mobile->hdd == $hdd->name) {
								echo " selected ";
							}

							echo ">";
							echo "Internal: ".$hdd->name.". ".$hdd->external;
							echo "</option>"; 
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_hdd'>+ Quick add new HDD</a>
			</div>
			<div>
				<label>RAM:</label><br />
				<select name='ram'>
					<?php 
						$rams = WirelessObject::select_from_table("wireless_product_ram","capacity");
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

							if ($mobile->ram == $ram->name) {
								echo " selected ";
							}

							echo ">";
							echo $ram->name;
							echo "</option>";

						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_ram'>+ Quick add new ram</a>
			</div>

			<div>
				<label>Screen:</label><br />
				<select name='mornitor'>
					<?php 
						$screens = WirelessObject::select_from_table("wireless_product_screen","size","type as screen_type","resolution");
						echo "<option value='0'>Unknown</option>";
						foreach ($screens as $screen) {
							echo "<option value='".$screen->id;

							if (strpos($screen->name,'--')) {
								$screen->name = str_replace("--", " ─────", $screen->name);
								$screen->name = "───── ".$screen->name;
								echo "' disabled";
							} else {
								echo "'";
							}

							if ($mobile->screen == $screen->name) {
								echo " selected ";
							}

							echo ">";
							echo $screen->name." inches ".$screen->screen_type." (".$screen->resolution.")";
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_screen'>+ Quick add new mornitor</a>
			</div>
			<div>
				<label>Operating System:</label><br />
				<select name='os'>
					<?php 
						$oss = WirelessObject::select_from_table("wireless_product_os","name");
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

							if ($mobile->os == $os->name) {
								echo " selected ";
							}

							echo ">";
							echo $os->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_os'>+ Quick add new os</a>
			</div>
			<div class='input-price'>
				<label>Price:</label><br />
				<span>Rs.</span><input type="text" name='price' value='<?php echo $mobile->price ?>'>
			</div>
			<div>
				<label>Quantity:</label><br />
				<input type='text' name='quantity' value='<?php echo $mobile->quantity ?>'><br />
			</div>
			
			<!-- Thumbnail upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Thumbnail Image of the mobile (200x200px):</label>
				<input type='file' name='img_thumb'>
			</div>
			<!-- Front cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Front Image of the mobile (400x400px):</label>
				<input type='file' name='img_front'>
			</div>
		
			<input type='hidden' name='id' value='<?php echo $mobile->id ?>'>
			<input type='submit' class='btn btn-default' name='submit' value='UPDATE'>
		</form>
	</div>
	</section>

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
	$('a#new_manufacturer').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeIn();
		$('<input type="text" name="name" class="name">')
				.insertBefore('input#cancel');
		$('<label>Name:</label><br />').insertBefore('input.name');
		
			position();
		$('input#table_name').attr("value","wireless_product_manufacturer");
	});

	$('a#new_cpu').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeIn();
		$('<input type="text" name="processor" class="name" placeholder="Example: 1.2 GHz + Qualcomm Snapdragon 400, Quad Core">')
			.insertBefore('input#cancel');
		$('<label>Processor:</label><br />').insertBefore('input.name');
		position();
		$('input#table_name').attr("value","wireless_product_cpu");
	});

	$('a#new_hdd').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeIn();
		$('<input type="text" name="internal" class="name" placeholder="Example: 8 GB, 16GB, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Internal:</label><br />').insertBefore('input.name');
		$('<label>External:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="external" class="name" placeholder="Example: microSD, upto 32 GB ">')
			.insertBefore('input#cancel');
		
		position();
		$('input#table_name').attr("value","wireless_product_hdd");
	});

	$('a#new_screen').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeIn();
		$('<input type="text" name="size" class="name" placeholder="Example: 4, 5.2, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Inch:</label><br />').insertBefore('input.name');
		$('<label>Type:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="type" class="name" placeholder="Example: IPS LCD Gorilla Glass 3, OLED Etc. ">')
			.insertBefore('input#cancel');
		$('<label>Resolution:</label><br />').insertBefore('input#cancel');
		$('<input type="text" name="resolution" class="name" placeholder="Example: 1280x720 Etc. ">')
			.insertBefore('input#cancel');
		
		position();
		$('input#table_name').attr("value","wireless_product_screen");
	});

	$('a#new_os').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeIn();
		$('<input type="text" name="name" class="name" placeholder="Example: iOS7, Android v5.0 (Lollipop), etc. ">')
			.insertBefore('input#cancel');
		$('<label>Name:</label><br />').insertBefore('input.name');
		
		position();
		$('input#table_name').attr("value","wireless_product_os");
	});

	$('a#new_ram').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeIn();
		$('<input type="text" name="capacity" class="name" placeholder="Example: 1GB, 2GB, etc. ">')
			.insertBefore('input#cancel');
		$('<label>Capacity:</label><br />').insertBefore('input.name');
		
		position();
		$('input#table_name').attr("value","wireless_product_ram");
	});

	$('input#cancel').click( function(e) {
		 e.preventDefault();
		$('div.lightOut').fadeOut();
		// once elements are inserted they will be there so to reuse the form I have 
		// to remove the elements that are specific to a link so that new elements 
		// can be shown
		$('form#add_new label, form#add_new textarea, form#add_new br, form#add_new input[type="text"] ').remove();
	});
});
	
</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>
