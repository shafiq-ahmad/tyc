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
class Vehicle_adminViewVehicles extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Vehicle');
		if(Application::$options->task=='json' && $_SERVER['REQUEST_METHOD'] =='POST'){
			$tpl = 'json';
			$this->app->setTmpl('json');
		}else{
			$this->app->setTmpl('adminlte');
		}
		$models = $this->getModel('vehicles');
		$model = $this->getModel('vehicle');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$this->years = $models->getYears();
		$this->conditions = $models->getConditionTypes();
		$this->fuels = $models->getFuelTypes();
		$this->drives = $models->getDriveTypes();
		$this->engines = $models->getEngineTypes();
		$this->transmissions = $models->getTransmissions();
		$this->makes = $models->getMakes();
		$this->images = $model->getVehicleImages($this->id);
		$this->row = $models->getVehicles($this->id, false);
		//echo $this->id;
		//var_dump($this->row);exit;
		parent::display($tpl);
	}
}
