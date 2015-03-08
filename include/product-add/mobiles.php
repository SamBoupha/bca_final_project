<a href='product-add-mobiles-add.php'>
	<div class="btn btn-success">
		+ Add new mobile
	</div>
</a>
<?php 
	require_once(INC_PATH.DS.'wireless_object.php');
	$mobiles = WirelessObject::select();
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
		foreach ($mobiles as $mobile) {
			echo "<tr>";
			// 
			echo "<td>";
			echo $mobile->id;
			echo "</td>";
			// 
			echo "<td>";
			echo $mobile->show_at_index_page == 1 ? "<p class='highlighted'>&#9733;</p>" : "<p>&#9733;</p>";
			echo "</td>";			
			// 
			echo "<td>";
			echo "<img src='../img/wireless_product/";
			echo $mobile->img_thumb == null ? "product_image_not_available_200x200.jpg" : $mobile->img_thumb;
			echo "'>";
			echo "</td>";
			// 
			echo "<td>";
			echo $mobile->brand." ".$mobile->model;
			echo "</td>";
			// 
			echo "<td>Rs. ";
			echo $mobile->price;
			echo "</td>";
			// 
			echo "<td>";
			echo $mobile->visibility == 0 ? "<div class='danger'>&#10007;</div>" : "<div class='success'>&#10003;</div>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a href='product-add-mobiles-edit.php?id=".$mobile->id."'>Edit</a>";
			echo "</td>";
			// 
			echo "<td>";
			echo "<a 
				onclick='return confirm(\"Are you sure you want to delete this item?\")' 
				href='product-add-mobiles-delete.php?
				id=".$mobile->id.
				"&name=".$mobile->brand." ".$mobile->model.
				"' class='danger'>Delete</a>";
			echo "</td>";

			echo "</tr>";
		}
	?>
</table>


