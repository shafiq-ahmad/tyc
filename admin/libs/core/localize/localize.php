<?php
defined('_MEXEC') or die ('Restricted Access');


class Localize{
	private static $locale = null;
	private static $lang = null;
	
	public function getLangs(){
		return array('ar','en','tr');
		
	}
	
	public function getLangsData(){
		$langs = $this->getLangs();
		//var_dump($langs);exit;
		$res = array();
		foreach($langs as $lang){
			//$this-rows[] = $this->getLangsData();
			$file= SITE_PATH . DS . 'languages' . DS . $lang . '.json';
			$res[$lang] = json_decode(file_get_contents($file), true);;
		}
		return $res;
		
	}

	public static function getLocale($lang=null){
		if (!self::$locale){
			if(!$lang){
				$lang=self::getLang();
			}
			$file= SITE_PATH . DS . 'languages' . DS . $lang . '.json';
			self::$locale = json_decode(file_get_contents($file), true);;
		}
		return self::$locale;
		
	}

	public static function _($key){
		$locale = self::getLocale();
		if(isset($locale[$key]) && $locale[$key]){
			return $locale[$key];
		}
		return $key;
	}

	public static function getLang(){
		if(isset(self::$lang)){
			return self::$lang;
		}
		if(isset($_GET['lang']) && $_GET['lang']){
			return $_SESSION['lang'] = $_GET['lang'];
		}
		if(isset($_SESSION['lang'])){
			return self::$lang = $_SESSION['lang'];
		}
		if(isset($_COOKIE['lang'])){
			return self::$lang = $_SESSION['lang']=$_COOKIE['lang'];
		}
		return 'en';
		//return self::setLang();
	}

	public static function setLang($lang){
		if(!$lang){
			return false;
		}
		setcookie("lang", $lang, time()+(60*60*24*365), '/');
		self::$lang = $_SESSION['lang'] = $lang;
		header("Location: index.php");
		return self::$lang;
	}

	
	
}

