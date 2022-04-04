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
class ContactusViewContactus extends View{
	public $id=null,$rows=null;
	public function display($tpl = null){
		$app = core::getApplication();
		//$app->secure();
		$app->setTitle('Vehicles');
		
		if(Application::$options->task=='json' || $_SERVER['REQUEST_METHOD'] =='POST'){
			//Application::$options->task='json';
			//$tpl = 'json';
			$app->setTmpl('json');
		/*	$this->rows = array($_POST['action'],
			Application::$options->com,
			Application::$options->view,
			Application::$options->task
			);*/
		}else{
			$app->setTmpl('page');
		}
		
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$model = $this->getModel('contactus');
		//$this->rows = $this->getData();
		
		parent::display($tpl);
	}
}
