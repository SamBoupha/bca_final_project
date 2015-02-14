<?php 
require_once("../../include/initialize.php");
include(INC_PATH.DS."helper.php");
if(!$session->is_logged_in()) header("location: login.php");
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<h2>Carousel Editing</h2><br />
		<a href='carousel-edit-add.php' class='btn btn-success'>+ Add new</a><br />

		<?php
			if (isset($_SESSION['report'])) {
				echo "<div class='report'>";
				echo $_SESSION['report'];
				echo "</div>";
				unset($_SESSION['report']);
			}

			$dirPath = "..".DS."img".DS."product_slides";
			$images = imgSearch($dirPath);
			echo "<table class='table table-striped'>";
			echo "<tr><th>Index</th><th>Sample Imgae</th><th>Link</th><th></th><th></th></tr>";
			foreach ($images as $image) {
				$file_name = explode("__", $image);
				echo "<tr>";
				//first column - Index
				echo "<td>";
				echo $file_name[0];
				echo "</td>";
				// second column - Sample Image
				echo "<td>";
				echo '<img src="'.$dirPath.DS.$image.'" style= "width:400px;"></a>';
				echo "</td>";
				// third column - Link
				echo "<td>";
				echo '<a href="..'.DS.$file_name[1].'.php">'.$file_name[1].'.php</a>';
				echo "</td>";
				// Fourth Column - Edit
				echo "<td>";
				echo '<a href="carousel-edit-edit.php?fn='.$image.'">Edit This Slide</a>';
				echo "</td>";
				// FifthColumn - Delete
				echo "<td>";
				echo '<a href="carousel-edit-delete.php?fn='.$image.'"
					onclick="return wait()"><p class="danger">Delete This Slide</p></a>';
				echo "</td>";

				echo "</tr>";
			}
			echo "</table>";
		?>

	</section>
	<script type="text/javascript">
		function wait() {
			return confirm("Are you sure you want to delete this slide?");
		}
	</script>
<?php include(INC_PATH.DS.'footer-admin.php');?>