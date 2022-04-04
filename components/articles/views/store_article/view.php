<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Branch_articleViewArticles extends View{
	public $id,$sub;
	public function display($tpl = null){
		$model_a = $this->getModel('article');
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Item');
		$m_cat = $this->getModel('categories.categories');
		$model_ba = $this->getModel('branch_article');
		$m_lists = $this->getModel('lists.lists');
		//$model_a = $this->getModel('article');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if(!$this->id && isset($_POST['article_code'])){
			$this->id = $_POST['article_code'];
		}
		if($_POST && $this->id!==0){
			$model_ba->setData($_POST);
			$this->app->redirect('?com=articles&view=branch_article&task=edit&id=' . $this->id);
		}
		if(isset($_GET['create_record'])){
			$model_ba->createRecord();
		}
		$this->sub = $model_ba->getBranchData($this->id);


		if($this->id){
			$this->row = $model_a->getArticleByID($this->id);
			$category = 0;
			if(isset($this->row['category'])){
				$category = $this->row['category'];
			}
			$this->cats = $m_cat->getCategoriesHTML($this->row['category']);
			$this->tags = $m_lists->getTags();
			$this->seasons = $m_lists->getSeasons();
			parent::display($tpl);
		}
	}
}

