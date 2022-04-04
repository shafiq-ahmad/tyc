<?php
defined('_MEXEC') or die ('Restricted Access');

if(!class_exists('Mediamanager')){
	import('core.mediamanager');
}
class Images extends Mediamanager{
	public static $_user=null;
	public static $jpg_quality=60;
	public static $png_quality=-1;
	public static $pc_w_max=1920;		//Ratio: 1.77,0.5625
	public static $pc_h_max=1080;
	public static $tablet_w_max=1024;	//Ratio: 1.33, 0.75
	public static $tablet_h_max=768;
	public static $mobile_w_max=640;	//Ratio: 1.77,0.5625
	public static $mobile_h_max=360;
	public static $thumb_w_max=300;		//Ratio: 1.77,0.5625
	public static $thumb_h_max=169;
	
	
	public function __construct(){}
	

	public static function upload($file, $base_path='',$params=array()){
		ini_set('upload_max_filesize', '5M');
		ini_set('post_max_size', '5M');
		ini_set('max_input_time', 300);
		ini_set('max_execution_time', 300);
		//setLog($base_path,'log');exit;
		$output_src=array();
		$base_path = 'media' . DS . 'images' . DS . $base_path;
		if (!file_exists($base_path)) {
			mkdir($base_path, 0777, true);
		}
		
		
		$file_size_limit = 1024*1024*5; // if file size is larger than 5 Megabytes
		$allow_file_types = 'gif|jpg|png';
		
		//setLog('name' . $file["name"], 'tttt');
		$fileName = $file["name"]; // The file name
		$fileTmpLoc = $file["tmp_name"]; // File in the PHP tmp folder
		$fileType = $file["type"]; // The type of file it is
		$fileSize = $file["size"]; // File size in bytes
		$fileErrorMsg = $file["error"]; // 0 for false... and 1 for true
		//$kaboom = explode(".", $fileName); // Split file name into an array using the dot
		//$fileExt = end($kaboom); // Now target the last array element to get the file extension
		//echo $fileSize;exit;
		$dimensions = getimagesize($file["tmp_name"]);
		$image_width = $dimensions[0];
		$image_height = $dimensions[1];
		$mega_pixels = ($image_height*$image_width)/1000000;
		//var_dump($dimensions);exit;
		try{
			if (!$fileTmpLoc) { // if file not chosen
				$msg="ERROR: Please browse for a file before clicking the upload button.";
				throw new Exception($msg, 610);
			} else if($fileSize > $file_size_limit) {
				//echo " ";
				unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				$msg="ERROR: Your file was larger than " . round($file_size_limit/1024/1024) . " Megabytes in size.";
				throw new Exception($msg, 610);
				//exit();
			} else if (!preg_match("/.({$allow_file_types})$/i", $fileName) ) {
				unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				$msg="ERROR: Your image was not " . $allow_file_types;
				throw new Exception($msg, 610);
				//exit();
			}else if ($mega_pixels > 5) {
				$msg="ERROR: Max image dimensions 5M exceeded.";
				throw new Exception($msg, 610);
				//exit();
			}else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
				$msg="ERROR: An error occured while uploading the file. Try again.";
				throw new Exception($msg, 610);
				//exit();
			}
			$fileName = time() . '_' . $fileName;
			$source_file = $base_path . DS . "$fileName";
			$moveResult = move_uploaded_file($fileTmpLoc, $source_file);
			// Check to make sure the move result is true before continuing
			if ($moveResult != true) {
				echo "ERROR: File not uploaded. Try again.";
				unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				//exit();
			}
			//unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
			
			//$dimensions = getimagesize($source_file);
			$img_mime = $dimensions['mime'];
			list($width, $height, $type, $attr) = getimagesize($source_file);


			$resource = imagecreatefromjpeg($source_file);

			if ($img_mime == "image/gif"){ 
				imagegif($resource, $source_file);
			} else if($img_mime =="image/png"){ 
				imagepng($resource, $source_file, self::$png_quality);
			} else { 
				imagejpeg($resource, $source_file, self::$jpg_quality);
			}




			$pc_file = $base_path . DS . "pc_$fileName";
			//self::img_resize($source_file, $source_file, $img_mime, self::$pc_w_max, self::$pc_h_max);
			self::img_resize($source_file, $pc_file, $img_mime, self::$pc_w_max, self::$pc_h_max);
			$output_src[] = $source_file . " {$width}w";
			
			$tablet_file = $base_path . DS . "tablet_$fileName";
			self::img_resize($source_file, $tablet_file, $img_mime, self::$tablet_w_max, self::$tablet_h_max);
			list($width, $height, $type, $attr) = getimagesize($tablet_file);
			$output_src[] = $tablet_file . " {$width}w";
			$mobile_file = $base_path . DS . "mobile_$fileName";
			self::img_resize($source_file, $mobile_file, $img_mime, self::$mobile_w_max, self::$mobile_h_max);
			list($width, $height, $type, $attr) = getimagesize($mobile_file);
			$output_src[] = $mobile_file . " {$width}w";
			
			// ------ Start Adams Universal Image Thumbnail(Crop) Function ------
			$thumbnail = $base_path . DS . "thumb_$fileName";
			self::img_resize($mobile_file, $thumbnail, $img_mime, self::$thumb_w_max, self::$thumb_h_max);
			//self::img_thumb($mobile_file, $thumbnail, $img_mime, self::$thumb_w_max, self::$thumb_h_max);
			list($width, $height, $type, $attr) = getimagesize($mobile_file);
			$output_src[] = $mobile_file . " {$width}w";
			// Display things to the page so you can see what is happening for testing purposes

			$srcset = implode(",",$output_src);
			$media_id = self::saveMedia($source_file, $pc_file, $tablet_file, $mobile_file, $thumbnail, $fileSize, $srcset);
			return $media_id;
			
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			setLog($res,'error');
			Core::setMsg($e->getMessage(),'danger');
			//echo $res;exit;
			return false;
		}
	}

	public static function upload_w_watermark_($file, $base_path='',$params=array()){	//upload with watermark feature
		ini_set('upload_max_filesize', '5M');
		ini_set('post_max_size', '5M');
		ini_set('max_input_time', 300);
		ini_set('max_execution_time', 300);
		$output_src=array();
		$base_path = 'media' . DS . 'images' . DS . $base_path;
		if (!file_exists($base_path)) {
			mkdir($base_path, 0777, true);
		}
		
		
		$file_size_limit = 2097152; // if file size is larger than 5 Megabytes
		$allow_file_types = 'gif|jpg|png';
		
		$fileName = $file["name"]; // The file name
		$fileTmpLoc = $file["tmp_name"]; // File in the PHP tmp folder
		$fileType = $file["type"]; // The type of file it is
		$fileSize = $file["size"]; // File size in bytes
		$fileErrorMsg = $file["error"]; // 0 for false... and 1 for true
		//$kaboom = explode(".", $fileName); // Split file name into an array using the dot
		//$fileExt = end($kaboom); // Now target the last array element to get the file extension
		
		if (!$fileTmpLoc) { // if file not chosen
			echo "ERROR: Please browse for a file before clicking the upload button.";
			//exit();
		} else if($fileSize > $file_size_limit) {
			//echo "ERROR: Your file was larger than " . round($file_size_limit/1024/1024) . " Megabytes in size.";
			unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
			//exit();
		} else if (!preg_match("/.({$allow_file_types})$/i", $fileName) ) {
			echo "ERROR: Your image was not " . $allow_file_types;
			unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
			//exit();
		} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
			saveLog("ERROR: An error occured while uploading the file. Try again.");
			echo("ERROR: An error occured while uploading the file. Try again.");
			//exit();
		}
		$fileName = time() . '_' . $fileName;
		$source_file = $base_path . DS . "$fileName";
		$moveResult = move_uploaded_file($fileTmpLoc, $source_file);
		// Check to make sure the move result is true before continuing
		if ($moveResult != true) {
			echo "ERROR: File not uploaded. Try again.";
			unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
			//exit();
		}
		//unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
		
		$dimensions = getimagesize($source_file);
		$img_mime = $dimensions['mime'];
		list($width, $height, $type, $attr) = getimagesize($source_file);


