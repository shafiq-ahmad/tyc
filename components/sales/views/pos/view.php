<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class PosViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('POS');
		$this->user = core::getUser();
		//$this->priv_sale=$this->user->hasPriv('sales.sale');
		//$this->priv_credit=$this->user->hasPriv('sales.credit');
		//$this->priv_discount=$this->user->hasPriv('sales.discount');
		//var_dump($priv_sale);
			$model = $this->getModel('sale');
			//$cust_model = $this->getModel('customers.customers');
			//$this->customers = $cust_model->getData();
			$this->u = $this->user->getUser();
			//$this->rows = $model->getChilds();
			if(isset($_GET['id'])){
				$this->id = $_GET['id'];
				$this->inv = $model->getAllInvoice($this->id);
			}
			$this->app->setTmpl('bill');
			parent::display($tpl);
	}
}
