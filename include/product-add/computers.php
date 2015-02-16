<a href='product-add-books-add.php'>
	<div class="btn btn-success">
		+ Add new computer
	</div>
</a>
<?php 
	require_once(INC_PATH.DS.'computer_object.php');
	$computers = ComputerObject::select();
?>
<table class='table table-striped'>
	<tr>
		<th>ID</th>
		<th>First Page</th>
		<th>Sample Image</th>
		<th>Brand + Model</th>
		<th>Price</th>
		<th>Visibility</th>
		<th></th>
		<th></th>
	</tr>
	<?php
		foreach ($computers as $computer) {
			echo "<tr>";
			// 
			echo "<td>";
			echo $computer->id;
			echo "</td>";
			// 
			echo "<td>";
			echo $computer->show_at_index_page == 1 ? "<p class='highlighted'>&#9733;</p>" : "<p>&#9733;</p>";
			echo "</td>";			
			// 
			echo "<td>";
			echo "<img src='../img/computer/";
			echo $computer->img_thumb == null ? "product_image_not_available_200x200.jpg" : $computer->img_thumb.".jpg" ;
			echo "'>";
			echo "</td>";
			// 
			echo "<td>";
			echo $computer->brand." ".$computer->model;
			echo "</td>";
			// 
			echo "<td>Rs. ";
			echo $computer->price;
			echo "</td>";
			// 
			echo "<td>";
			echo $computer->visibility == 0 ? "<div class='danger'>&#10007;</div>" : "<div class='success'>&#10003;</div>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a href='product-add-computers-edit.php?id=".$computer->id."'>Edit</a>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a 
				onclick='return confirm(\"Are you sure you want to delete this item?\")' 
				href='product-add-computers-delete.php?
				id=".$computer->id."
				&title=".$computer->title.
				"' class='danger'>Delete</a>";
			echo "</td>";

			echo "</tr>";
		}
	?>
</table>


