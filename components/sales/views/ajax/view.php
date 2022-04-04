<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.view');
class AjaxViewSales extends View{
	public $id=0;
	public function display($tpl = null){
		$return = $this->getModel('return');
		$sale_model = $this->getModel('sale');
		$user=core::getUser();
		$this->c = $user->getCompany();
		//print_r($_POST);exit;
		if(isset($_GET['id'])){
			$this->id = $_GET['id'];
		}


		if ($_GET['part']=='newInvoiceNo'){
			//$id = $sale_model->newInvoiceNo($_POST);
			//$row = $sale_model->getInvoiceByID($id);
			//print_r($row);
			//echo json_encode($row);
		}elseif ($_GET['part']=='setInvArticle'){
			$id = $sale_model->setInvArticleFromJSON($_POST,$_POST['sale_id']);
			echo $id;exit;
		}elseif ($_GET['part']=='setQuotationArticle'){
			$id = $sale_model->setQuotationArticleFromJSON($_POST,$_POST['quotation_id']);
			echo $id;exit;
		}elseif ($_GET['part']=='setInvReturnArticle'){
			//print_r($_POST);exit;
			$id = $return->setInvReturnArticles($_POST,$_POST['return_id']);
			echo $id;exit;
		}
		exit;


		//parent::display($tpl);
	}
}
