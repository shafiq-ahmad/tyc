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


class ModelSubscription extends Model{

	public function add(){
		parent::add();
	}
	public function update(){
		$this->view="subscriptions";	//used for redirect
		//unset($this->data['action']);
		//$this->table="subscriptions";
		parent::update();
		
	}
	public function remove(){
		$this->view="subscriptions";	//used for redirect
		$this->table="subscriptions";
		parent::remove();
	}

	public function order(){
		//$db=Core::getDBO();
		//$db->start();
		/*if(!$error){
			$db->commit();
			$j = json_encode($bill);
			//echo $j;
			return $j;
		}else{
			//echo 'hi...';
			$db->rollback();
			return false;
		}*/
		$user = Core::getUser()->getUser();
		$user_id = $user['id'];
		
		$art_model=$this->getModel('articles.article');
		//echo $this->data['article_id'];exit;
		$art = $art_model->getRow($this->data['article_id']);
		//var_dump($art);exit;
		$json_arr = array();
		$_is_stock_article = false;
		$j_art=array();
		$j_art['article_id']=$this->data['article_id'];
		$j_art['title']=$art['title'];
		$j_art['qty']=$this->data['qty'];
		//$j_art['stock']=$art['qty'];
		$j_art['purchase_price']=$art['purchase_price'];
		$j_art['price']=$art['sale_price'];
		//$j_art['tp_price']=$tp_price;
		//$j_art['price_terms']=array($price_terms);
		$j_art['price_terms']=array();
	
	
	
	
		$sale_dt=date('Y-m-d H:i:s');
		$sale_date=date('Y-m-d');
		$this->data['sale_status']=2;
		$this->data['sale_date']=$sale_date;
		$this->data['time_stamp']=$sale_dt;
		$this->data['customer_id']=$user_id;
		$this->data['user_id']=$user_id;
		$this->data['sub_total']=$this->data['qty']*$j_art['price'];
		$this->data['vat_type_id']=2;
		$this->data['method_of_payment']=$this->data['payment_method'];
		$this->data['data_articles']='[' . json_encode($j_art) . ']';	
		//$this->data->id = $m_art->insertData($data);
		
		unset($this->data['article_id']);
		unset($this->data['qty']);
		unset($this->data['payment_method']);
		$this->table="sales";
		$this->setRedirect('?com=sales&view=user_orders');
		$this->msg_post=Localize::_('order_success');
		
		parent::add();
		//$this->setMessage($msg);
	}
}

