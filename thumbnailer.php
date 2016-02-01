<?php
 
 
  if (!isset($_GET['target'])){
	  die();
  }
  
  $file = str_replace('./','',$_GET['target']);
  $ratio=0.05;
  
  if (file_exists('./seed/date.clewn.org/u/'.$file) && strpos(mime_content_type('./seed/date.clewn.org/u/'.$file),'image/')==0){   
	header('Content-type: application/x-png'); 
	list($width, $height) = getimagesize('./seed/date.clewn.org/u/'.$file);
	$modwidth=round(floatval($ratio)*(floatval($width))); 
	$modheight = round(floatval($ratio)*(floatval($height)));
	$output= imagecreatetruecolor($modwidth, $modheight); 
	$type=mime_content_type('./seed/date.clewn.org/u/'.$file);
		if (strstr($type,  'gif')){
			
			$source = imagecreatefromgif('./seed/date.clewn.org/u/'.$file);
				}
		if (strstr($type,  'png')){
			$source = imagecreatefrompng('./seed/date.clewn.org/u/'.$file);
			
		}
		if (strstr($type,  'jpeg')){
		
			$source = imagecreatefromjpeg('./seed/date.clewn.org/u/'.$file);
			
		}
		imagecopyresized($output, $source, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
		imagepng($output);
}
die();	   
?>
