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
<?php require_once(INC_PATH.DS.'cloth_object.php') ?>

<section>
	<div class='row'>
		<?php
			$cloth = ClothObject::select_all($_GET['id']);
			// since I chose to store img in another table. it's hard to retrieve all
			// relevant imgs along with the cloth
			// for now we will have two variables one deals with cloth another with its imgs
			$cloth_imgs = ClothObject::select_cloth_img_of_id($_GET['id']);
			cache_product($cloth->id,$cloth->brand." ".$cloth->name,$cloth_imgs['img_thumb'],$cloth->price,"clothing");
		?>

		<div class="preview col-sm-1"></div>
		<div class="product-img col-sm-5">
			<img src="img/clothing/
					<?php 
					echo $cloth_imgs['img_whole_body'] == null ? 
							'product_image_not_available_400x400.jpg' : 
							$cloth_imgs['img_whole_body'];
					 ?>
			">
		</div>
		<div class='product-detail col-sm-5'>
			<h2><?php echo $cloth->brand_name." ".$cloth->name ?></h2><br />
			<h4>Please select your size:<br />
				<ul class='size_select'>
					<li class='btn'>S</li>
					<li class='btn'>M</li>
					<li class='btn'>L</li>
				</ul>				
			</h4><br />
			<h3>Rs. <?php echo number_format($cloth->price) ?></h3><br /><br />
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
		<div class='book-intro'>
			<?php echo nl2br($cloth->description); ?>

		</div>
		<!-- <div class='about-author'>
			<h3>About Author</h3>
			<p><?php echo $cloth->author_about ?></p>
		</div> -->
	</div>
</section> <!-- main body section-->
<script type="text/javascript">
	$('ul li').click( function() {
		$('ul *').removeClass('selected');
		$(this).addClass('selected');
	});
</script>

<?php include(INC_PATH.DS."footer.php"); ?>