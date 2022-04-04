<?php
defined('_MEXEC') or die ('Restricted Access');


class Document {
	
	private static $instance;
	private $title = '';
	private $scripts = array();
	private $styles = array();
	private $script;
	private $style;

	function __construct() {}

	public static function getMethod(){
		$method = strtoupper($_SERVER['REQUEST_METHOD']);
		return $method;
	}
	
  	public static function getInstance() {
		if (empty(self::$instance)){
			import('core.document');
			$doc = new Document();
			self::$instance = $doc;
		}
		return self::$instance;
	}

	public function addScripts($url, $type = 'text/javascript') {
		$this->scripts[$url]['mime'] = $type;
	}
	
	public function getScripts() {
		$scripts='';
		foreach ($this->scripts as $key => $value){
			$scripts .= '<script type="' . $value['mime'] . '" src="' . $key . '" ></script>' . "\n";
		}
		return $scripts;
	}

	public function addStyles($url, $type = 'text/css', $media = 'all') {
		$this->styles[$url]['mime'] = $type;
		$this->styles[$url]['media'] = $media;
	}
	
	public function getStyles() {
		$styles='';
		foreach ($this->styles as $key => $value){
			$styles .= '<link type="' . $value['mime'] . '" href="' . $key . '" rel="stylesheet" />' . "\n";
		}
		return $styles;
	}

	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}

	public function getHead() {
		$head = $this->getScripts();
		$head .= $this->getStyles();
		$head .= "<title>{$this->getTitle()}</title> \n";
		return $head;
	}

	
}


?>