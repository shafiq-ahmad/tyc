<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class DesignationViewEmployees extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Designation');
		$task = Application::$options->task;
		$model = $this->getModel('designation');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if(isset($_POST['title']) && !$this->id){
			$model->createData($_POST);
		}
		if(isset($_POST['title']) && $_POST['title']){
			$model->setData($_POST);
		}

		$this->row = $model->getDataByID($this->id);
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
