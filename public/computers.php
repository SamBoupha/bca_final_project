<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	require_once(INC_PATH.DS.'computer_object.php'); 
	$computers = ComputerObject::select_all(null,16);
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='products'>
		<h1>Computers &amp; Accessories</h1>
		<div class='products-display'>
			<?php
				foreach ($computers as $computer) {
					echo "<div class='product-thumbnail'>";

					echo "<a href='computer_detail.php?id=".$computer->id."'>";
					echo "<img src='img/computer/".$computer->img_thumb."'>";
					echo "<p class='name'>".$computer->brand." ".$computer->model;
					echo "<span class='creator'> by ".$computer->brand."</span></p>";

					echo "<ul>";
					echo "<li>".$computer->cpu."</li>";
					echo "<li>HDD ".$computer->hdd."</li>";
					echo "<li>RAM ".$computer->ram."</li>";
					echo "<li>".$computer->mornitor." inch display ".$computer->graphic."</li>";
					echo "<li>".$computer->os."".$computer->architecture."</li>";
					echo "</ul>";

					echo "</a><p class='price'>Rs. ".$computer->price."</p>";

					echo "</div>";
				}
			?>
		</div>
	</div>		
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		