<a href='product-add-books-add.php'>
	<div class="btn btn-success">
		+ Add new book
	</div>
</a>
<?php 
	require_once(INC_PATH.DS.'book_object.php');
	$books = BookObject::select();
?>
<table class='table table-striped'>
	<tr>
		<th>ID</th>
		<th>Sample Imgae</th>
		<th>Title</th>
		<th>Price</th>
		<th>Visibility</th>
		<th></th>
		<th></th>
	</tr>
	<?php
		foreach ($books as $book) {
			echo "<tr>";
			// 
			echo "<td>";
			echo $book->id;
			echo "</td>";
			// 
			echo "<td>";
			echo "<img src='../img/books/";
			echo $book->img_thumb == null ? "product_image_not_available_200x200.jpg" : $book->img_thumb ;
			echo "'>";
			echo "</td>";
			// 
			echo "<td>";
			echo $book->title;
			echo "</td>";
			// 
			echo "<td>Rs. ";
			echo $book->price;
			echo "</td>";
			// 
			echo "<td>";
			echo $book->visibility == 0 ? "<div class='danger'>&#10007;</div>" : "<div class='success'>&#10003;</div>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a href='product-add-books-edit.php?id=".$book->id."'>Edit</a>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a 
				onclick='return confirm(\"Are you sure you want to delete this item?\")' 
				href='product-add-books-delete.php?
				id=".$book->id."
				&title=".$book->title.
				"' class='danger'>Delete</a>";
			echo "</td>";

			echo "</tr>";
		}
	?>
</table>


