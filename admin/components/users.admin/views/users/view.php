<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class UsersViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('users');
		$this->rows = $model->getCompanyUsers();
		$this->pl = $model->publishedList();
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		parent::display($tpl);
	}
}
