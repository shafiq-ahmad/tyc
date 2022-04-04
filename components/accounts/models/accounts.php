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


class ModelAccounts extends Model{

	public function add(){}
	public function update(){}
	public function remove(){}

	public function getData(){
		$db=Core::getDBO();
		try{
			$sql = "SELECT a.*, at.title AS type_name ";
			$sql .= "FROM accounts AS a ";
			$sql .= "LEFT JOIN account_types AS at ON (at.id = a.account_type) ";
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

	public function getVATTypes(){
		$db=Core::getDBO();
		try{
			$sql = "SELECT vt.* ";
			$sql .= "FROM vat_types AS vt ";
			//$sql .= "LEFT JOIN account_types AS at ON (at.id = a.account_type) ";
			$rows = $db->get_by_sqlRows($sql);
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

	public function getPOM(){
		$db=Core::getDBO();
		try{
			$sql = "SELECT pom.* ";
			$sql .= "FROM payment_methods AS pom WHERE pom.published=1";
			//$sql .= "LEFT JOIN account_types AS at ON (at.id = a.account_type) ";
			$rows = $db->get_by_sqlRows($sql);
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

