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


class ModelTransaction extends Model{

	public function addTrans($account_id, $amount, $details){
		//$this->table="transactions";
		//$id = parent::add();
		$db= Core::getDBO();
		$tr_date=date('Y-m-d');
		$sql = "INSERT INTO transactions (tr_date, account_id, amount) VALUES(";
		$sql .= "'{$tr_date}', '{$account_id}', '{$amount}'";
		$sql .= ")";
		$res = $db->insert_by_sql($sql);
		$id = $db->insert_id();
		$this->addDetails($id, $details);
		return $id;
	}

	public function addDetails($id, $details){
		$db= Core::getDBO();
		$tr_date=date('Y-m-d');
		foreach($details as $d){
			$sql = "INSERT INTO transaction_accounts (transaction_id, account_id, amount) VALUES(";
			$account_id = $d['account_id'];
			$amount = $d['amount'];
			$sql .= "'{$id}', '{$account_id}', '{$amount}'";
			$sql .= ")";
			$res = $db->insert_by_sql($sql);
		}
		return true;
	}

	public function update(){
		$this->table="transactions";
		//parent::update();
		
	}

	public function remove(){
		$this->table="transactions";
		//parent::remove();
	}

	public function getData($id){
		$db=Core::getDBO();
		try{
			$sql = "SELECT t.*, a.title AS acc_name ";
			$sql .= "FROM transactions AS t ";
			$sql .= "LEFT JOIN accounts AS a ON (a.id = t.account_id) ";
			$sql .= "WHERE t.id = {$id} ";
			$row = $db->get_by_sqlRow($sql);
			if(Application::$options->task=='json'){
				$res = json_encode(
				array(
					'data' => $row,
				)
				);
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			return $row;
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

