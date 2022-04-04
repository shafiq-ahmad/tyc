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
class AccountViewAccounts extends View{
	public $id=null;
	public $row;
	public function display($tpl = null){
		$city=null;
		$country=null;
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Account');
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}elseif(Application::$options->tmpl=='com'){
			$this->app->setTmpl('com');
		}else{
			$this->app->setTmpl('adminlte');
		}
		$task = Application::$options->task;
		$models = $this->getModel('accounts');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$this->row = $models->getData($this->id);
		parent::display($tpl);
	}
}