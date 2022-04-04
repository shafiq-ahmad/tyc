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

import('core.application.component.view');
class CategoryViewCategories extends View{
	public $id=0;
	public $row;
	public function display($tpl = null){
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Category');
		$task = Application::$options->task;
		$models = $this->getModel('categories');
		$model = $this->getModel('category');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		if(isset($_POST['title']) && !$this->id){
			$model->createData($_POST);
		}
		if(isset($_POST['title']) && $_POST['title']){
			$model->setData($_POST);
		}
		if(isset($_GET['delete']) && $_GET['delete'] && $this->id){
			$cat= $models->getChilds($this->id);
			$cat = array_shift($cat);
			if(isset($cat['cnt']) && $cat['cnt']==0){
				//var_dump($cat);EXIT;
				$model->delData($this->id);
			}
		}

		$this->row = $model->getDataByID($this->id);
		//$this->cats = $models->getParents();
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
