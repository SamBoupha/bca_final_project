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
			<select name='category' onchange='load_selection()'>
				<?php

					$selected = isset($_POST['category']) ? $_POST['category'] : 'None';

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
			</select><br /><br />
			<?php
				if(isset($_POST['category'])) {
					echo "<div class='product-add-form'>";
					if ($_POST['category'] == 'Computers') {
						echo "<h3>";
						echo $_POST['category'];
						echo "</h3>";
					}
					elseif ($_POST['category'] == 'Computer\'s Accessories') {
						echo "<h3>";
						echo $_POST['category'];
						echo "</h3>";
					}
					elseif ($_POST['category'] == 'Mobiles') {
						echo "<h3>";
						echo $_POST['category'];
						echo "</h3>";
					}
					elseif ($_POST['category'] == 'Tablets') {
						echo "<h3>";
						echo $_POST['category'];
						echo "</h3>";
					}
					elseif ($_POST['category'] == 'Books') {
						echo "<h3>";
						echo $_POST['category'];
						echo "</h3>";
						include(INC_PATH.DS.'product-add'.DS.'books-add.php');
					}
					elseif ($_POST['category'] == 'Clothing') {
						echo "<h3>";
						echo $_POST['category'];
						echo "</h3>";
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