<?php
defined('_MEXEC') or die ('Restricted Access');
$db = Core::getDBO();
import('core.html');

$vehicle_types = array(1=>'Regular', 2=>'Bike', 3=>'Big Pickup');
$countries_o = $db->loadTable('countries','is_origin=1');
$countries_d = $db->loadTable('countries','is_destination=1');


require_once("tmpl/default.php");