/**  code for watermark start here */
//list($w_orig, $h_orig) = getimagesize($source_file);
$scale_ratio = $width / $height;		
$w2 = $width * $scale_ratio;
$h2 = $height * $scale_ratio;


// Image resource for original image
$resource = imagecreatefromjpeg($source_file);
		
// Set dimensions for image watermark
$markW = 271;
$markH = 71;
$margin_bottom = $margin_right = 30;

// Create resource for image watermark
$watermark = imagecreatefrompng('media/images/logo.png');

// Merge the watermark into the main image resource
imagecopy($resource, $watermark, $width - $markW - $margin_right, $height - $markH - $margin_bottom, 0, 0, $markW, $markH);
// Loop through the scaling ratios to generate resized images	
	
//imagedestroy($output);

if ($img_mime == "image/gif"){ 
	imagegif($resource, $source_file);
} else if($img_mime =="image/png"){ 
	imagepng($resource, $source_file, self::$png_quality);
} else { 
	imagejpeg($resource, $source_file, self::$jpg_quality);
}




		$pc_file = $base_path . DS . "pc_$fileName";
		//self::img_resize($source_file, $source_file, $img_mime, self::$pc_w_max, self::$pc_h_max);
		self::img_resize($source_file, $pc_file, $img_mime, self::$pc_w_max, self::$pc_h_max);
		$output_src[] = $source_file . " {$width}w";
		
		$tablet_file = $base_path . DS . "tablet_$fileName";
		self::img_resize($source_file, $tablet_file, $img_mime, self::$tablet_w_max, self::$tablet_h_max);
		list($width, $height, $type, $attr) = getimagesize($tablet_file);
		$output_src[] = $tablet_file . " {$width}w";
		$mobile_file = $base_path . DS . "mobile_$fileName";
		self::img_resize($source_file, $mobile_file, $img_mime, self::$mobile_w_max, self::$mobile_h_max);
		list($width, $height, $type, $attr) = getimagesize($mobile_file);
		$output_src[] = $mobile_file . " {$width}w";
		
		// ------ Start Adams Universal Image Thumbnail(Crop) Function ------
		$thumbnail = $base_path . DS . "thumb_$fileName";
		self::img_resize($mobile_file, $thumbnail, $img_mime, self::$thumb_w_max, self::$thumb_h_max);
		//self::img_thumb($mobile_file, $thumbnail, $img_mime, self::$thumb_w_max, self::$thumb_h_max);
		list($width, $height, $type, $attr) = getimagesize($mobile_file);
		$output_src[] = $mobile_file . " {$width}w";
		// Display things to the page so you can see what is happening for testing purposes

		$srcset = implode(",",$output_src);
		$media_id = self::saveMedia($source_file, $pc_file, $tablet_file, $mobile_file, $thumbnail, $fileSize, $srcset);
		return $media_id;
	}

	// -------------- RESIZE FUNCTION -------------
	// Function for resizing any jpg, gif, or png image files
	public static function img_resize($source, $dest, $mime, $w=null, $h=null) {
		$img = "";
		if ($mime == "image/gif"){ 
			$img = imagecreatefromgif($source);
		} else if($mime =="image/png"){ 
			$img = imagecreatefrompng($source);
		} else{ 
			$img = imagecreatefromjpeg($source);
		}
		if($w && $h){
				$req_ratio = $w/$h;
			//if($w<$h){
			//}else{
			//	$req_ratio = $h/$w;
			//}
			list($w_orig, $h_orig) = getimagesize($source);
			$scale_ratio = $w_orig / $h_orig;
			if($req_ratio != $scale_ratio){	//if need to custome size
				$src_x = ($w_orig / 2) - ($w / 2);
				$src_y = ($h_orig / 2) - ($h / 2);
			}else{
				$src_x = 0;
				$src_y = 0;
				//$w_orig = $w;
				//$h_orig = $h;
			}
			/*if(($w / $h) > $scale_ratio){
				$w = $h * $scale_ratio;
			}else{
				$h = $w / $scale_ratio;
			}*/
			if(($w / $h) > $scale_ratio){
				$w = $h * $scale_ratio;
			}else{
				$h = $w / $scale_ratio;
			}
			//$tci = imagecreatetruecolor($w, $h);
			$tci = imagecreatetruecolor($w, $h);
			//imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) : bool
			  imagecopyresampled($tci	   ,	   $img,      0,      0,      0,      0,     $w,     $h, $w_orig, $h_orig);
		}else{
			$tci=$img;
		}
		if ($mime == "image/gif"){ 
			imagegif($tci, $dest);
		} else if($mime =="image/png"){ 
			imagepng($tci, $dest, self::$png_quality);
		} else { 
			imagejpeg($tci, $dest, self::$jpg_quality);
		}
		return $dest;
	}
	// ------------- THUMBNAIL (CROP) FUNCTION -------------
	// Function for creating a true thumbnail cropping from any jpg, gif, or png image files
	
	public static function _img_thumb($source, $dest, $mime, $w=null, $h=null) {
		$img = "";
		if ($mime == "image/gif"){ 
			$img = imagecreatefromgif($source);
		} else if($mime =="image/png"){ 
			$img = imagecreatefrompng($source);
		} else { 
			$img = imagecreatefromjpeg($source);
		}
		if($w && $h){
			list($w_orig, $h_orig) = getimagesize($source);
			$src_x = ($w_orig / 2) - ($w / 2);
			$src_y = ($h_orig / 2) - ($h / 2);
			$tci = imagecreatetruecolor($w, $h);
			imagecopyresampled($tci, $img, 0, 0, $src_x, $src_y, $w, $h, $w, $h);
		}else{
			$tci=img;
		}
		if ($mime == "image/gif"){ 
			imagegif($tci, $dest);
		} else if($mime =="image/png"){ 
			imagepng($tci, $dest, self::$png_quality);
		} else { 
			imagejpeg($tci, $dest, self::$jpg_quality);
		}
		
		return $dest;
	}

	public function iptc_make_tag($rec, $data, $value){
		$length = strlen($value);
		$retval = chr(0x1C) . chr($rec) . chr($data);
		if($length < 0x8000){
			$retval .= chr($length >> 8) .  chr($length & 0xFF);
		}else{
			$retval .= chr(0x80) . chr(0x04) . chr(($length >> 24) & 0xFF) . chr(($length >> 16) & 0xFF) . chr(($length >> 8) & 0xFF) . chr($length & 0xFF);
		}
		return $retval . $value;
	}

	
	protected static function saveMedia($source, $pc='', $tablet='', $mobile='', $thumb='', $file_size=0,$srcset=''){
		if(!$source){return false;}
		$img_info = getimagesize($source);
		$img_mime = $img_info['mime'];
		$db = Core::getDBO();
		$user_id=0;
		$user = Core::getUser()->isLogin();
		if(self::$_user){
			$user_id=self::$_user;
			self::$_user = null;
		}elseif($user){
			$user_id = $user['id'];
		}
		
		$source = mysqli_real_escape_string($db->conn,$source);
		if($tablet){
			$tablet = mysqli_real_escape_string($db->conn,$tablet);
		}
		if($mobile){
			$mobile = mysqli_real_escape_string($db->conn,$mobile);
		}
		if($thumb){
			$thumb = mysqli_real_escape_string($db->conn,$thumb);
		}
		if($pc){
			$pc = mysqli_real_escape_string($db->conn,$pc);
		}
		if($srcset){
			$srcset = mysqli_real_escape_string($db->conn,$srcset);
		}
		$sql='INSERT INTO media(media_type, mime, file, img_pc, img_tablet, img_mobile, img_thumb, file_size, srcset, user_id) VALUES (';
		$sql.="1, '{$img_mime}', '{$source}', '{$pc}', '{$tablet}', '{$mobile}','{$thumb}','{$file_size}','{$srcset}','{$user_id}') ";
		//echo $sql;exit;
		$ri = $db->insert_by_sql($sql);
		return $db->insert_id();
		
	}
	
	public static function removeMedia($source){
		if(!$source){return false;}
		$file = SITE_PATH . DS . $source;
		if (file_exists($file)) {
			//echo $source;
			$res = unlink($file);
			return $res;
		}

		echo 'nothing...' . $file;
		return false;
		
	}
	
	
	
}

