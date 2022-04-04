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
class Price_listViewShipping extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$port=null;
		$dest_port=null;
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Port');
		$tmpl = $this->getVar('tmpl',null,'get');
		$m_list = $this->getModel('lists.lists');
		$models = $this->getModel('shipping');
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}elseif($tmpl){
			$this->app->setTmpl($tmpl);
		}else{
			$this->app->setTmpl('adminlte');
		}
		$this->id = $this->getVar('id',null,'get');
		$port = $this->getVar('port',null,'get');
		$dest_port = $this->getVar('dest_port',null,'get');
		$veh_type = $this->getVar('veh_type',null,'get');
		$origin_city = $this->getVar('origin_city',null,'get');

		$m_veh = $this->getModel('vehicles.vehicles');
		if(Application::$options->task!='json'){
			$this->veh_types = $m_veh->getVehicleTypes();
			$this->cities = $m_list->getCities(null,null,null,1);
			$this->origin_ports = $models->getPorts(null,null,1);
			$this->dest_ports = $models->getPorts(null,null,null,1);
		}
		if($port){
			$this->row = $models->getPriceListByPort($port,$dest_port,$veh_type,$origin_city);	//port,dest_port
			//exit;
		}else{
			$this->row = $models->getPriceList($this->id);
		}
		parent::display($tpl);
	}
}
