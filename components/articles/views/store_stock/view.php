<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Branch_stockViewArticles extends View{
	public $id, $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Store Stock');
		$model = $this->getModel('branch_articles');
		$model2 = $this->getModel('article');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($this->id && $_POST){
			$model2->setData($_POST);
		}elseif($_POST){
			$res = $model2->createData($_POST);
			if($res){
				redirect('?com=articles&view=articles');
			}
		}
		if($this->id){
			$this->row = $model2->getDataByID($this->id);
		}
		$this->rows = $model->getData();

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
