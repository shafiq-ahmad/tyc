<?php
defined('_MEXEC') or die ('Restricted Access');
//spl_autoload_register(function ($class_name) {include $class_name . DS . $class_name . '.php';});

import('core.mobject');
import('core.user');
class Core {
	// Vars 
	public static $application=null;
	private static $document = null;
	private static $database = null;
	private static $user = null;

	function __construct() {}
	
	public static function getApplication (){
		if(is_a(self::$application, 'Application')){
			return self::$application;
		}elseif (!self::$application){
			self::$application = new Application();
		}
		return self::$application;
		
	}

	public static function getDocument (){
		if (!self::$document){
			//self::$document = Document::getInstance();
			self::$document = new Document();
		}
		return self::$document;
		
	}

	public static function getDBO (){
		if (!self::$database){
			if(!class_exists('Database')){
				import('core.database');
			}
			self::$database = Database::getInstance();
		}
		return self::$database;
		
	}

	public static function getUser($login=true){
		//setLog('User ' . $login);
		//if($login){
		//}
		if (!self::$user){
			self::$user = User::getInstance();
			//self::$user = new User();
		}
		return self::$user;
		return false;
	}


	public static function setMsg($msg, $type="info"){
		$messages=array();
		if(isset($_SESSION[_CLIENT]['messages'])){
			//$key=0;$key=count($_SESSION[_CLIENT]['message'])+1;
			$messages=$_SESSION[_CLIENT]['messages'];
		}
		$messages[]='<span class="alert alert-' . $type . '"> ' . $msg . '</span>';
		$_SESSION[_CLIENT]['messages']=$messages;
		return $msg;
	}



}	//End class Core


