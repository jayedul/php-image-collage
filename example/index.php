<?php
	define('DS',DIRECTORY_SEPARATOR);
	
	include('..'.DS.'API'.DS.'Gallery.Class.php');
	
	/* send final image width, height and format to the constructor */
	$image=new Gallery(1920,1080,'png');
	
	$images=	[
					'images'.DS.'img (1).jpg',
					'images'.DS.'img (1).png',
					'images'.DS.'img (6).jpg',
					'images'.DS.'img (10).jpg',
					'images'.DS.'img (9).jpg',
					'images'.DS.'img (8).jpg',
					'images'.DS.'img (7).jpg',
					'images'.DS.'img (3).png',
					'images'.DS.'img (3).jpg',
					'images'.DS.'img (2).jpg'
				];
	
	
	$image->setImages($images)->process(/* send 'true' as parameter to make the images stretched */);
			
	/* Make the variable true to see gallery with text added after creating main gallery */
	$modify_rendered_gallery=false;
	
	if($modify_rendered_gallery==true)
	{
		/* This section shows how you can re-edit the rendered gallery before sending to browser. Here a sample text added. */
		$gallery=$image->getGallery();
	
		$white = imagecolorallocate($gallery, 255, 255, 255);
		$black = imagecolorallocate($gallery, 0, 0, 0);
		$font = 'fonts'.DS.'arial.ttf';
		$txt='This text added on returned rendered gallery.
Then sent to browser.';
		
		imagettftext($gallery, 30, 0, 102, 102, $black, $font, $txt);
		imagettftext($gallery, 30, 0, 100, 100, $white, $font, $txt);
			
		header('Content-Type: image/png');
		imagepng($gallery);
		exit;
	}
	else
	{
		/* If you don't need to re-edit, then just call the function to render and send to browser directly. */
		$image->renderGallery();
	}	
	
?>