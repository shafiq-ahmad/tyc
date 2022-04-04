<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ArticleViewArticles extends View{
	public $id,$row;
	public function display($tpl = null){
		$model = $this->getModel('article');
		$models = $this->getModel('articles');
		$this->app = core::getApplication();
		//$tmpl = Application::$options->tmpl;
		$m_cat = $this->getModel('categories.categories');
		$m_lists = $this->getModel('lists.lists');
		$this->id = $this->getVar('id',null,'get');
		if(!$this->id){
			$this->id = $this->getVar('id',null,'post');
		}
		if($this->id){
			$this->row = $model->getData($this->id);
		}
		if(Application::$options->task=='json'){
			
			header("Content-Type: application/json; charset=UTF-8");
			echo json_encode (array(
				'data'=> $this->row
			));
			exit;
		}
		/*if($this->id && isset($_POST['save-article'])){
			//$model->setData($_POST);
			//$this->row = $model->getDataByID($this->id);
		}elseif(isset($_POST['save-article']) || isset($_POST['save'])){
			//print_r($_POST);exit;
			$res = $model->createData($_POST);
			$this->id =$res;
			if(isset($_POST['add_stock_record']) && $_POST['add_stock_record']){
				$model_ba = $this->getModel('articles.branch_article');
				$model_ba->createRecord($_POST);
				//core::getApplication()->redirect('?com=articles&view=branch_article&task=edit&id=' . $this->id);
				$this->app->redirect('?com=articles&view=article&task=new&tmpl=js_win');
			}
			if($res){
				$this->app->redirect('?com=articles&view=article&task=edit&id=' . $res);
			}
		}
		$category = 0;
		$ug = 0;
		if(isset($this->row['category'])){
			$category = $this->row['category'];
		}
		if(isset($this->row['unit_group'])){
			$ug = $this->row['unit_group'];
		}
		//$this->cats = $m_cat->getCategoriesHTML($category);
		$this->unit_groups = $models->getUnitGroups($ug);
		$this->seasons = $m_lists->getSeasons();
		$this->art_units = $models->getUnits();
		$this->art_prices = $models->getPriceList();
		if(isset($this->row) && $this->row){
			
		}*/
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
