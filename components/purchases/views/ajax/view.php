<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class AjaxViewPurchases extends View{
	public $id=0;
	public function display($tpl = null){
		$m_art = $this->getModel('articles.article');
		$mod = $this->getModel('purchases.purchase');
		$model = $this->getModel('purchases.purchases');
		$mod_ret = $this->getModel('purchases.return');
		//$this->rows = $model->remPurItem($_POST);
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}

		if(isset($rows[0]['id']) && !$this->id){
			$this->id = $rows[0]['id'];
		}
			
if(isset($_GET['id']) && $_GET['id']){
	$this->id = $_GET['id'];
}
if(!$this->id){
if(isset($_POST['purchase_id']) && $_POST['purchase_id']){
	$this->id = $_POST['purchase_id'];
}
}
//print_r ($_POST);exit;
//echo ($this->id);exit;
if($_POST && $_GET['part']=="savePurchaseArt"){
	//echo 'helloooo...'; exit;
	$m = $model->savePurchaseArt($_POST);
	//var_dump($_POST);
	//echo $_POST['purchase_id'];
	$this->pur_arts = $mod->getPurchaseArticles($_POST['purchase_id']);
	$this->pur = $mod->getPurchaseByID($_POST['purchase_id']);
	//echo $m;exit;
	$form_model = SITE_PATH . DS . "components" . DS . "purchases" . DS . "models" . DS . "purchase.php";
	$form_file  = SITE_PATH . DS . "components" . DS . "purchases" . DS . "views" . DS . "purchase" . DS . "tmpl" . DS . "pur_art_list.php";
	require_once $form_model;
	require_once $form_file;
	//echo "posted...";
	//print_r($m);
}

if($_POST && $_GET['part']=="saveReturnArt"){
	//echo 'helloooo...'; exit;
	$m = $model->saveReturnArt($_POST);
	//var_dump($_POST);
	//echo $_POST['return_id'];
	$this->ret_arts = $mod_ret->getReturnArticles($_POST['return_id']);
	$this->ret = $mod_ret->getReturnByID($_POST['return_id']);
	//echo $m;exit;
	$form_model = SITE_PATH . DS . "components" . DS . "purchases" . DS . "models" . DS . "return.php";
	$form_file  = SITE_PATH . DS . "components" . DS . "purchases" . DS . "views" . DS . "return" . DS . "tmpl" . DS . "return_art_list.php";
	require_once $form_model;
	require_once $form_file;
	//echo "posted...";
	//print_r($m);
}

if($_POST && $_GET['part']=="remPurItem"){
	$m = $model->remPurItem($_POST);
	//var_dump($_POST);
	$this->pur_arts = $mod->getPurchaseArticles($_POST['id']);
	$this->pur = $mod->getPurchaseByID($_POST['id']);
	$form_model = SITE_PATH . DS . "components" . DS . "purchases" . DS . "models" . DS . "purchase.php";
	$form_file = SITE_PATH . DS . "components" . DS . "purchases" . DS . "views" . DS . "purchase" . DS . "tmpl" . DS . "pur_art_list.php";
	require_once $form_model;
	require_once $form_file;
	//echo "posted...";
	//print_r($m);
}

if($_POST && $_GET['part']=="remRetItem"){
	$m = $model->remRetItem($_POST);
	//var_dump($_POST);
	$this->ret_arts = $mod_ret->getReturnArticles($_POST['id']);
	$this->ret = $mod_ret->getReturnByID($_POST['id']);
	$form_model = SITE_PATH . DS . "components" . DS . "purchases" . DS . "models" . DS . "return.php";
	$form_file = SITE_PATH . DS . "components" . DS . "purchases" . DS . "views" . DS . "return" . DS . "tmpl" . DS . "return_art_list.php";
	require_once $form_model;
	require_once $form_file;
	//echo "posted...";
	//print_r($m);
}



if ($_GET['part']=='itemByID'){
	$sub = $m_art->getArticleByID($_POST['filter_text']);
	//$sub = getArticleByID($_GET['filter_text']);
	//print_r($sub);exit;
	//print_r($sub);
	//$json = array_shift($sub);
	echo json_encode($sub);
}

		

		exit;
		//print_r($this->model);exit;
		parent::display($tpl);
	}
}
