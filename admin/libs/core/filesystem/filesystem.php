<?php
defined('_MEXEC') or die ('Restricted Access');


class Filesystem {
	
	private static $instance;

	function __construct() {}

  	public static function getInstance() {
		if (empty(self::$instance)){
			import('core.filesystem');
			$fs = new Filesystem();
			self::$instance = $fs;
		}
		return self::$instance;
	}
	
	
  	public static function newFile($filename, $path='.') {
		//if(!$path){}
		$file = $path . DS . $filename;
		$fileH = fopen($file, "x+") or die("Unable to open file!");
		//echo fread($fileH,filesize($file));
		fclose($fileH);
		
	}
	
	
	
public function replace_extension($filename, $new_extension) {
	$new_filename = preg_replace('/\..+$/', '.' . $new_extension, $filename);
	return $new_filename;
}

public function rep_local_path_server($filename, $new_extension) {
	
	//$img_server_path = str_replace($publich_path, ABSPATH, $file);
	//$img_server_path = str_replace('//', '/', $img_server_path);
	/***************** Delete the following for live server *****************/
	//$img_server_path = str_replace('/', '\\', $img_server_path);
}

	
	
}


