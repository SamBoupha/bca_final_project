<?php require_once("../include/initialize.php"); ?>
<?php require_once(INC_PATH.DS."db_connection.php"); ?>
<?php include(INC_PATH.DS."helper.php"); ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php include(INC_PATH.DS."side-nav.php"); ?>

<!-- body of the page -->
<section  class='main-section col-md-offset-2 col-md-10'>
	<div class="main-section-content">
		<div id="carousel-product" class="carousel slide" data-ride="carousel">
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <?php carouselAutoGen(); ?>
		  </div>
		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-product" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-product" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div> <!-- carousel -->
		<br /><br />
		<!-- categories display section -->
		<div class='product-thumbnail-section'>
			<h2>Computers</h2>
			<div>
				<?php 
					$dirPath = "img".DS."computer";
					$images = imgSrcAutoGen($dirPath);
					foreach ($images as $image) {
						echo $image;
					}
				?>
			</div>
			<br /><br /><br /><br /><br />
			<h2>Mobiles &amp; Tablets</h2>
			<div>
				<?php 
					$dirPath = "img".DS."mobilestablets";
					$images = imgSrcAutoGen($dirPath);
					foreach ($images as $image) {
						echo $image;
					}
				?>
			</div>
			<br /><br /><br /><br /><br />
			<h2>books</h2>
			<div>
				<?php 
					$dirPath = "img".DS."computer";
					$images = imgSrcAutoGen($dirPath);
					foreach ($images as $image) {
						echo $image;
					}
				?>
			</div>
			<br /><br /><br /><br /><br />
			<h2>Clothing</h2>
			<div>
				<?php 
					$dirPath = "img".DS."computer";
					$images = imgSrcAutoGen($dirPath);
					foreach ($images as $image) {
						echo $image;
					}
				?>
			</div>
		</div> <!--	product thumbnail -->
	</div>
</section> <!-- main body section-->
	
<?php include(INC_PATH.DS."footer.php"); ?>