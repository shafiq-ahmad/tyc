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


class ModelUsers extends Model{

	public function getUsers($id=null,$active=true){
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT u.*, m.img_thumb, m.file ";
		$sql .= "FROM users AS u ";
		$sql .= "LEFT JOIN media AS m ON (u.photo_id = m.id) ";
		if($active){
			$sql .= "WHERE u.published=1 ";
		}else{
			$sql .= "WHERE u.published=0 ";
		}
		if($id){
			$sql .= "AND u.id={$id} ";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getUser($id, $published=1){
		if(!$id){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT u.*, m.file,m.srcset ";
		$sql .= "FROM users AS u ";
		$sql .= "LEFT JOIN media AS m ON (u.photo_id = m.id) ";
		$sql .= "WHERE u.id={$id} ";
		if($published){
			$sql .= "AND u.published=1";
		}
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getAdminUsers($id=null,$published=null){
		$db=Core::getDBO();
		//$user=Core::getUser();
		$sql = "SELECT u.full_name AS owner_name, s.title AS sub_name, ";
		$sql .= "u.* ";
		$sql .= "FROM users AS u ";
		//$sql .= "LEFT JOIN users AS u ON (u.id = v.user_id) ";
		$sql .= "LEFT JOIN user_subscriptions AS us ON (u.id = us.user_id) ";
		$sql .= "LEFT JOIN subscriptions AS s ON (us.subscription_id = s.id) ";
		if($published==1){
			$sql .= "WHERE u.published = {$published}";
		}elseif($published===0){
			$sql .= "WHERE u.published = {$published}";
		}
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function publish(){
		$this->view="users_approval";	//used for redirect
		$this->table="users";
		try{
			if(isset($this->data['published'])){
				if($this->data['published']){
					$this->msg_post="User Approved";
				}else{
					$this->msg_post="User Blocked";
				}
			}else{
				$msg="Action not defined";
				throw new Exception($msg, 610);
			}
			parent::publish();
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

	
	public function getUserSubscriptions($id=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT IFNULL(us.id,0) AS id, us.dated,us.expiry, ";
		$sql .= "u.full_name, IFNULL(s.title,'No Subscription') AS subscription_title ";
		$sql .= "FROM users AS u ";
		$sql .= "LEFT JOIN user_subscriptions AS us ON (u.id = us.id) ";
		$sql .= "LEFT JOIN subscriptions AS s ON (s.id = us.subscription_id) ";
		//$sql .= "WHERE s.published=1 AND u.published=1 ";
		if($id){
			//$sql .= "AND s.id={$id} ";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function add(){}
	public function update(){}
	public function remove(){}

}

