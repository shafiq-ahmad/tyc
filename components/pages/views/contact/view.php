<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class ContactViewStatic extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication('home.view.php');
		$this->app->setTmpl('page');
		parent::display($tpl);
	}
}
