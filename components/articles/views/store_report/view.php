<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Branch_reportViewArticles extends View{
	public $id;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Item');
		$model = $this->getModel('branch_report');
		$m_cat = $this->getModel('categories.categories');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($this->id){
			$this->row = $model->getDataByID($this->id);
		}
		if($this->id && $_POST){
			$model->setData($_POST);
			$this->row = $model->getDataByID($this->id);
		}elseif($_POST){
			$res = $model->createData($_POST);
			if($res){
				redirect('?com=articles&view=articles');
			}
		}
		$this->cats = $m_cat->getCategoriesHTML($this->row['category']);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
