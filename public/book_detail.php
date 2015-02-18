<?php include("../include/initialize.php"); ?>
<?php $subpage = true; $detailPage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php require_once(INC_PATH.DS.'book_object.php') ?>
<section>
	<div class='row'><?php
		$book = BookObject::select_all(htmlspecialchars($_GET['id']));
	?>
		<div class="preview col-sm-1"></div>
		<div class="product-img col-sm-5">
			<img src="img/books/
					<?php 
					echo $book->img_front == null ? 
							'product_image_not_available_400x400.jpg' : 
							$book->img_front;
					 ?>
			">
		</div>
		<div class='product-detail col-sm-5'>
			<h1><?php echo $book->title ?></h1><br />
			<h4>Author: <?php echo $book->author ?><br />
				Language: English<br />
				Length: <?php echo $book->length ?> pages<br />
				Publisher: <?php echo $book->publisher ?><br /> 
				Year: <?php echo $book->year ?><br />
			</h4><br />
			<h3>Rs. <?php echo $book->price ?></h3><br /><br />
			<button class='btn btn-warning'>ADD TO CART</button>
			<button class='btn btn-success'>
				<img src="img/shopping_bag_tag_price-128.png">BUY NOW</button>
		</div>
		<div class="col-sm-1"></div>
	</div><br /><br /><br /> <!-- End of the first row -->
	<div class="row description">
		<div class='book-intro'>
			<h3><?php echo $book->title." by ".$book->author.":" ?></h3>
			<p><?php echo $book->intro ?></p>
		</div>
		<div class='about-author'>
			<h3>About Author</h3>
			<p><?php echo $book->author_about ?></p>
		</div>
	</div>
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>