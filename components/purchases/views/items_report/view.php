<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Items_reportViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Purchase (Item wise report)');
		$model = $this->getModel('items_report');
		$this->rows = $model->getBranchPurchasesByItems();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		parent::display($tpl);
	}
}
