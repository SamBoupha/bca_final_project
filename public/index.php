<?php require_once("../include/initialize.php"); ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php include(INC_PATH.DS."side-nav.php"); ?>

<!-- body of the page -->
<section>
	<div id="carousel-product" class="carousel slide" data-ride="carousel">
	  <!-- Wrapper for slides -->
	  <div class="carousel-inner">
	    <?php carouselAutoGen("img".DS."product_slides"); ?>
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
		<div class='product-row'>
			<?php 
				include(INC_PATH.DS."computer_object.php");
				$computers = ComputerObject::select($limit=4,$public=true,$highlighted=true);
				foreach ($computers as $computer) {
					echo "<div class='book-thumb'>";
					echo "<a href='computer_detail.php?id=".$computer->id."''>";
					echo "<img src='img/computer/";
					echo $computer->img_thumb;
					echo "'>";
					echo "<p class='info'>";
					echo $computer->brand." ".$computer->model;
					echo "</p>";
					echo "</a>";
					echo "<p class='price'>Rs. ";
					echo $computer->price;
					echo "</p>";
					echo "</div>";
				}
				echo "<a href='computers.php'> <div class='view-all'>";
				echo "View all";
				echo "</div></a>";
			?>
		</div>
		<br /><br /><br /><br /><br />
		<h2>Mobiles &amp; Tablets</h2>
		<div>
			<?php 
				// $dirPath = "img".DS."mobilestablets";
				// $images = imgSrcAutoGen($dirPath);
				// foreach ($images as $image) {
				// 	echo $image;
				// }
			?>
		</div>
		<br /><br /><br /><br /><br />
		<h2>Books</h2>
		<div class='product-row'>
			<?php 
				include(INC_PATH.DS."book_object.php");
				$books = BookObject::select($limit=4,$public=true,$highlighted=true);
				foreach ($books as $book) {
					echo "<div class='book-thumb'>";
					echo "<a href='book_detail.php?id=".$book->id."''>";
					echo "<img src='img/book/";
					echo $book->img_thumb;
					echo "' style='height:125px'>";
					echo "<p class='info'>";
					echo $book->title;
					echo "</p>";
					echo "</a>";
					echo "<p class='price'>Rs. ";
					echo $book->price;
					echo "</p>";
					echo "</div>";
				}
				echo "<a href='books.php'> <div class='view-all'>";
				echo "View all";
				echo "</div></a>";
			?>
		</div>
		<br /><br /><br /><br /><br />
		<h2>Clothing</h2>
		<div>
			<?php 
				// $dirPath = "img".DS."computer";
				// $images = imgSrcAutoGen($dirPath);
				// foreach ($images as $image) {
				// 	echo $image;
				// }
			?>
		</div>
	</div> <!--	product thumbnail -->
</section> <!-- main body section-->
	
<?php include(INC_PATH.DS."footer.php"); ?>