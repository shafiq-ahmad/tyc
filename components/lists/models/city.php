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


class ModelCity extends Model{

	public function add(){
		$this->table="cities";
		parent::add();
	}
	public function update(){
		//$this->view="countries";	//used for redirect
		//unset($this->data['action']);
		if($this->data['published']=='false'){
			$this->data['published']='off';
		}
		if(isset($this->data['country'])){
			unset($this->data['country']);
		}
		$this->table="cities";
		parent::update();
		
	}
	public function remove(){
		$this->table="cities";
		parent::remove();
	}

}

