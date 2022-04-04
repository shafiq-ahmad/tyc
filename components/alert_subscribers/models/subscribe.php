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


class ModelSubscribe extends Model{

	public function add(){
		$this->view="subscribe";	//used for redirect
		//unset($this->data['action']);
		$this->table="alert_subscribers";
		$u = parent::add();
		
		$res = json_encode(array(
			'data' => array(
			'updated' => $u,
			),
		));
		header("Content-Type: application/json; charset=UTF-8");
		echo $res;exit;
		return $res;
	}
	public function update(){
		//parent::update();
		
	}
	public function remove(){}


}

