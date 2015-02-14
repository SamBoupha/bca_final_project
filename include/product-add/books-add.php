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
		<th></th>
		<th></th>
	</tr>
	<?php
		foreach ($books as $book) {
			echo "<tr>";
			echo "<td>";
			echo $book->id;
			echo "</td>";
			echo "<td>";
			echo "<img src='../img/books/".$book->img_thumb."'>";
			echo "</td>";
			echo "<td>";
			echo $book->title;
			echo "</td>";
			echo "<td>Rs. ";
			echo $book->price;
			echo "</td>";
			echo "<td>";
			echo "<a href=''>Edit</a>";
			echo "</td>";
			echo "<td>";
			echo "<a href='' class='danger'>Delete</a>";
			echo "</td>";
			echo "</tr>";
		}
	?>
</table>


