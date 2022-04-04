<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class UserViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit User');
		$tmpl = $this->getVar('tmpl',null,'get');
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}elseif($tmpl){
			$this->app->setTmpl($tmpl);
		}else{
			$this->app->setTmpl('adminlte');
		}
		$model = $this->getModel('users');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$models = $this->getModel('lists.lists');
		$this->countries = $models->getCountries();
		$this->row = $model->getUser($this->id, false);
		parent::display($tpl);
	}
}
