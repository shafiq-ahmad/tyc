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
class PortViewShipping extends View{
	public $id=null;
	public $row;
	public function display($tpl = null){
		$city=null;
		$country=null;
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Port');
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}elseif(Application::$options->tmpl=='com'){
			$this->app->setTmpl('com');
		}else{
			$this->app->setTmpl('adminlte');
		}
		$task = Application::$options->task;
		$model_l = $this->getModel('lists.lists');
		$models = $this->getModel('shipping');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if(isset($_GET['city_id'])){
			$this->city = $_GET['city_id'];
		}

		//$this->countries = $models->getCountries();
		$this->row = $models->getPorts($this->id);
		if(isset($this->row['country_id'])){
			$country=$this->row['country_id'];
		}
		$this->cities = $model_l->getCitiesCountry($city,$country);
		//$this->port_cities = $models->getPortCities($this->id);
		//var_dump($this->port_cities);exit;
		parent::display($tpl);
	}
}
