<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class SalesViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$task= Application::$options->task;
		$this->app = core::getApplication();
		$this->app->setTitle('Sales');
		$model = $this->getModel('sales');
		if($task=='json'){
			$rows = $model->getData();
			header("Content-Type: application/json; charset=UTF-8");
			echo json_encode (array(
				'data'=> $rows
			));
			exit;
		}else{
			$this->rows = $model->getData();
			//$this->daily_sale = $model->getDailySale();
			//var_dump($this->daily_sale);
			//$this->sale_date= array_column($this->daily_sale, 'date_day');
			//$this->sale_total= array_column($this->daily_sale, 'sum_total');
			//$this->sum_discount= array_column($this->daily_sale, 'sum_discount');
			if(isset($_GET['id'])){
				$this->id = $_GET['id'];
			}
		}
		$this->app->setTmpl('adminlte');

		parent::display($tpl);
	}
}
