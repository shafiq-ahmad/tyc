<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class PurchasesViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Purchases');
		$model = $this->getModel('purchases');
		$this->rows = $model->getBranchPurchases();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		parent::display($tpl);
	}
}
