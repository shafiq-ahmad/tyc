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
require_once BASE_PATH . DS . 'includes' . DS . 'defines.php';
require_once SITE_PATH . DS . 'config.php';
require_once ADMIN_PATH . DS . 'libs' . DS . 'libs.php';

$app = Core::getApplication(); /*Getting app object*/
//$app->saveURI();
$app->setTmpl('jsonss');
$app->render();

echo $app->output;

