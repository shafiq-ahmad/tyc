<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class EmployeesViewEmployees extends View{
	public $id, $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Employees');
		$model = $this->getModel('employees');
		if(Application::$options->task=='json'){
			$txt='';
			if(isset($_GET['txt']) && $_GET['txt']){
				$txt=$_GET['txt'];
			}
			//var_dump($_GET);EXIT;
			if(isset($_GET['comboList'])){
				$this->rows = $model->getEmployeesComboList($txt);
			}
		}else{
			$model2 = $this->getModel('employee');
			if(isset($_GET['id'])){
				$this->id = $_GET['id'];
			}
			if($this->id && $_POST){
				$model2->setData($_POST);
			}elseif($_POST){
				$res = $model2->createData($_POST);
				if($res){
					redirect('?com=employees&view=employees');
				}
			}
			if($this->id){
				$this->row = $model2->getDataByID($this->id);
			}
			$this->rows = $model->getData();
		}

		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
