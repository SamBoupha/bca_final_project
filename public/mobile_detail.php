<?php include("../include/initialize.php"); ?>
<?php
	if (isset($_POST['buy_now'])) {
		addToCart($_SESSION['cache']);
		header("location: checkout.php");
	}

	if (isset($_POST['add_to_cart'])) {
		addToCart($_SESSION['cache']);
	}

?>
<?php $subpage = true; $detailPage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php require_once(INC_PATH.DS.'wireless_object.php') ?>
<section>
	<div class='row'><?php
		$mobile = WirelessObject::select_all(htmlspecialchars($_GET['id']));
		cache_product($mobile->id,$mobile->brand." ".$mobile->model,$mobile->img_thumb,$mobile->price,"mobile");
	?>
		<div class="preview col-sm-1"></div>
		<div class="product-img col-sm-5">
			<br /><br /><br />
			<img src="img/wireless_product/
					<?php 
					echo $mobile->img_front == null ? 
							'product_image_not_available_400x400.jpg' : 
							$mobile->img_front;
					 ?>
			">
		</div>
		<div class='product-detail col-sm-5'>
			<h1><?php echo $mobile->brand." ".$mobile->model ?></h1><br />
			<h4><?php echo "<ul>";
					echo "<li>".$mobile->cpu."</li>";
					echo "<li>ROM ".$mobile->hdd."</li>";
					echo "<li>RAM ".$mobile->ram."</li>";
					echo "<li>".$mobile->screen." inch display ".$mobile->screen_type."</li>";
					echo "<li>".$mobile->os."</li>";
					echo "</ul>";?>	
			</h4><br />
			<h3>Rs. <?php echo number_format($mobile->price) ?></h3><br /><br />
			<form method='post'>
				<button class='btn btn-warning' name='add_to_cart'>ADD TO CART</button>
				<button class='btn btn-success' name='buy_now'>
					<img src="img/shopping_bag_tag_price-128.png">BUY NOW
				</button>
			</form>
		</div>
		<div class="col-sm-1"></div>
	</div><br /><br /><br /> <!-- End of the first row -->
	<div class="row description">
		<div class='mobile-intro'>
			<h3><?php echo $mobile->title." by ".$mobile->author.":" ?></h3>
			<p><?php echo $mobile->intro ?></p>
		</div>
		<div class='about-author'>
			<h3>About Author</h3>
			<p><?php echo $mobile->author_about ?></p>
		</div>
	</div>
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>