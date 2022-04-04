<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class Branch_articlesViewArticles extends View{
	public $id, $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('My Items');
		$model = $this->getModel('branch_articles');
		if(Application::$options->task=='json'){
			$txt='';
			if(isset($_GET['txt']) && $_GET['txt']){
				$txt=$_GET['txt'];
			}
			//var_dump($_GET);EXIT;
			if(isset($_GET['comboList'])){
				$this->rows = $model->getArticlesComboList($txt);
			}else{
				$this->rows = $model->getBranchArticles($txt);
			}
		}else{
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
			$user = Core::getUser();
			/*$c = $user->getCompany();
			$c_opt = json_decode($c['local_data_opt']);
			$c_opt = array_shift($c_opt);
			$use_local_storage='';
			
			if(isset($c_opt->use_local_storage)){
				if($c_opt->use_local_storage=="true"){
					$use_local_storage = "true";
				}
			}*/
			//print_r($c_opt);exit;
			if(isset($use_local_storage) && $use_local_storage){
				$this->rows=array();
			}else{
				$this->rows = $model->getData();
			}
		$this->rows = $model->getData();
		}
		//$this->app->setTmpl('adminlte');

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
