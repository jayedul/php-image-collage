<?php
	class Gallery
	{
		private $layout;
		private $images=[];
		private $render_img_width;
		private $render_img_height;
		private $render_img_type;
		private $processed_gallery=false;
		private $allowed_ext_methd=	[	
										'jpg'=>['create_from'=>'imagecreatefromjpeg', 	'create_to'=>'imagejpeg', 	'content-type'=>'image/jpeg'],
										'png'=>['create_from'=>'imagecreatefrompng',	'create_to'=>'imagepng', 	'content-type'=>'image/png'],
										'gif'=>['create_from'=>'imagecreatefromgif',	'create_to'=>'imagegif',	'content-type'=>'image/gif']
									];
		
		function __construct($w,$h,$final_img_type='png')
		{
			/* Store final render image width and height */
			$this->render_img_width=$w;
			$this->render_img_height=$h;
			
			$final_img_type=strtolower($final_img_type);
			$this->render_img_type=array_key_exists($final_img_type, $this->allowed_ext_methd) ? $final_img_type : 'png';
			
			/* Create layout, position, size for images based on layout height and width*/
			/* For example, 4 images provided in this object to create gallery. So fourth array elements (even array key is 4) would be used as layout. */
			$this->layout=	[
								1=>	[
										[0,						0,			0,	0,	$w,		$h	]
									],
								2=>	[
										[0,						0,			0,	0,	$w/2,	$h	],
										[$w/2,					0,			0,	0,	$w/2,	$h	]
									],
								3=>	[
										[0,						0,			0,	0,	$w/2,	$h/2],
										[0,						$h/2,		0,	0,	$w/2,	$h/2],
										[$w/2,					0,			0,	0,	$w/2,	$h	]
									],
								4=>	[
										[0,						0,			0,	0,	$w/2,	$h/2],
										[0,						$h/2,		0,	0,	$w/2,	$h/2],
										[$w/2,					0,			0,	0,	$w/2,	$h/2],
										[$w/2,					$h/2,		0,	0,	$w/2,	$h/2]
									],
								5=>	[
										[0,						0,			0,	0,	$w/2,	$h/3],
										[0,						$h/3,		0,	0,	$w/2,	$h/3],
										[0,						($h/3)*2,	0,	0,	$w/2,	$h/3],
										[$w/2,					0,			0,	0,	$w/2,	$h/2],
										[$w/2,					$h/2,		0,	0,	$w/2,	$h/2]
									],
								6=>	[
										[0,						0,			0,	0,	$w/2,	$h/3],
										[0,						$h/3,		0,	0,	$w/2,	$h/3],
										[0,						($h/3)*2,	0,	0,	$w/2,	$h/3],
										[$w/2,					0,			0,	0,	$w/2,	$h/3],
										[$w/2,					$h/3,		0,	0,	$w/2,	$h/3],
										[$w/2,					($h/3)*2,	0,	0,	$w/2,	$h/3]
									],
								7=>	[
										[0,						0,			0,	0,	$w/3,	$h/2],
										[0,						$h/2,		0,	0,	$w/3,	$h/2],
										[$w/3,					0,			0,	0,	$w/3,	$h/3],
										[$w/3,					$h/3,		0,	0,	$w/3,	$h/3],
										[$w/3,					($h/3)*2,	0,	0,	$w/3,	$h/3],
										[($w/3)*2,				0,			0,	0,	$w/3,	$h/2],
										[($w/3)*2,				$h/2,		0,	0,	$w/3,	$h/2]
									],
								8=>	[
										[0,						0,			0,	0,	$w/3,	$h/3],
										[0,						$h/3,		0,	0,	$w/3,	$h/3],
										[0,						($h/3)*2,	0,	0,	$w/3,	$h/3],
										[$w/3,					0,			0,	0,	$w/3,	$h/2],
										[$w/3,					$h/2,		0,	0,	$w/3,	$h/2],
										[($w/3)*2,				0,			0,	0,	$w/3,	$h/3],
										[($w/3)*2,				$h/3,		0,	0,	$w/3,	$h/3],
										[($w/3)*2,				($h/3)*2,	0,	0,	$w/3,	$h/3]
									],
								9=>	[
										[0,						0,			0,	0,	$w/3,	$h/3],
										[0,						$h/3,		0,	0,	$w/3,	$h/3],
										[0,						($h/3)*2,	0,	0,	$w/3,	$h/3],
										[$w/3,					0,			0,	0,	$w/3,	$h/3],
										[$w/3,					$h/3,		0,	0,	$w/3,	$h/3],
										[$w/3,					($h/3)*2,	0,	0,	$w/3,	$h/3],
										[($w/3)*2,				0,			0,	0,	$w/3,	$h/3],
										[($w/3)*2,				$h/3,		0,	0,	$w/3,	$h/3],
										[($w/3)*2,				($h/3)*2,	0,	0,	$w/3,	$h/3]
									],
								10=>[
										[0,						0,			0,	0,	$w/3,	$h/3],
										[0,						$h/3,		0,	0,	$w/3,	$h/3],
										[0,						($h/3)*2,	0,	0,	$w/3,	$h/3],
										[$w/3,					0,			0,	0,	$w/3,	$h/4],
										[$w/3,					$h/4,		0,	0,	$w/3,	$h/4],
										[$w/3,					($h/4)*2,	0,	0,	$w/3,	$h/4],
										[$w/3,					($h/4)*3,	0,	0,	$w/3,	$h/4],
										[($w/3)*2,				0,			0,	0,	$w/3,	$h/3],
										[($w/3)*2,				$h/3,		0,	0,	$w/3,	$h/3],
										[($w/3)*2,				($h/3)*2,	0,	0,	$w/3,	$h/3]
									]
							];
			
			return $this;
		}
		
		public function setImages($images)
		{
			if(is_array($images))
			{
				/* get images and check if they are exists. And then store as property. */
				foreach($images as $file)
				{
					if(is_string($file) && file_exists($file))
					{
						$info = new SplFileInfo($file);
						$ext=strtolower($info->getExtension());
						if(array_key_exists($ext, $this->allowed_ext_methd))
						{
							$this->images[]=['file'=>$file, 'ext'=>$ext];
						}
					}
				}
			}
			return $this;
		}
		public function process($fill=false)
		{
			/* Create a blank black image container */
			$img = imagecreatetruecolor($this->render_img_width, $this->render_img_height);
			
			/* Store the maximum number of images available to add in gallery */
			/* This number can't exceed layout amount */
			$max_possible_image_amount=min([count($this->images),count($this->layout)]);
			
			/* loop through every images to set them in gallery based on layout */
			for($i=0;$i<$max_possible_image_amount;$i++)
			{
				/* Create temporary image from current image in loop */
				
				$src = $this->allowed_ext_methd[$this->images[$i]['ext']]['create_from']($this->images[$i]['file']);
				
				/* Get current image real width and height */
				list($width, $height) = getimagesize($this->images[$i]['file']);
				
				/* get all parameters from layout and store in variable */
				list($basepoint_left,
					 $basepoint_top,
					 $left_cut_point,
					 $top_cut_point,
					 $single_image_width_new,
					 $single_image_height_new)=$this->layout[$max_possible_image_amount][$i];

				if($fill==false || $fill!==true)
				{
					/* single layout width and height percentage */
					$l_w_p=round(($single_image_width_new/($single_image_width_new+$single_image_height_new))*100); 
					$l_h_p=100-$l_w_p;
					
					/* single image width and height percentage */
					$i_w_p=round(($width/($width+$height))*100);
					$i_h_p=100-$i_w_p;
					
					/* Make sure images covers their own layout */
					if($i_h_p>$l_h_p)
					{
						$old_height=$height;
						$height=round($width/$l_w_p*$l_h_p);
						$top_cut_point=round(($old_height-$height)/2);
					}
					else if($i_w_p>$l_w_p)
					{
						$old_width=$width;
						$width=round($height/$l_h_p*$l_w_p);
						$left_cut_point=round(($old_width-$width)/2);
					}
					
				}
				
				/* Set images' position in the layout */
				imagecopyresized($img, 
								 $src, 
								 $basepoint_left, 
								 $basepoint_top, 
								 $left_cut_point, 
								 $top_cut_point, 
								 $single_image_width_new, 
								 $single_image_height_new, 
								 $width, 
								 $height);
				
				/* Now destroy the image */
				imagedestroy($src);
			}

			/* store processed images as object property */
			$this->processed_gallery=$img;
			
			/* return this object for method chaining purpose */
			return $this;
		}
		
		public function renderGallery()
		{
			/* This method directly send the rendered single gallery image to browser and terminates script execution.  */
			header('Content-Type: '.$this->allowed_ext_methd[$this->render_img_type]['content-type']);
			$this->allowed_ext_methd[$this->render_img_type]['create_to']($this->processed_gallery);
			exit;
		}
		
		public function getGallery()
		{
			/* This method just return the rendered gallery back to the caller script. Then the caller can do whatever with the gallery. Can save as image file, send to browser etc. */
			return $this->processed_gallery;
		}
		
		function __destruct()
		{
			/* Destroy the gallery image to free up space when this object would be terminated. */
			$this->processed_gallery!==false ? imagedestroy($this->processed_gallery) : 0;
		}
	}
?>
