<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class FixViewArticles extends View{
	public $id, $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('My Items');
		$model = $this->getModel('branch_articles');
		$this->rows = $model->getData();
		//$this->app->setTmpl('adminlte');

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
