<?php 
require_once("../../include/initialize.php");
if(!$session->is_logged_in()) header("location: login.php");
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<div>
		<h2>Product Editing: Add new product</h2><br />
		<form id='form_product_add' 
			action='<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>' 
			method='post'>

			<label>Select category:</label>&nbsp;&nbsp;&nbsp;
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
		</form>
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
						echo "<label>Section:</label>&nbsp;&nbsp;";
						echo "<select class='section'>";
						echo "<option value='0'>Please select section</option>";
						echo "<option value='1'>Men</option>";
						echo "<option value='2'>Women</option>";
						echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						echo "<label style='display:none'>Category:</label>&nbsp;&nbsp;";
						echo "<select class='category' style='display:none'>";
						echo "<option value='0'>Please select category</option>";
						echo "</select><br /><br />";
					}
					echo "</div>";
				}
			?>
	</div>
	</section>
	<script type="text/javascript">
		// This refreshes the page when dropdown menu is selected
		function load_selection() {
			document.getElementById("form_product_add").submit();
		}
		var $section_id,
			$category = $('select.category, label:contains(Category)'),
			_href = 'product-add-clothes-add.php';

		$('select.section').change( function() {
			$section_id = $(this).val();
			$("select.category option[value = '2']").remove();
			$("select.category option[value = '1']").remove();
			if ( $section_id == 1 ) {
				$("<option value='1'>Blazer</option>").appendTo('select.category');

				$category.show();
			} else if( $section_id == 2 ) {
				
				$("<option value='2'>Dress</option>").appendTo('select.category');
				$category.show();
			} else {
				$category.hide();
			}
			$('div#clothes').hide();
		});

		$('select.category').change( function() {
			$category_id = $(this).val();
			$('div#clothes').hide();
			if($category_id != 0) {
				$.get('../../include/product-add/clothes.php?category_id='+$category_id+'&section_id='+$section_id, function(data) {
					$('div.product-add-form').append(data);
					
					// Because we append href, to prevent user from reselecting the choice
					// and accidentally appended wrong url that's why we need to clean it
					// everytime the select has been change
					a_link = $('a.link');
					a_link.attr('href','');

					a_link.attr('href',_href+'?section_id='+$section_id+'&category_id='+$category_id);
				});
			}; 
		});
		
	</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>