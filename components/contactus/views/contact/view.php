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

import('core.application.component.view');
class ContactViewContactus extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Contact Us');
		if(Application::$options->task=='json' && $_SERVER['REQUEST_METHOD'] =='POST'){
			$tpl = 'json';
			$this->app->setTmpl('json');
		}else{
			$this->app->setTmpl('page');
		}
		//$models = $this->getModel('contacted_us');
		$m_list = $this->getModel('lists.lists');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$this->cities = $m_list->getCitiesCountry();
		//var_dump($this->row);exit;
		parent::display($tpl);
	}
}
