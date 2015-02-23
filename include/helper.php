<?php

	function imgSearch($dirPath) {
		$images = array();
		if($dHandler = opendir($dirPath)) {
			while ( ($file = readdir($dHandler)) != false) {
				if(preg_match("/.png/", $file) || preg_match("/.jpg/", $file)) {
					$images[] = $file;
				}
			}
			closedir($dHandler);
		}
		return $images;
	}

	function imgSrcAutoGen($dirPath, $admin=false, $width=null, $height=null) {
		$index = 0;
		$img_links = array();
		$images = imgSearch($dirPath);

		$stepback = $admin ? '..'.DS : null;

		foreach ($images as $image) {
			$file_names = explode("__", $image);
			$link = $file_names[1].".php";
			$img_links[] = 	'<a href="'.
							$stepback.
							$link.
							'"><img src="'.
							$dirPath.DS.
							$image.
							'" style= "width:'.
							$width.'px; height:'.
							$height.'px;"></a>';
		}
		return $img_links;
	}

	function carouselAutoGen($dirPath) {
	
		$img_links = imgSrcAutoGen($dirPath);
		$index = 0;
		foreach ($img_links as $img) {

			echo '<div class="item';
			if ($index == 0) { 
				echo " active";
				$index++;
			}
			echo '">';
			echo $img;
			echo '</div>';
		}
	}

	function addToCart($cache) {
		if (sizeof($_SESSION['cart']) == 0) {
			$_SESSION['cart'][0]['id'] = $cache['id'];
			$_SESSION['cart'][0]['name'] = $cache['name'];
			$_SESSION['cart'][0]['thumbnail'] = $cache['thumbnail'];
			$_SESSION['cart'][0]['price'] = $cache['price'];
			$_SESSION['cart'][0]['type'] = $cache['type'];
		} else {
			$last = sizeof($_SESSION['cart']);
			$_SESSION['cart'][$last]['id'] = $cache['id'];
			$_SESSION['cart'][$last]['name'] = $cache['name'];
			$_SESSION['cart'][$last]['thumbnail'] = $cache['thumbnail'];
			$_SESSION['cart'][$last]['price'] = $cache['price'];
			$_SESSION['cart'][$last]['type'] = $cache['type'];
		}
		$_SESSION['cache'] = array();
	}

	function remove_from_cart($id) {
		if (get_items_in_the_cart() == 0) return;
		else {
			unset($_SESSION['cart'][$id]);
		}
		$_SESSION['cart'] = array_values($_SESSION['cart']);
	}

	function cache_product($pid, $pname, $pthumbnail, $pprice, $ptype) {
			$_SESSION['cache'] = array();
			$_SESSION['cache']['id'] = $pid;
			$_SESSION['cache']['name'] = $pname;
			$_SESSION['cache']['thumbnail'] = $pthumbnail;
			$_SESSION['cache']['price'] = $pprice;
			$_SESSION['cache']['type'] = $ptype;
	}

	function get_items_in_the_cart() {
		return sizeof($_SESSION['cart']);
	}

?>
