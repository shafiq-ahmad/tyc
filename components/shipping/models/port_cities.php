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


class ModelPort_cities extends Model{

	public function getPortCity($id){
		if(!$id){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT c.id AS country_id, c.title AS country, ct.title AS city, p.title AS port_title, pc.* ";
		$sql .= "FROM port_cities AS pc ";
		$sql .= "LEFT JOIN ports AS p ON (p.id = pc.port_id) ";
		$sql .= "LEFT JOIN cities AS ct ON (ct.id = pc.city_id) ";
		$sql .= "LEFT JOIN countries AS c ON (c.id = ct.country_id) ";
		$sql .= "WHERE c.published=1 AND ct.published=1 AND p.published=1 ";

		if($id){
			$sql .= "AND pc.id={$id} ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRow($sql);
		return $rows;
	}

	public function getPortCities($port){
		if(!$port){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT c.id AS country_id, c.title AS country, ct.title AS city, p.title AS port_title, pc.* ";
		$sql .= "FROM port_cities AS pc ";
		$sql .= "LEFT JOIN ports AS p ON (p.id = pc.port_id) ";
		$sql .= "LEFT JOIN cities AS ct ON (ct.id = pc.city_id) ";
		$sql .= "LEFT JOIN countries AS c ON (c.id = ct.country_id) ";
		$sql .= "WHERE c.published=1 AND ct.published=1 AND p.published=1 ";

		if($port){
			$sql .= "AND p.id={$port} ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function add(){
		
		$m_art = $this->getModel('articles.article');
		$this->data['id'] = $m_art->getRowByTitle($this->data['title'], 6)['id'];
		setLog($this->data['id']);
		if(!$this->data['id']){
			$data= array();
			$data['is_inv_item']=0;
			$data['is_purchase_item']=0;
			$data['title']='Towing ' . $this->data['title'];
			$data['sale_price']=$this->data['charges'];
			$com_arr = array(array(
				'charges'=>$this->data['charges']
			));
			//$data['composition_data']=json_encode($com_arr);
			$data['article_type']=6;	//Towing service
			$this->data['id'] = $m_art->insertData($data);
		}
		
		unset($this->data['title']);
		
		$this->table="port_cities";
		$url = 'index.php?com=shipping';
		if(isset($_GET['port_id']) && $_GET['port_id']){
			$url .= '&view=port_cities&task=cities&port_id=' . $_GET['port_id'];
		}else{
			$url .= '&view=ports';
		}
		$this->setRedirect($url);
		parent::add();
	}
	public function update(){
		$m_art = $this->getModel('articles.article');
		//$this->data['id'] = $m_art->getRow($this->data['id'], 4)['id'];
		setLog($this->data['id']);
		//if(!$this->data['id']){
			$data= array();
			$data['id']=$this->data['id'];
			$data['title']= 'Towing ' . $this->data['title'];
			$data['sale_price']=$this->data['charges'];
			$com_arr = array(array(
				'charges'=>$this->data['charges']
			));
			//$data['composition_data']=json_encode($com_arr);
			$m_art->updateData($data);
		//}
		
		unset($this->data['title']);
		$url = 'index.php?com=shipping';
		if(isset($_GET['port_id']) && $_GET['port_id']){
			$url .= '&view=port_cities&task=cities&port_id=' . $_GET['port_id'];
		}
		if(isset($_GET['id']) && $_GET['id']){
			$url .= '&id=' . $_GET['id'];
		}
		$this->setRedirect($url);
		
		
		$this->table="port_cities";
		parent::update();
		
	}
	public function remove(){
		$this->table="port_cities";
		parent::remove();
	}

}

