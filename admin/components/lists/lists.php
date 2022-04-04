<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

defined('_MEXEC') or die ('Restricted Access');


import('core.application.component.controller');
class ControllerLists extends Controller{

	function __construct(){
		$app = Core::getApplication();
		$this->user = core::getUser();
		$options = $app->getOptions();
		$com = $options->com;
		$priv=$this->user->hasPriv($com,null,true);
		if($priv){
			$this->view = $this->getView();
			//$this->view->privs=array();
			$this->view->priv=$priv;
			foreach($priv as $p){
				$str = substr($p,strlen($com)+1);
				$this->view->privs[$str] = true;
				//$this->view->priv_delete=$this->user->hasPriv('messages.delete');
			}
			//var_dump($this->view->privs);
			//$app->setTmpl('adminlte');
			parent::display();
		}else{
			Controller::$buffer = '<h3>No privilages, please contact admistrator!</h3>';
		}
	}
	
}


 
