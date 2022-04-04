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
class Port_citiesViewShipping extends View{
	public $port_cities=null;
	public $row;
	public function display($tpl = null){
		$city=null;
		$country=null;
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Port');
		$model_l = $this->getModel('lists.lists');
		$models = $this->getModel('port_cities');
		$m_shipping = $this->getModel('shipping');
		$m_veh = $this->getModel('vehicles.vehicles');
		$this->id = $this->getVar('id',null,'get');
		if($this->id){
			$this->row = $m_shipping->getPortCityByID($this->id);
		}
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}elseif(Application::$options->tmpl=='com'){
			$this->app->setTmpl('com');
		}else{
			$this->app->setTmpl('adminlte');
		}
		$this->port_id = $this->getVar('port_id',null,'get');
		if(!$this->port_id){
			$this->port_id = $this->id;
		}
		//echo ($this->port_id);exit;
		$this->veh_types = $m_veh->getVehicleTypes();
		$this->port = $m_shipping->getPorts($this->port_id);
		$this->port_cities = $models->getPortCities($this->port_id);

		$this->city = $this->getVar('city_id',null,'get');

		if(isset($this->port['country_id'])){
			$country=$this->port['country_id'];
		}
		$this->cities = $model_l->getCitiesCountry($city,$country);
		//var_dump($this->port_cities);exit;
		parent::display($tpl);
	}
}
