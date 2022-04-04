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


class ModelCart_items extends Model{

	public function getVehicles($id=null, $visibility=1){

		if(isset($_GET) && $_GET){
			$data=$_GET;
		}
		//var_dump($data);exit;
		$drives = array();
		if(isset($data['regular'])){$drives[]=$data['regular'];}
		if(isset($data['4wd'])){$drives[]=$data['4wd'];}
		if(isset($data['6wd'])){$drives[]=$data['6wd'];}
		$drive = implode(',',$drives);
		
		$conditions = array();
		if(isset($data['new'])){$conditions[]=$data['new'];}
		if(isset($data['used'])){$conditions[]=$data['used'];}
		if(isset($data['accidented'])){$conditions[]=$data['accidented'];}
		$condition = implode(',',$conditions);
		
		$transmissions = array();
		if(isset($data['automatic'])){$transmissions[]=$data['automatic'];}
		if(isset($data['manual'])){$transmissions[]=$data['manual'];}
		$transmission = implode(',',$transmissions);
		
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT u.full_name AS owner_name, y.title AS yearfull, m.title AS make_name, t.title AS tra_name, ";
		$sql .= "v.* ";
		$sql .= "FROM vehicles AS v ";
		$sql .= "LEFT JOIN users AS u ON (u.id = v.user_id) ";
		$sql .= "LEFT JOIN years AS y ON (y.id = v.year) ";
		$sql .= "LEFT JOIN makes AS m ON (m.id = v.make_id) ";
		$sql .= "LEFT JOIN vehicle_condition AS vc ON (vc.id = v.vehicle_condition) ";
		$sql .= "LEFT JOIN transmission AS t ON (t.id = v.transmission) ";
		$where = 'WHERE';
		$and = '';

		if($visibility){
			$sql .= "{$where} v.visibility=1 ";
			$and = 'AND';
			$where = '';
		}
		if(isset($data['make_id']) && $data['make_id']){
			$sql .= "{$where} v.make_id={$data['make_id']} ";
			$and = 'AND';
			$where = '';
		}
		if($condition){
			$sql .= "{$and} {$where} v.vehicle_condition IN ({$condition}) ";
			$and = 'AND';
			$where = '';
		}
		if(isset($data['year']) && $data['year']){
			$sql .= "{$and} {$where} v.year={$data['year']} ";
			$and = 'AND';
			$where = '';
		}
		if($transmission){
			$sql .= "{$and} {$where} v.transmission IN ({$transmission}) ";
			$and = 'AND';
			$where = '';
		}
		if($drive){
			$sql .= "{$and} {$where} v.drive IN ({$drive}) ";
			$and = 'AND';
			$where = '';
		}
		if(isset($data['min_price']) && $data['min_price']){
			$sql .= "{$and} {$where} v.price>={$data['min_price']} ";
			$and = 'AND';
			$where = '';
		}
		if(isset($data['max_price']) && $data['max_price']){
			$sql .= "{$and} {$where} v.price<={$data['max_price']} ";
			$and = 'AND';
			$where = '';
		}
		
		if(strpos($id,',')>=1){
			echo strpos($id,',');
			$id=explode(',',$id);
		}
		if($id){
			if(is_array($id)){
				$in = implode(',',$id);
				$sql.="{$where} {$and} v.id IN ='{$in}'";
			}else{
				$sql.="{$where} {$and} v.id={$id}";
				//echo $sql;exit;
				$rows = $db->get_by_sqlRow($sql);
				return $rows;
			}
		}
		//implement paginations
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	public function getAdminVehicles($id=null,$visibility=null){

		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT u.full_name AS owner_name, s.title AS sub_name, ";
		$sql .= "v.* ";
		$sql .= "FROM vehicles AS v ";
		$sql .= "LEFT JOIN users AS u ON (u.id = v.user_id) ";
		$sql .= "LEFT JOIN user_subscriptions AS us ON (u.id = us.user_id) ";
		$sql .= "LEFT JOIN subscriptions AS s ON (us.subscription_id = s.id) ";
		if($visibility){
			$sql .= "WHERE v.visibility = {$visibility}";
		}

		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	
	public function getUserVehicles($id=null,$visibile=true){
		$db=Core::getDBO();
		$user=Core::getUser()->getUser();
		$sql = "SELECT u.full_name AS owner_name, y.title AS yearfull, m.title AS make_name, t.title AS tra_name, ";
		$sql .= "v.* ";
		$sql .= "FROM vehicles AS v ";
		$sql .= "LEFT JOIN users AS u ON (u.id = v.user_id) ";
		$sql .= "LEFT JOIN years AS y ON (y.id = v.year) ";
		$sql .= "LEFT JOIN makes AS m ON (m.id = v.make_id) ";
		$sql .= "LEFT JOIN transmission AS t ON (t.id = v.transmission) ";
		//$sql .= "LEFT JOIN countries AS c ON (c.id = ct.country_id) ";
		$where = 'WHERE ';
		$sql .= "WHERE v.user_id = {$user['id']} ";
		$and = 'AND';
		if(!$visibile){
			$sql .= "{$and} (v.visibility=1 OR v.visibility=3) ";
			$and = 'AND';
			$where = '';
		}

		if(strpos($id,',')>=1){
			echo strpos($id,',');
			$id=explode(',',$id);
		}
		if($id){
			if(is_array($id)){
				$in = implode(',',$id);
				$sql.="{$and} v.id IN ='{$in}'";
				//$and = 'AND';
			}else{
				$sql.="{$and} v.id={$id}";
				$rows = $db->get_by_sqlRow($sql);
				return $rows;
			}
		}
		//return $sql;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	
	public function getUserVisibles(){
		$db=Core::getDBO();
		$user=Core::getUser()->getUser();
		$sql = "SELECT u.full_name AS owner_name, y.title AS yearfull, m.title AS make_name, t.title AS tra_name, ";
		$sql .= "v.* ";
		$sql .= "FROM vehicles AS v ";
		$sql .= "LEFT JOIN users AS u ON (u.id = v.user_id) ";
		$sql .= "LEFT JOIN years AS y ON (y.id = v.year) ";
		$sql .= "LEFT JOIN makes AS m ON (m.id = v.make_id) ";
		$sql .= "LEFT JOIN transmission AS t ON (t.id = v.transmission) ";
		$where = 'WHERE ';
		$sql .= "WHERE v.user_id = {$user['id']} ";
		$sql .= "AND (v.visibility=1 OR v.visibility=3) ";

		//return $sql;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	
	
	public function getMakes($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM makes ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getTransmissions($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM transmission ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getDriveTypes($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM drive ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getYears($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM years ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getConditionTypes($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM vehicle_condition ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getFuelTypes($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM fuel_type ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getEngineTypes($id=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT * ";
		$sql .= "FROM engine ";
		if($id){
			$sql .= "WHERE id= {$id}";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function broadcast(){
		header("Content-Type: application/json; charset=UTF-8");
		$db=Core::getDBO();
		$user=Core::getUser()->getUser();
		//echo 'hi..';exit;
		try {
			$model = $this->getModel('shipping.subscriptions');
			$sub = $model->getUserSubscriptions();
			if(!$sub){
				$msg = "You are not subscribed. Please purchase a subscription";
				throw new Exception($msg, 602);
				//return false;
			}
			//print_r($sub);exit;
			if(isset($sub[0]['max_broadcast']) && $sub[0]['max_broadcast']){	//make comparison if all account has limits
				$v = count($this->getUserVisibles());
				
				//print_r($sub);exit;
				//echo $v;exit;
				if($sub[0]['max_broadcast'] <= $v){
					//show message
					//setLog("V: $v, max: {$sub[0]['max_broadcast']} ",'log');
					$msg = "Broadcost exceeded max limits. your broadcast(s) v:{$v} <br>" . $sub[0]['msg_broadcast_reach_max'];
					//$this->setMessage($msg, "error");
					throw new Exception($msg, 601);
					//return 1;
				}
			}
			
			$id = 0;
			if(isset($_POST['id'])){
			$id = $_POST['id'];
			}
			//setLog("max: {$sub[0]['max_broadcast']},  ",'log');
			//$user=Core::getUser();
			$sql = "UPDATE vehicles SET ";
			if($sub[0]['cost'] ==0 ){
				$sql .= "visibility = 3 ";
			}else{
				$sql .= "visibility = 1 ";
			}
			$sql .= "WHERE id= {$id} AND user_id={$user['id']}";
			$rows = $db->update_by_sql($sql);
			if(!$rows){
				$msg="No data updated";
				throw new Exception($msg, 610);
			}
			$res = json_encode(array(
				'data' => array(
				'updated' => $rows,
				),
			));
			echo $res;exit;
			//return $res;
		} catch (Exception $e) {
			$res = json_encode(array(
				'error' => array(
				'msg' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			echo $res;exit;
		}
	}

	public function retract(){
		header("Content-Type: application/json; charset=UTF-8");
		$db=Core::getDBO();
		$id = 0;
		if(isset($_POST['id'])){
		$id = $_POST['id'];
		}
		//setLog($id,'log');
		try {
			$user=Core::getUser()->getUser();
			$sql = "UPDATE vehicles SET ";
			$sql .= "visibility = 2 ";
			$sql .= "WHERE id= {$id} AND user_id = {$user['id']}";
			$rows = $db->update_by_sql($sql);
			//var_dump($rows);exit;
			if(!$rows){
				$msg="Retract is not successful.";
				throw new Exception($msg, 610);
			}
			$res = json_encode(array(
				'data' => array(
				'updated' => $rows,
				),
			));
			echo $res;exit;
		} catch (Exception $e) {
			$res = json_encode(array(
				'error' => array(
				'msg' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			echo $res;exit;
		}
	}

	
	public function addCompare(){
		$id=$_POST['id'];
		$old_id=null;
		if(isset($_SESSION['vehicles']['compare'])){
			$old_id = $_SESSION['vehicles']['compare'];
		}
		//var_dump($old_id);
		if($old_id){
			$s = array_search($id, $old_id);
			if($s){
				return false;
			}
		}
		$_SESSION['vehicles']['compare'][] = $id;
		
	}

	public function removeCompare(){
		$id=$_POST['id'];
		$s = array_search($id, $_SESSION['vehicles']['compare']);
		//if($s || $s===0){
			unset($_SESSION['vehicles']['compare'][$s]);
			//unset($_SESSION['vehicles']['compare']);
		//}
		
	}

	public function add(){}
	public function update(){}
	public function remove(){}

}

