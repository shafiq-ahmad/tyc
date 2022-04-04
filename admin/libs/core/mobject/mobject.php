<?php


class Mobject{
	private static $redirect = null;
	protected $_errors = array();
	protected $data = array();
	

	public function __construct($properties = null){
		if ($properties !== null){
			$this->setProperties($properties);
		}
	}

	public function __toString(){  						/*Returns class name*/
		return get_class($this);
	}

	public function redirect($location=NULL){
	  if ($location){
		if (headers_sent()){
			//echo "<script>document.location.href='" . htmlspecialchars($location) . "';</script>\n";
			echo "<script>document.location.href='" . $location . "';</script>\n";
		}
		header("Location: {$location}");
		exit;
	  }
	}

	public function setRedirect($url) {
		self::$redirect = $url;
	}

	public function getRedirect() {
		return self::$redirect;
	}

	public function def($property, $default = null){
		$value = $this->get($property, $default);
		return $this->set($property, $value);
	}

	public function get($property, $default = null){
		if (isset($this->$property)){
			return $this->$property;
		}
		return $default;
	}

	public function getVar($property, $default = null, $type=null){
		if ($type=='get'){
			if(isset($_GET[$property])){
				return $_GET[$property];
			}
		}elseif ($type=='post'){
			if(isset($_POST[$property])){
				return $_POST[$property];
			}
		}elseif ($type=='session'){
			if(isset($_SESSION[$property])){
				return $_SESSION[$property];
			}
		}elseif ($type=='cookie'){
			if(isset($_COOKIE[$property])){
				return $_COOKIE[$property];
			}
		}
		return $default;
	}

	public function getProperties($public = true){
		$vars = get_object_vars($this);
		if ($public){
			foreach ($vars as $key => $value){
				if ('_' == substr($key, 0, 1)){
					unset($vars[$key]);
				}
			}
		}

		return $vars;
	}

	public function getError($i = null, $toString = true){
		// Find the error
		if ($i === null){
			// Default, return the last message
			$error = end($this->_errors);
		}
		elseif (!array_key_exists($i, $this->_errors)){
			// If $i has been specified but does not exist, return false
			return false;
		}
		else{
			$error = $this->_errors[$i];
		}
		// Check if only the string is requested
		if ($error instanceof Exception && $toString){
			return (string) $error;
		}
		return $error;
	}

	public function getErrors(){
		return $this->_errors;
	}

	public function set($property, $value = null){
		$previous = isset($this->$property) ? $this->$property : null;
		$this->$property = $value;
		return $previous;
	}

	public function setProperties($properties){
		if (is_array($properties) || is_object($properties)){
			foreach ((array) $properties as $k => $v){
				// Use the set function which might be overridden.
				$this->set($k, $v);
			}
			return true;
		}

		return false;
	}

	public function setError($error){
		array_push($this->_errors, $error);
	}

	public function setMessage($msg, $type="info"){
		$messages=array();
		if(isset($_SESSION[_CLIENT]['messages'])){
			//$key=0;$key=count($_SESSION[_CLIENT]['message'])+1;
			$messages=$_SESSION[_CLIENT]['messages'];
		}
		$messages[]='<span class="alert alert-' . $type . '"> ' . $msg . '</span>';
		$_SESSION[_CLIENT]['messages']=$messages;
		return $msg;
	}

	public function getMessages($clear=true){
		$messages=array();
		if(isset($_SESSION[_CLIENT]['messages'])){
			$messages=$_SESSION[_CLIENT]['messages'];
		}
		if($clear){
			unset($_SESSION[_CLIENT]['messages']);
		}
		return $messages;
	}


	public function loadPHPFile($file){
		if (file_exists($file)) {
			require_once ($file);
			return true;
		}else{
			//setLog('File not exist: ' . $file, "Error");
		}
		return false;
	}
	
	public function _ago($time){
		if(!is_numeric($time)){
			$time = strtotime($time);
		}
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");

		$now = time();

		$difference     = $now - $time;
		$tense         = "ago";

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1) {
		$periods[$j].= "s";
		}

		return "$difference $periods[$j] 'ago' ";
	}
		
}
