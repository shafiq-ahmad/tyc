<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class UserViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$user = core::getUser()->getUser();
		if(!$user['is_admin']){
			echo '<h2>Access Den</h2>';exit;
		}
		$this->app->setTitle('User Add / Edit');
		$model = $this->getModel('user');
		
		if(isset($_POST['form_type'])){
			$form_type=$_POST['form_type'];
			if($form_type=='user_info'){
				$model->update_user($_POST);
			}elseif($form_type=='change_password'){
				$model->change_password($_POST);
			}
		}
		$this->u = $model->get_by_id();
		//$this->app->setTmpl('adminlte');
		parent::display($tpl);
	}
}
