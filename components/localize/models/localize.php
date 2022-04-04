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


class ModelLocalize extends Model{
	public function add(){
		parent::add();
	}
	public function update(){
		//$this->view="countries";	//used for redirect
		//unset($this->data['action']);
		//$this->table="countries";
		parent::update();
		
	}
	public function remove(){
		$this->view="countries";	//used for redirect
		$this->table="countries";
		parent::remove();
	}

}

