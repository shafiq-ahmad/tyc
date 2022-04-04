<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class SummeryViewHome extends View{
	public $id=0;
	//public $report_type="items";
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Overview');
		$model = $this->getModel('summery');
		$this->row = $model->getBraSaleSummery();
		$this->rowPur = $model->getBraPurchaseSummery();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
