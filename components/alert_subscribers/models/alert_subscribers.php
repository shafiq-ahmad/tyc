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


class ModelAlert_subscribers extends Model{

	public function getData($id=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM alert_subscribers AS a ";
		if($id){
			$sql .= "WHERE id={$id} ";
			$res = $db->get_by_sqlRow($sql);
		}else{
			$sql .= "ORDER BY id DESC ";
			$res = $db->get_by_sqlRows($sql);
		}
		return $res;
	}

	public function add(){}
	public function update(){}
	public function remove(){}

}

