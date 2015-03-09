<div id='clothes'>
<a class='link' href=''>
	<div class="btn btn-success">
		+ Add new cloth
	</div>
</a>

<?php
	require_once("../../include/initialize.php"); 
	require_once(INC_PATH.DS.'cloth_object.php');
	$clothes = ClothObject::select($_GET['category_id'],$_GET['section_id']);
	if (!is_array($clothes)) {
		$clothes[] = $clothes;
	}
?>
<table class='table table-striped'>
	<tr>
		<th>ID</th>
		<th>First Page</th>
		<th>Sample Image</th>
		<th>Brand + Name</th>
		<th>Price</th>
		<th>Visibility</th>
		<th></th>
		<th></th>
	</tr>
	<?php
		foreach ($clothes as $cloth) {
			echo "<tr>";
			// 
			echo "<td>";
			echo $cloth->id;
			echo "</td>";
			// 
			echo "<td>";
			echo $cloth->show_at_index_page == 1 ? "<p class='highlighted'>&#9733;</p>" : "<p>&#9733;</p>";
			echo "</td>";			
			// 
			echo "<td>";
			echo "<img height='150px' src='../img/clothing/";
			echo $cloth->img_thumb == null ? "product_image_not_available_200x200.jpg" : $cloth->img_thumb ;
			echo "'>";
			echo "</td>";
			// 
			echo "<td>";
			echo $cloth->brand." ".$cloth->name;
			echo "</td>";
			// 
			echo "<td>Rs. ";
			echo $cloth->price;
			echo "</td>";
			// 
			echo "<td>";
			echo $cloth->visibility == 0 ? "<div class='danger'>&#10007;</div>" : "<div class='success'>&#10003;</div>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a href='product-add-clothes-edit.php?id=".$cloth->id."'>Edit</a>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a 
				onclick='return confirm(\"Are you sure you want to delete this item?\")' 
				href='product-add-clothes-delete.php?
				id=".$cloth->id."
				&title=".$cloth->brand." ".$cloth->name.
				"' class='danger'>Delete</a>";
			echo "</td>";

			echo "</tr>";
		}
	?>
</table>
</div>

