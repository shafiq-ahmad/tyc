<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class EmployeeViewEmployees extends View{
	public $id=0,$row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Employee');
		$this->m_des = $this->getModel('designations');
		$this->m_dept = $this->getModel('departments');
		$model = $this->getModel('employee');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if($_POST && $this->id!==0){
			$model->setData($_POST);
			$this->app->redirect('?com=employees&view=employees&task=edit&id=' . $this->id);
		}
		if(isset($_GET['create_record'])){
			$model->createRecord();
		}
		$this->row = $model->getDataByID($this->id);


		parent::display($tpl);
	}
}
