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


class ModelAccount extends Model{

	public function add(){
		//parent::add();
	}
	public function update(){
		$this->view="accounts";	//used for redirect
		//unset($this->data['action']);
		//$this->table="ports";
		//parent::update();
		
	}
	public function remove(){
		$this->view="accounts";	//used for redirect
		$this->table="accounts";
		//parent::remove();
	}

	
	public function addTransaction(){
		$this->view="transactions";	//used for redirect
		$this->table="transactions";
		
		//parent::add();
	}

	
	public function getData($id){
		$db=Core::getDBO();
		try{
			$sql = "SELECT a.*, at.title AS type_name ";
			$sql .= "FROM accounts AS a ";
			$sql .= "LEFT JOIN account_types AS at ON (at.id = a.account_type) ";
			//$sql .= "LEFT JOIN cities AS ct ON (ct.id = pc.city_id) ";
			$sql .= "WHERE a.id = {$id} ";
			$rows = $db->get_by_sqlRows($sql);
			if(!$rows){
				$msg="Port cities not found!!!";
				throw new Exception($msg, 610);
			}
			if(Application::$options->task=='json'){
				$res = json_encode(
				array(
					'data' => $rows,
				)
				);
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			return $rows;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			//setLog($res,'error');
			echo $res;exit;
		};
	}
}

