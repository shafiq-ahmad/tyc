<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReturnsViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Purchase returns');
		$model = $this->getModel('returns');
		$this->rows = $model->getBranchPrReturns();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if(isset($rows[0]['id']) && !$this->id){
			$this->id = $rows[0]['id'];
		}
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
