<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/


defined('_MEXEC') or die ('Restricted Access');
$time = $_SERVER['REQUEST_TIME'];
if(!isset($_SESSION)){
	session_start();
}
$timeout_duration = 6000;
if (isset($_SESSION['site']['LAST_ACTIVITY']) && 
   ($time - $_SESSION['site']['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['site']['LAST_ACTIVITY'] = $time;

$parts = explode(DS, BASE_PATH);

$messages=array();
$message="";
//Defines
define('BAK_PATH', $parts[0] . DS . 'db_bak' . DS);
define('ROOT_PATH', implode(DS, $parts));
//define('ROOT_PATH', BASE_PATH);
define('SITE_PATH', ROOT_PATH);
define('LOG_PATH', SITE_PATH . DS . 'logs');
define('ADMIN_PATH', ROOT_PATH . DS . 'admin');
//define('LIB_PATH', ROOT_PATH . DS . 'libs');
//define('THEMES_PATH', ROOT_PATH.DS.'templates');

