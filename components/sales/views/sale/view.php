<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class SaleViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$this->task = Application::$options->task;
		$this->model = $this->getModel('sale');
		$this->id = $this->getVar('id',null,'get');
		$this->app = core::getApplication();
		$this->app->setTitle('Sale');
		$task=Application::$options->task;
		$this->row = $this->model->getData($this->id);
		$action = $this->getVar('action',null,'post');
		if($task=='json' && !$action){
			header("Content-Type: application/json; charset=UTF-8");
			//echo json_encode(array('data'=>$this->row));
			//exit;
		}
		//$this->inv = $this->model->getSaleArticles($this->id);
		//var_dump($this->inv);
		//print_r($this->model);exit;
		$this->app->setTmpl('adminlte');
		parent::display($tpl);
	}
}
