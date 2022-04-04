<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ReturnViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Purchase return');
		$model = $this->getModel('return');
		$sup_model = $this->getModel('suppliers.suppliers');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$this->row = $model->getReturnArticles($this->id);
		$this->sup_list = $sup_model->getData();
		//$this->mops = $sup_model->getMOPS();
		//$this->bstores = $sup_model->getBranchStores();
		$this->ret = $model->getReturnByID($this->id);
		
		//var_dump($this->ret);exit;
		if($_POST){
			$link="?com=purchases&view=return";
			$this->form_type="";
			if(isset($_POST['form_type'])){
				$this->form_type=$_POST['form_type'];
			}
			//print_r($_POST);exit;
			if($this->id!==0 && $this->form_type == 'return_main'){
				$model->updateReturn($_POST);
				$this->app->redirect($link . "&id={$this->id}");
			}
			if(!$this->id && $this->form_type == 'return_main'){
				$this->id = $model->createReturn($_POST);
				$this->app->redirect($link . "&id={$this->id}");
			}
		}
		parent::display($tpl);
	}
}
