<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class LoginViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('login');
		if(isset($_POST) && $_POST){
			$model->login($_POST);
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
