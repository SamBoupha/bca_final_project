<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<!-- if it is subpage then link this css in -->
		<?php 
			if($subpage) {
				echo '<link rel="stylesheet" type="text/css" href="css/subpage.css">';
				$subpage = false;
			}
			if ($detailPage) {
				echo '<link rel="stylesheet" type="text/css" href="css/full-detail-page.css">';
				$detailPage = false;
			}
		?>
	</head>

	<body >
		<!-- header section -->
		<header>
				<div class="col-md-12">
					<a href="index.php"><img style="height:60px;" src="img/abc-opt.png"></a>
					<input type='text' name='search_box' placeholder='Search for a product, category or brand'>
					<input type='button' class='btn btn-primary' name='search' value='SEARCH'>
					<div class='account'>
						<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
						My account
						<span class='caret'></span>
					</div>
				</div>
		</header>