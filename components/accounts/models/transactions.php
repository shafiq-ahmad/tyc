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


class ModelTransactions extends Model{

	public function add(){}
	public function update(){}
	public function remove(){}

	public function getData(){
		$db=Core::getDBO();
		try{
			$sql = "SELECT t.*, a.title AS acc_name ";
			$sql .= "FROM transactions AS t ";
			$sql .= "LEFT JOIN accounts AS a ON (a.id = t.account_id) ";
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

