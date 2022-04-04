<?php
defined('_MEXEC') or die ('Restricted Access');
defined('_ADMIN') or die ('Restricted Access');
$time = $_SERVER['REQUEST_TIME'];
if(!isset($_SESSION)){
	session_start();
}
$timeout_duration = 5000;
if (isset($_SESSION['admin']['LAST_ACTIVITY']) && 
   ($time - $_SESSION['admin']['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['admin']['LAST_ACTIVITY'] = $time;


$parts = explode(DS, BASE_PATH);
$messages=array();
$message="";
//Defines
define('ROOT_PATH', implode(DS, $parts));
//define('ROOT_PATH', BASE_PATH);
define('ADMIN_PATH', ROOT_PATH);
array_pop($parts);
define('SITE_PATH', implode(DS, $parts));
define('LOG_PATH', SITE_PATH . DS . 'logs');
//define('LIB_PATH', ROOT_PATH . DS . 'libraries');
//define('THEMES_PATH', ROOT_PATH.DS.'templates');


?>