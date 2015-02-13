<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 
	require_once(INC_PATH.DS.'book_object.php'); 
	$books = BookObject::select();
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='books'>
		<h1>Books</h1>
		<div class='books-display'>
			<?php
				foreach ($books as $book) {
					echo "<div class='book-thumbnail'>";
					echo "<a href='book_detail.php?id=".$book->id."'>";
					echo "<img src='img/books/".$book->img_thumb."'>";
					echo "<p class='title'>".$book->title."</p>";
					echo "<p class='author'>by ".$book->author."</p>";
					echo "</a><p class='price'>Rs. ".$book->price."</p>";
					echo "</div>";
				}
			?>
		</div>
	</div>		
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		