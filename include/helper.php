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

	function imgSrcAutoGen($dirPath, $width=null, $height=null) {
		$index = 0;
		$img_links = array();
		$images = imgSearch($dirPath);

		foreach ($images as $image) {
			$img_links[] = '<img src="'.$dirPath.DS.$image.'" style= "width:'.$width
					.'px; height:'.$height.'px;">';
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
			echo '"><a href="';
			echo $link;
			echo '">';
			echo $img;
			echo '</a></div>';
		}
	}

?>
