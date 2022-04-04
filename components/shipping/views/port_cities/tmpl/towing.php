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
$db=Core::getDBO();
$city_id = $this->getVar('city_id',null,'get');
$port_id = $this->getVar('port_id',null,'get');
$veh_type = $this->getVar('veh_type',null,'get');

header("Content-Type: application/json; charset=UTF-8");
if($city_id && $port_id && $veh_type){
	$sql = "SELECT * FROM port_cities WHERE city_id={$city_id} AND port_id={$port_id} AND vehicle_type={$veh_type} ";
	$row = $db->get_by_sqlRow($sql);
	echo json_encode(array(
		'data' => $row
	));
	exit;
}


