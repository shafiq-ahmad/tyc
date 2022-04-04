<?php
defined('_MEXEC') or die ('Restricted Access');


class Meta{
	private static $locale = null;
	private static $lang = null;
	
	public static function _($key){
		// get from db
		
		return $key;
	}

	public static function setMeta($key, $val){
		if(!$key || !$val){
			return false;
		}
		return self::$key;
	}

	
	
}

