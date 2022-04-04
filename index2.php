<?php
//Turn off all error reporting
//error_reporting(0);
// Report all errors
error_reporting(E_ALL);
// Same as error_reporting(E_ALL);
//ini_set("error_reporting", E_ALL);
define('_MEXEC', 1);
define('_CLIENT', 'site');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__FILE__) );
//Call Framework

/*require_once BASE_PATH . DS . 'includes' . DS . 'defines.php';
require_once ADMIN_PATH . DS . 'libs' . DS . 'libs.php';*/
session_start();
if(!isset($_SESSION['counter'])){
	$_SESSION['counter']=1;
}else{
	$_SESSION['counter']=$_SESSION['counter']+1;
}
$counter=$_SESSION['counter'];

$log_file = BASE_PATH . DS . 'app_log.log';
$handle = fopen($log_file, "aw");
//open and save log
$msg = ": time is " . date('l jS \of F Y h:i:s A', time()); // . "\n\t";
$msg .= ' message: ' . $counter . "\n\n";
fwrite($handle, $msg);
fclose($handle);
//$app = Core::getApplication('index file'. $counter);
//$app->render();
//echo $app->output;

