<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ProfileViewUser extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('profile');
		$usr_model = $this->getModel('user');
		$user = Core::getUser();
		if(isset($_POST['form_type'])){
			$form_type=$_POST['form_type'];
			if($form_type=='user_info'){
				$model->update_user($_POST);
			}elseif($form_type=='change_password'){
				$model->change_password($_POST);
			}elseif($form_type=='branch_info'){
				$model->update_branch_info($_POST);
			}
		}
		$this->u = $usr_model->get_by_id();
		$this->c = $usr_model->get_company_by_id();
		parent::display($tpl);
	}
	
}
