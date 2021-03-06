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

?>