/*



//var_dump($_POST['imgs_sel']);
$sel_images = $_POST['imgs_sel'];
foreach($sel_images as $si){
	$img_info = getimagesize($si);
	$img_mime = $img_info['mime'];
	$file_name = basename($si);
	

	if($add_tags_jpg){
		// Set the IPTC tags
		$iptc = array(
			'2#015' => $post_title,	//category
			'2#025' => $tags,	//Tags
			'2#080' => $post_url,	//Author
			'2#120' => $file_name,	//Title
			'2#116' => 'Copyright 2015-2019, First Newspaper');
		// Convert the IPTC tags into binary code
		$data = '';

		foreach($iptc as $tag => $string){
			$tag = substr($tag, 2);
			$data .= iptc_make_tag(2, $tag, $string);
		}
		// Embed the IPTC data
		$content = iptcembed($data, $si);
		
		
		$fp = fopen($si, "wb");
		if(!fwrite($fp, $content)){
			echo 'Error......';exit;
		}
		fclose($fp);
	}
}



// following code is used to saperate files in new src.. tag of <img>
$file = $i->srcset;
if(!$file){
	$file = $i->src;
}
//var_dump(explode(',',$file));
$arr = explode(',',$file);
foreach($arr as $a){
	$dot = strrpos($a,'.',-1);
	$space = strrpos($a,' ',-1);
	//echo $dot . ' : ' . $space;exit;
	if(($space-$dot)==4){
		$a = substr($a,0,$space);
	}
	//$img_server_path = str_replace($publich_path, ABSPATH, $a);
	$a = trim($a);
	$all_images[]=$a;
}





*/