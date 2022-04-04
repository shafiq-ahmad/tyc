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
class ProfileViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('profile');
		$this->app = core::getApplication();
		$this->app->setTitle('User\'s Profile');
		$usr_model = $this->getModel('user');
		$user = Core::getUser();
		if(isset($_POST['form_type'])){
			$form_type=$_POST['form_type'];
			if($form_type=='user_info'){
				$model->update_user($_POST);
			}elseif($form_type=='change_password'){
				$model->change_password($_POST);
			}
		}
		$this->u = $usr_model->get_by_id();
		//$this->app->setTmpl('adminlte');
		parent::display($tpl);
	}
	
}
