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
class Admin_replyViewContactus extends View{
	public $id=0;
	public function display($tpl = null){
		$id=null;
		$visibility=3;
		$this->app = core::getApplication();
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}else{
			$this->app->setTmpl('adminlte');
		}
		$this->app->setTitle('Vehicles Admin');
		$model = $this->getModel('vehicles');
		$this->rows = $model->getAdminVehicles($id, $visibility);
		parent::display($tpl);
	}
}
