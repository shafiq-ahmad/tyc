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


class ModelPrice_list extends Model{

	public function getRow($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$sql = "SELECT * FROM shipping_price_list WHERE id='{$id}' LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		//echo $sql;print_r($row);exit;
		return $row;
	}

	public function add(){
		$m_art = $this->getModel('articles.article');
		$this->data['id'] = $m_art->getRowByTitle($this->data['title'], 4)['id'];
		//setLog($this->data['id']);
		if(!$this->data['id']){
			$data= array();
			$data['is_inv_item']=0;
			$data['is_purchase_item']=0;
			$data['title']=$this->data['title'];
			$data['sale_price']=$this->data['shipping']+$this->data['service_charge']+$this->data['clearance'];
			$com_arr = array(array(
				'shipping'=>$this->data['shipping'],
				'service_charge'=>$this->data['service_charge'],
				'clearance'=>$this->data['clearance'],
			));
			$data['composition_data']=json_encode($com_arr);
			$data['article_type']=4;	//shipping service
			$this->data['id'] = $m_art->insertData($data);
		}
		
		unset($this->data['title']);
		$this->table="shipping_price_list";
		parent::add();
	}
	public function update(){
		$m_art = $this->getModel('articles.article');
		//$this->data['id'] = $m_art->getRow($this->data['id'], 4)['id'];
		//setLog($this->data['id']);
		//if(!$this->data['id']){
			$data= array();
			$data['id']=$this->data['id'];
			$data['title']=$this->data['title'];
			$data['sale_price']=$this->data['shipping']+$this->data['service_charge']+$this->data['clearance'];
			$com_arr = array(array(
				'shipping'=>$this->data['shipping'],
				'service_charge'=>$this->data['service_charge'],
				'clearance'=>$this->data['clearance'],
			));
			$data['composition_data']=json_encode($com_arr);
			$data['article_type']=4;	//shipping service
			$m_art->updateData($data);
		//}
		
		unset($this->data['title']);
		//unset($this->data['sale_price']);
		//unset($this->data['article_type']);
		//unset($this->data['action']);
		$this->table="shipping_price_list";
		parent::update();
		
	}
	public function remove(){
		$this->view="prices_list";	//used for redirect
		$this->table="shipping_price_list";
		parent::remove();
	}

}

