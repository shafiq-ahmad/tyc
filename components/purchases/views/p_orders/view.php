<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class P_ordersViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$task= Application::$options->task;
		$this->app = core::getApplication();
		$this->app->setTitle('Purchase orders');
		$model = $this->getModel('p_orders');
		if($task=='json'){
			//tasks
			$limit=5;
			if(isset($_GET['limit']) && $_GET['limit']){
				$limit = $_GET['limit'];
			}
			$this->rows = $model->getBranchSales($limit);
		}else{
			$this->rows = $model->getBranchSales();
			$this->daily_sale = $model->getDailySale();
			///var_dump($this->daily_sale);
			$this->sale_date= array_column($this->daily_sale, 'date_day');
			$this->sale_total= array_column($this->daily_sale, 'sum_total');
			$this->sum_discount= array_column($this->daily_sale, 'sum_discount');
			if(isset($_GET['id'])){
				$this->id = $_GET['id'];
			}
		}
		//$this->app->setTmpl('adminlte');

		parent::display($tpl);
	}
}
