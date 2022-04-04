<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Sale_trashViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$task= Application::$options->task;
		$this->app = core::getApplication();
		$this->app->setTitle('Sale Trashed');
		$model = $this->getModel('sale_trash');
		if($task=='json'){
			//tasks
			$limit=5;
			if(isset($_GET['limit']) && $_GET['limit']){
				$limit = $_GET['limit'];
			}
			$this->rows = $model->getData($limit);
		}else{
			$this->rows = $model->getData();
			if(isset($_GET['id'])){
				$this->id = $_GET['id'];
			}
		}
		$this->app->setTmpl('adminlte');

		parent::display($tpl);
	}
}
