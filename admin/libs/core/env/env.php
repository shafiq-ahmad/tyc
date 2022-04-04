<?php
defined('_MEXEC') or die ('Restricted Access');


class Request {
	
	private $method;

	function __construct() {}

	public static function getMethod(){
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		return $method;
	}
	
	public static function getVar($name, $default=false){
		$var = $default;
		if(isset($_GET["{$name}"])){
			$var = $_GET["{$name}"];
		}
		if(isset($_POST["{$name}"])){
			$var = $_POST["{$name}"];		
		}
		return $var;
	}

	
}

class URI {
	
	//private $var;

	function __construct() {}
	
	public static function getURL(){
		$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		return $url;
	}

	public static function requestURL(){
		$url = $_SERVER['REQUEST_URI'];
		return $url;
	}

	
}


?>