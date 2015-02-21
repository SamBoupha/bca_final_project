<?php include("../include/initialize.php"); ?>
<?php $subpage = true; $detailPage = true; ?>
<?php include(INC_PATH.DS."header.php"); ?>
<?php require_once(INC_PATH.DS.'computer_object.php') ?>
<section>
	<div class='row'><?php
		$computer = ComputerObject::select_all(htmlspecialchars($_GET['id']));
	?>
		<div class="preview col-sm-1"></div>
		<div class="product-img col-sm-5">
			<br /><br /><br />
			<img src="img/computer/
					<?php 
					echo $computer->img_front == null ? 
							'product_image_not_available_400x400.jpg' : 
							$computer->img_front;
					 ?>
			">
		</div>
		<div class='product-detail col-sm-5'>
			<h1><?php echo $computer->brand." ".$computer->model ?></h1><br />
			<h4><?php echo "<ul>";
					echo "<li>".$computer->cpu."</li>";
					echo "<li>HDD ".$computer->hdd."</li>";
					echo "<li>RAM ".$computer->ram."</li>";
					echo "<li>".$computer->mornitor." inch display ".$computer->graphic."</li>";
					echo "<li>".$computer->os."".$computer->architecture."</li>";
					echo "</ul>";?>	
			</h4><br />
			<h3>Rs. <?php echo $computer->price ?></h3><br /><br />
			<button class='btn btn-warning'>ADD TO CART</button>
			<a href='checkout.php?pid=<?php echo $computer->id ?>'>
				<button class='btn btn-success'>
				<img src="img/shopping_bag_tag_price-128.png">BUY NOW</button>
			</a>
		</div>
		<div class="col-sm-1"></div>
	</div><br /><br /><br /> <!-- End of the first row -->
	<div class="row description">
		<div class='computer-intro'>
			<h3><?php echo $computer->title." by ".$computer->author.":" ?></h3>
			<p><?php echo $computer->intro ?></p>
		</div>
		<div class='about-author'>
			<h3>About Author</h3>
			<p><?php echo $computer->author_about ?></p>
		</div>
	</div>
</section> <!-- main body section-->

<?php include(INC_PATH.DS."footer.php"); ?>