<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	require_once(INC_PATH.DS.'book_object.php'); 
	$books = BookObject::select(16,true);
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='products'>
		<h1>Books</h1>
		<div class='products-display'>
			<?php
				foreach ($books as $book) {
					echo "<div class='product-thumbnail'>";

					echo "<a href='book_detail.php?id=".$book->id."'>";
					echo "<img src='img/book/".$book->img_thumb."'>";
					echo "<p class='name'>".$book->title."</p>";
					echo "<p class='creator'>by ".$book->author."</p>";
					echo "</a><p class='price'>Rs. ".number_format($book->price)."</p>";

					echo "</div>";
				}
			?>
		</div>
	</div>		
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		