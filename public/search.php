<?php include("../include/initialize.php"); ?>
<?php $subpage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php 	
	require_once(INC_PATH.DS.'search_object.php');
?>
<?php include(INC_PATH.DS."side-nav.php"); ?>
<section>
	<div class='products'>
		<div class='search-display'>
			<?php
				$keyword = trim($_GET['search_box']);
				$products = SearchObject::search($keyword);
				//print_r($products);
				if (empty($products)) {
					echo '<h4>Sorry we are unable to find <span class="highlight">"'.$keyword.'"</span><br />
						<span class="tip">TIP: Check your spelling or limit your search to one or two words.
						</span></h4>';
				} else {
					$no_of_item = sizeof($products['wireless_product']) + sizeof($products['computer']) + sizeof($products['book']) + sizeof($products['clothing']);
					echo '<h4>'.$no_of_item.' results found for <span class="highlight">"'.$keyword.'"</span></h4>';
					foreach ($products as $category => $product_id) {
						if ($category == 'wireless_product') {
							require_once(INC_PATH.DS.'wireless_object.php');
							$results = WirelessObject::search($product_id);
							//print_r($results);
							
							foreach ($results as $result) {
								echo "<div class='product-thumbnail'>";

								echo "<a href='mobile_detail.php?id=".$result->id."'>";
								echo "<img src='img/wireless_product/".$result->img_thumb."' style='height:100px'>";
								echo "<p class='name'>".$result->brand." ".$result->model;
								echo "<span class='creator'> by ".$result->brand."</span></p>";

								echo "<ul>";
								echo "<li>".$result->cpu."</li>";
								echo "<li>HDD ".$result->hdd." RAM ".$result->ram."</li>";
								echo "<li>".$result->screen." inch display ".$result->screen_type."</li>";
								echo "<li>".$result->os."</li>";
								echo "</ul>";

								echo "</a><p class='price'>Rs. ".number_format($result->price)."</p>";

								echo "</div>";
							}
						} elseif ($category == 'computer') {
							require_once(INC_PATH.DS.'computer_object.php');
							$results = ComputerObject::search($product_id);
							foreach ($results as $result) {
								echo "<div class='product-thumbnail'>";

								echo "<a href='computer_detail.php?id=".$result->id."'>";
								echo "<img src='img/computer/".$result->img_thumb."' style='height:85px'>";
								echo "<p class='name'>".$result->brand." ".$result->model;
								echo "<span class='creator'> by ".$result->brand."</span></p>";

								echo "<ul>";
								echo "<li>".$result->cpu."</li>";
								echo "<li>HDD ".$result->hdd."</li>";
								echo "<li>RAM ".$result->ram."</li>";
								echo "<li>".$result->mornitor." inch display ".$result->graphic."</li>";
								echo "<li>".$result->os."".$result->architecture."</li>";
								echo "</ul>";

								echo "</a><p class='price'>Rs. ".number_format($result->price)."</p>";

								echo "</div>";
							}
						} elseif ($category == 'book'){
							require_once(INC_PATH.DS.'book_object.php');
							$results = BookObject::search($product_id);
							foreach ($results as $result) {
								echo "<div class='product-thumbnail'>";

								echo "<a href='book_detail.php?id=".$result->id."'>";
								echo "<img src='img/book/".$result->img_thumb."' style='height:140px'>";
								echo "<p class='name'>".$result->title."</p>";
								echo "<p class='creator'>by ".$result->author."</p>";
								echo "</a><p class='price'>Rs. ".number_format($result->price)."</p>";

								echo "</div>";
							}
						} elseif ($category == 'clothing'){
							require_once(INC_PATH.DS.'cloth_object.php');
							$results = ClothObject::search($product_id);
							foreach ($results as $result) {
								echo "<div class='product-thumbnail'>";

								echo "<a href='cloth_detail.php?id=".$result->id."'>";
								echo "<img src='img/clothing/".$result->img_thumb."' style='height:140px'>";
								echo "<p class='name'>".$result->name."</p>";
								echo "<p class='creator'>by ".$result->brand."</p>";
								echo "</a><p class='price'>Rs. ".number_format($result->price)."</p>";

								echo "</div>";
							}
						} 
					}
				}	
			?>
		</div>
	</div>		
	
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>
		