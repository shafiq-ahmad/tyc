<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class LoginViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('User\'s login');
		$model = $this->getModel('login');
		if(isset($_POST) && $_POST){
			$model->login($_POST);
		}
		$this->app->setTmpl('login');
		parent::display($tpl);
	}
}
