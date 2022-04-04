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
class MakeViewVehicles extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$user = Core::getUser()->getUser();
		$this->app->setTitle('Add / Edit Vehicle');
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}else{
			$this->app->setTmpl('adminlte');
		}
		$task = Application::$options->task;
		$models = $this->getModel('vehicles');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$this->row = $models->getMakes($this->id);
		parent::display($tpl);
	}
}
