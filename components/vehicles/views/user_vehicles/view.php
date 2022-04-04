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
class User_vehiclesViewVehicles extends View{
	public $id=0;
	public function display($tpl = null){
		$user = Core::getUser()->getUser();
		$city=null;
		if(isset($_POST['city']) && $_POST['city']){
			$city=$_POST['city'];
		}
		$this->app = core::getApplication();
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}else{
			$this->app->setTmpl('page');
		}
		$this->app->setTitle('User Vehicles');
		$model = $this->getModel('vehicles');
		$this->rows = $model->getUserVehicles(null, true);
		parent::display($tpl);
	}
}
