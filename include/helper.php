<?php

	function imgSrcAutoGen($dirPath) {
		$images = array();
		if($dHandler = opendir($dirPath)) {
			$index = 0;
			while ( ($file = readdir($dHandler)) != false) {
				if(preg_match("/.png/", $file) || preg_match("/.jpg/", $file)) {
					$images[] = '<img src="'.$dirPath.DS.$file.'">';
				}
			}
			closedir($dHandler);
		}
		return $images;
	}

	function carouselAutoGen() {
		$dirPath = "img".DS."product_slides";
		$images = imgSrcAutoGen($dirPath);
		$index = 0;
		foreach ($images as $image) {
			echo '<div class="item';
			if ($index == 0) { 
				echo " active";
				$index++;
			}
			echo '">';
			echo $image;
			echo '</div>';
		}
	}

?>