<?php
defined('_MEXEC') or die ('Restricted Access');


function redirect_( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

	
function import($key, $base = null) {
	// Setup some variables.
	//setLog("File not exist: {$key}", "Log");
	$parts = explode('.', $key);
	$file_name = array_pop($parts);
	
	
	//$base = (!empty($base)) ? $base : ADMIN_PATH;
	$path = str_replace('.', DS, $key);
	//$class = ucfirst($file_name);

	if (strpos($path, 'core') === 0) {
		$file = ADMIN_PATH . DS . 'libs' . DS . $path . DS . $file_name . '.php';
		if (!is_file($file)) {
			$file = ADMIN_PATH . DS . 'libs' . DS . $path . '.php';		
		}
		if (file_exists($file)) {
			require_once $file;
			return true;
		}else{
			setLog("File not exist: {$file}", "Error");
		}
	}else{
		$file = ADMIN_PATH . DS . $path . DS . $file_name . '.php';
		if (!file_exists($file)) {
			$file = ADMIN_PATH . DS . $path . '.php';		
		}
		if (file_exists($file)) {
			require_once $file;
			return true;
		}else{
			setLog("File not exist: {$file}", "Error");
		}
	}
	//if (class_exists($class)) { return; }

}

function setLog($m='',$type='Log', $path=null, $file=null){
	$log_file = LOG_PATH . DS;
	if($path){
		$log_file .= LOG_PATH . DS;
	}
	$log_file .= date('Y-m-d', time()) . DS;
	if (!file_exists($log_file)) {
		mkdir($log_file, 0777, true);
	}
	if($file){
		$log_file .= $file . '.log';
	}else{
		$log_file .= 'app_log.log';
	}
	$handle = fopen($log_file, "aw");
	//$msg = $type.": time is " . date('l jS \of F Y h:i:s A', time()); // . "\n\t";
	$msg = $type.": time is " . date('h:i:s A', time());
	$msg .= ' message: ' . $m . "\n\n";
	fwrite($handle, $msg);
	fclose($handle);
}

function getClass($obj){
	return get_class ($obj);
}

function isObject($var){
	return is_object($var);
}

function raiseError($error, $e_no=610){
	//trigger_error ( string $error_msg [, int $error_type = E_USER_NOTICE ] ) : bool
    throw new Exception($error,$e_no);
}

function setCSRFToken(){
	return bin2hex(random_bytes(32));
}


