<?php
	$dirPath = "img".DS."product_slides";
	if($dHandler = opendir($dirPath)) {
		$index = 0;
		while ( ($file = readdir($dHandler)) != false) {
			if(preg_match("/.png/", $file) || preg_match("/.jpg/", $file)) {
				echo '<div class="item';
				if ($index == 0) { 
					echo " active";
					$index++;
				}
				echo '">';
				echo '<img src="';
				echo $dirPath.DS.$file.'">';
				echo '</div>';
			}
		}
		closedir($dHandler);
	}
?>