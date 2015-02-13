<?php include("../include/initialize.php"); ?>
<?php $subpage = true; $detailPage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php require_once(INC_PATH.DS.'book_object.php') ?>
<section>
	<div class='row'><?php
		$book = BookObject::select_all_by_id(1);
	?>
		<div class="preview col-sm-1"></div>
		<div class="product-img col-sm-4">
			<img src="img/books/<?php echo $book->img_front ?>">
		</div>
		<div class='product-detail col-sm-6'>
			<h1><?php echo $book->title ?></h1>
			<h4>Author: <?php echo $book->author ?><br />
				Language: English<br />
				Length: <?php echo $book->length ?> pages<br />
				Publisher: <?php echo $book->publisher ?><br /> 
				Year: <?php echo $book->year ?><br />
			</h4>
			<h3>Rs. <?php echo $book->price ?></h3>
			<button class='btn btn-warning'>ADD TO CART</button>
			<button class='btn btn-success'>
				<img src="img/shopping_bag_tag_price-128.png">BUY NOW</button>
		</div>
		<div class="col-sm-1"></div>
	</div><br /><br /><br /> <!-- End of the first row -->
	<div class="row description">
		<div class='book-intro'>
			<h3>Intro</h3>
			<p><?php echo $book->intro ?></p>
		</div>
		<div class='about-author'>
			<h3>About Author</h3>
			<p><?php echo $book->author_about ?></p>
		</div>
	</div>
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>