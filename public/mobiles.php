<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	require_once(INC_PATH.DS.'mobile_object.php'); 
	$mobiles = mobileObject::select_all($id=null, $limit=16, $public=true, $highlight=false);
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='products'>
		<h1>Mobiles &amp; Tablets</h1>
		<div class='products-display'>
			<?php
				foreach ($mobiles as $mobile) {
					echo "<div class='product-thumbnail'>";

					echo "<a href='mobile_detail.php?id=".$mobile->id."'>";
					echo "<img src='img/mobile/".$mobile->img_thumb."' style='height:100px'>";
					echo "<p class='name'>".$mobile->brand." ".$mobile->model;
					echo "<span class='creator'> by ".$mobile->brand."</span></p>";

					echo "<ul>";
					echo "<li>".$mobile->cpu."</li>";
					echo "<li>HDD ".$mobile->hdd." RAM ".$mobile->ram."</li>";
					echo "<li>".$mobile->screen." inch display ".$mobile->screen_type."</li>";
					echo "<li>".$mobile->os."</li>";
					echo "</ul>";

					echo "</a><p class='price'>Rs. ".number_format($mobile->price)."</p>";

					echo "</div>";
				}
			?>
		</div>
	</div>		
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		