<?php 
require_once("../../include/initialize.php");
if(!$session->is_logged_in()) header("location: login.php");
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<div>
		<h2>Product Editing: Add new product</h2><br />
		<form id='product_add_form' 
			action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' 
			method='post' 
			enctype='multipart/form-data'>

			<label>Select Category:</label>&nbsp;&nbsp;&nbsp;
			<select name='category' id='category' onchange='load_selection()'>
				<?php

					$selected = isset($_POST['category']) ? $_POST['category'] : $_GET['category'];

					$options = array( 'None',
								 'Computers',
								 "Computer's Accessories",
								 'Mobiles',
								 'Tablets',
								 'Books',
								 'Clothing' );

					for ($i=0, $max = sizeof($options); $i < $max; $i++) { 
						echo '<option value="';
						echo $options[$i];
						echo '" ';
						echo $selected == $options[$i] ?  "selected" : "";
						echo ">";
						echo $options[$i];
						echo "</option>";
					}
				?>
			</select>
			<?php
				if (isset($_SESSION['report'])) {
					$reports = $_SESSION['report'];
					echo "<div class='report'>";
					foreach ($reports as $report) {
						echo $report;
					}
					echo "</div>";
					unset($_SESSION['report']);
				}
			?>

			<?php
				if(isset($selected)) {
					echo "<div class='product-add-form'>";
					if ($selected == 'Computers') {
						echo "<h3>";
						echo $selected;
						echo "</h3>";
						include(INC_PATH.DS.'product-add'.DS.'computers.php');
					}
					elseif ($selected == 'Computer\'s Accessories') {
						echo "<h3>";
						echo $selected;
						echo "</h3>";
					}
					elseif ($selected == 'Mobiles') {
						echo "<h3>";
						echo $selected;
						echo "</h3>";
						include(INC_PATH.DS.'product-add'.DS.'mobiles.php');
					}
					elseif ($selected == 'Tablets') {
						echo "<h3>";
						echo $selected;
						echo "</h3>";
					}
					elseif ($selected == 'Books') {
						echo "<h3>";
						echo $selected;
						echo "</h3>";
						include(INC_PATH.DS.'product-add'.DS.'books.php');
					}
					elseif ($selected == 'Clothing') {
						echo "<h3>";
						echo $selected;
						echo "</h3>";
						echo "<label>Section:</label>";
						echo "<select>";
						echo "<option value='0'>Please select section</option>";
						echo "<option value='1'>Men</option>";
						echo "<option value='2'>Women</option>";
						echo "</select>";
						echo "<label>Category:</label>";
						echo "<select>";
						echo "<option value='0'>Please select category</option>";
						echo "<option value='1'>Blazer</option>";
						echo "<option value='2'>Dress</option>";
						echo "</select>";
						//include(INC_PATH.DS.'product-add'.DS.'clothes.php');
					}
					echo "</div>";
				}
			?>
		</form>
	</div>
	</section>
	<script type="text/javascript">
		// This refreshes the page when dropdown menu is selected
		function load_selection() {
			document.getElementById("product_add_form").submit();
		}
	</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>