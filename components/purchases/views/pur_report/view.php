<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Pur_reportViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Purchases report');
		$model = $this->getModel('pur_report');
		$this->rows = $model->getBranchPurByItems();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		parent::display($tpl);
	}
}
