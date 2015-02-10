<?php

	function imgSrcAutoGen($dirPath, $width=null, $height=null) {
		$images = array();
		if($dHandler = opendir($dirPath)) {
			$index = 0;
			while ( ($file = readdir($dHandler)) != false) {
				if(preg_match("/.png/", $file) || preg_match("/.jpg/", $file)) {
					$images[] = '<img src="'.$dirPath.DS.$file.'" style= "width:'.$width
					.'px; height:'.$height.'px;">';
				}
			}
			closedir($dHandler);
		}
		return $images;
	}

	function carouselAutoGen($dirPath) {
	
		$images = imgSrcAutoGen($dirPath);
		$index = 0;
		foreach ($images as $image) {
			echo '<div class="item';
			if ($index == 0) { 
				echo " active";
				$index++;
			}
			echo '"><a href="';
			echo $link;
			echo '">';
			echo $image;
			echo '</a></div>';
		}
	}
?>
