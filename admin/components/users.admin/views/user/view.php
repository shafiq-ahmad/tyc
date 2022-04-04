<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class UserViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$models = $this->getModel('users');
		$model = $this->getModel('user');
		$this->pl = $models->publishedList();
		if(isset($_POST['privileges'])){
			$model->setUserByID($_POST);
			
			//var_dump($_POST['privileges']);
		}
		$this->branches = $models->getCompanyBranches();
		$this->privileges = $models->getPrivileges();
		//$this->user_privileges = $models->getUserPrivileges();
		//$this->groups = $models->getGroups();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$this->row = $models->getCompanyUser($this->id);
		parent::display($tpl);
	}
}
