<?php
defined('_MEXEC') or die ('Restricted Access');

require_once("functions.php");

if(empty($_SESSION['token'])){
	$_SESSION['token'] = setCSRFToken();
}
//require_once ('mongodb/autoload.php');
import('core');
import('core.localize');
import('core.mobject');
import('core.application');
import('core.route');
import('core.database');
import('core.database.helper');
import('core.html');
import('core.user');
import('core.mail');
import('core.mediamanager');
require_once 'settings.php';

//$db = Core::getDBO();
//$user = new User();

