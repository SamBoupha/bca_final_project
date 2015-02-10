<?php 
require_once("../../include/initialize.php");
include(INC_PATH.DS."helper.php");
if(!$session->is_logged_in()) header("location: login.php");
?>

<?php include(INC_PATH.DS.'header-admin.php');?>
<?php include(INC_PATH.DS.'side-nav-admin.php');?>

	<section>
		<h2>Carousel Editing</h2>
		<a href='carousel-edit-add.php'>Add new</a><br />

		<?php
			$dirPath = "..".DS."img".DS."product_slides";
			$images = imgSearch($dirPath);
			echo "<table class='table table-striped'>";
			echo "<tr><th>Index</th><th>Sample Imgae</th><th>Link</th><th></th><th></th></tr>";
			foreach ($images as $image) {
				$file_name = explode("_", $image);
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
				echo '<a href="carousel-edit-edit.php.php">Edit This Slide</a>';
				echo "</td>";
				// FifthColumn - Delete
				echo "<td>";
				echo '<a href="carousel-edit-delete.php?fn='.$image.'"><p class="danger">Delete This Slide</p></a>';
				echo "</td>";

				echo "</tr>";
			}
			echo "</table>";
		?>

	</section>

<?php include(INC_PATH.DS.'footer-admin.php');?>