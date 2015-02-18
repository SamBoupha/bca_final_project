<?php 
require_once("../../include/initialize.php");
require_once(INC_PATH.DS.'computer_object.php');
if(!$session->is_logged_in()) header("location: login.php");

if (isset($_POST['submit'])) {

	$computer['id']       		     = htmlspecialchars($_POST['id']);
	$computer['brand_id'] 			 = htmlspecialchars($_POST['brand']);
	$computer['model'] 	    		 = htmlspecialchars($_POST['model']);
	$computer['cpu_id']    		     = htmlspecialchars($_POST['cpu']);
	$computer['hdd_id']    		 	 = htmlspecialchars($_POST['hdd']);
	$computer['ram_id'] 			 = htmlspecialchars($_POST['ram']);
	$computer['graphic_id'] 		 = htmlspecialchars($_POST['graphic']);
	$computer['mornitor_id']		 = htmlspecialchars($_POST['mornitor']);
	$computer['os'] 	    		 = htmlspecialchars($_POST['os']);
	$computer['price'] 				 = htmlspecialchars($_POST['price']);
	$computer['mfg'] 				 = htmlspecialchars($_POST['mfg']);
	$computer['quantity'] 			 = htmlspecialchars($_POST['quantity']);
	$computer['visibility']  		 = htmlspecialchars($_POST['visibility']);
	$computer['show_at_index_page']  = htmlspecialchars($_POST['show_at_index_page']);

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
		$computer['img_thumb'] = htmlspecialchars($file_name);
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
		$computer['img_front'] = htmlspecialchars($file_name);
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
		$computer['img_left_side'] = htmlspecialchars($file_name);
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
		$computer['img_back'] = htmlspecialchars($file_name);
	}

	if(ComputerObject::insert($computer)) {
		$reports[] = "<p class='success'>The computer <em><span>".$computer['model']."</spam></em> has been editted successfully</p>";
	} else {
		$reports[] = "<p class='danger'>Failed to add</p>";
	}
	
	$_SESSION['report'] = $reports;
	header("location: product-add.php?category=Computers");
}

?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>
<!-- handle the quick add functionality -->
<?php include_once(INC_PATH.DS."product-add".DS."component-lightOut+form.php") ?>
	<section>
		<div class='product-add-book-form'>
		<h2>Computer Editing: Add new computers</h2>
		<form class='product-add-books' 
			  action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' 
			  method='post' enctype='multipart/form-data'>
			<div>
				<label>Show on first page:</label>
				<select name='show_at_index_page'>
					<option value='0'>NO</option>	
					<option value='1'>YES</option>
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
				<input type='text' name='model' value="<?php echo $computer->model ?>">
			</div>
			<div>
				<label>CPU:</label><br />
				<select name='cpu'>
					<?php 
						$cpus = ComputerObject::select_from_table("computer_spec_cpu","family");
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

							echo ">";
							echo $cpu->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_category'>+ Quick add new category</a>
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

							echo ">";
							echo $hdd->name." ".$hdd->hdd_type;
							echo "</option>"; 
							print_r($hdd);
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_publisher'>+ Quick add new publisher</a>
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

							echo ">";
							echo $ram->name." ".$ram->ram_type." ".$ram->ram_frequency;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_publisher'>+ Quick add new publisher</a>
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

							echo ">";
							echo $graphic->name;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_publisher'>+ Quick add new publisher</a>
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

							echo ">";
							echo $mornitor->name." inch (".$mornitor->resolution.")";
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_publisher'>+ Quick add new publisher</a>
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

							echo ">";
							echo $os->name." ".$os->architecture;
							echo "</option>";
						}
					?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id='new_publisher'>+ Quick add new publisher</a>
			</div>
			<div class='input-price'>
				<label>Price:</label><br />
				<span>Rs.</span><input type="text" name='price' value='<?php  ?>'>
			</div>
			<div>
				<label>Manufactoring Year:</label><br />
				<input type='text' name='mfg' value='<?php  ?>'><br />
			</div>
			<div>
				<label>Quantity:</label><br />
				<input type='text' name='quantity' value='<?php  ?>'><br />
			</div>
			
			<!-- Thumbnail upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Thumbnail Image of the computer (200x200px):</label>
				<input type='file' name='img_thumb'>
			</div>
			<!-- Front cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Front Image of the computer (400x400px):</label>
				<input type='file' name='img_front'>
			</div>
		
			<!-- Side imgae -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Side Image of the computer (400x400px):</label>
				<input type='file' name='img_left_side'>
		
			</div>

			<!-- Back cover upload section -->
			<div style='display:inline-block'>
				<label>Select <em>new</em> Back Image of the computer (400x400px):</label>
				<input type='file' name='img_back'>
			</div>
			
			<input type='submit' class='btn btn-default' name='submit' value='Update'>
		</form>
	</div>
	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>
