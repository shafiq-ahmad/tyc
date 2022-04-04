<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class User_ordersViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$task= Application::$options->task;
		$this->app = core::getApplication();
		$this->app->setTitle('User Orders');
		$model = $this->getModel('user_orders');
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
		$this->app->setTmpl('page');

		parent::display($tpl);
	}
}
