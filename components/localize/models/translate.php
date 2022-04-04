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


class ModelTranslate extends Model{
	public function add(){
		//parent::add();
	}
	public function update(){
		if(isset($_POST['en'])){
			$en=json_encode($_POST['en']);
			$file=SITE_PATH . DS . 'languages' . DS . 'en.json';
			file_put_contents($file,$en);
		}
		if(isset($_POST['ar'])){
			$ar=json_encode($_POST['ar']);
			$file=SITE_PATH . DS . 'languages' . DS . 'ar.json';
			file_put_contents($file,$ar);
		}
		if(isset($_POST['tr'])){
			$tr=json_encode($_POST['tr']);
			$file=SITE_PATH . DS . 'languages' . DS . 'tr.json';
			file_put_contents($file,$tr);
			//var_dump($_POST['tr']);
			//echo $tr;
			//setLog($tr);
			//exit;
		}
		$this->redirect('index.php?com=localize&view=translate');
		
	}
	public function remove(){
		$this->view="countries";	//used for redirect
		$this->table="countries";
		parent::remove();
	}

}

