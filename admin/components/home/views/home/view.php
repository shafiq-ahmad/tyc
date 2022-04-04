<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class HomeViewHome extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('home');
		//$this->rows = $model->getChilds();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		$this->app = core::getApplication();
		//$this->app->setTmpl('adminlte');
		parent::display($tpl);
	}
}
