<?php
//Turn off all error reporting
//error_reporting(0);
// Report all errors
error_reporting(E_ALL);
// Same as error_reporting(E_ALL);
//ini_set("error_reporting", E_ALL);
define('_MEXEC', 1);
define('_ADMIN', 1);
define('_CLIENT', 'admin');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__FILE__) );
//Call Framework
require_once BASE_PATH . DS . 'includes' . DS . 'defines.php';
require_once BASE_PATH . DS . 'libs' . DS . 'libs.php';
//$user = core::getUser();
$app = core::getApplication();

//unset($_SESSION[Application::$client]);
//print_r($_SESSION[Application::$client]);exit;
		/*session_unset();
		session_destroy();*/
//print_r($_SESSION);
//exit;
$app->render();
