<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class FaqsViewPages extends View{
	public $id=0;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTmpl('page');
		parent::display($tpl);
	}
}
