<?php
defined('_MEXEC') or die ('Restricted Access');


class Installer {
	
	private static $instance;

	function __construct() {}

  	public static function getInstance() {
		if (empty(self::$instance)){
			import('core.installer');
			$ins = new Document();
			self::$instance = $ins;
		}
		return self::$instance;
	}


?>