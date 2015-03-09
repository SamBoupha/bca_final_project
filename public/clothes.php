<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	require_once(INC_PATH.DS.'cloth_object.php'); 
	$clothes = ClothObject::select($_GET['category'],$_GET['section'],16,true);
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='products'>
		<h1>Clothes</h1>
		<div class='products-display'>
			<?php
				foreach ($clothes as $cloth) {
					echo "<div class='product-thumbnail'>";

					echo "<a href='cloth_detail.php?id=".$cloth->id."'>";
					echo "<img src='img/clothing/".$cloth->img_thumb."' style='height:140px'>";
					echo "<p class='name'>".$cloth->name."</p>";
					echo "<p class='creator'>by ".$cloth->brand."</p>";
					echo "</a><p class='price'>Rs. ".number_format($cloth->price)."</p>";

					echo "</div>";
				}
			?>
		</div>
	</div>		
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		