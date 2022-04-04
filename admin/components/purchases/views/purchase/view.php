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
class PurchaseViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('purchase');
		$this->app = core::getApplication();
		$this->app->setTitle('Add / Edit Purhase');
		$sup_model = $this->getModel('suppliers.suppliers');
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}
		$this->row = $model->getPurchaseArticles($this->id);
		$this->sup_list = $sup_model->getData();
		$this->pur = $model->getPurchaseByID($this->id);

		if($_POST){
			$link="?com=purchases&view=purchase";
			$this->form_type="";
			if(isset($_POST['form_type'])){
				$this->form_type=$_POST['form_type'];
			}
			//print_r($_POST);exit;
			if($this->id!==0 && $this->form_type == 'purchase_main'){
				$model->updatePurchase($_POST);
				$this->app->redirect($link . "&id={$this->id}");
			}
			if(!$this->id && $this->form_type == 'purchase_main'){
				$this->id = $model->createPurchase($_POST);
				$this->app->redirect($link . "&id={$this->id}");
			}
		}
		//$this->app->setTmpl('index');
		parent::display($tpl);
	}
}
