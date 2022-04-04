<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.model');
class ModelUser extends Model{
	
	public function getById($id=null){
		$db=Core::getDBO();
		if(!$id){
			return false;
		}
		$sql = "SELECT u.*, ug.group_name, ug.power_level, m.srcset, m.file, c.title AS country_name FROM users AS u ";
		$sql .= "LEFT JOIN media AS m ON (u.photo_id = m.id) ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "INNER JOIN countries AS c ON (u.country = c.id) ";
		
		$sql .= "WHERE u.id = '{$id}' ";
		$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRow($sql);
		return $usr;
	}
	
	public function validate_user($username, $password){
		$db=Core::getDBO();
		if(!$username){
			$username=core::getUser()->getUser()['user_name'];
		}
		$username = addslashes($username);
		$sql = "SELECT u.*, ug.group_name, ug.power_level, m.srcset, m.file FROM users AS u ";
		$sql .= "LEFT JOIN media AS m ON (u.photo_id = m.id) ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_name = '{$username}' ";
		$sql .= "AND user_pass = '{$password}' ";
		//$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql; exit;
		$usr = $db->get_by_sqlRow($sql);
		//var_dump($usr);exit;
		return $usr;
	}
		
	public function get_company_by_id($branch_id=0){
		$db=Core::getDBO();
		if(!$branch_id){
			$branch_id=core::getUser()->getUser()['branch_id'];
		}
		
		$sql  = "SELECT b.*, s.id AS store_id FROM branches AS b ";
		//$sql  .= "INNER JOIN companies AS c ON (c.id = b.company_id) ";
		$sql .= "LEFT JOIN stores AS s ON (b.id = s.branch_id) ";
		$sql  .= "WHERE b.id = '{$branch_id}' LIMIT 1 ";
		//echo $sql;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}
	
	
	public function validate_user_token($username, $remember_token){
		$db=Core::getDBO();
		if(!$username){
			$username=core::getUser()->getUser()['user_name'];
		}
		$username = addslashes($username);
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_name = '{$username}' ";
		$sql .= "AND remember_token = '{$remember_token}' ";
		$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql; //exit;
		$usr = $db->get_by_sqlRow($sql);
		//var_dump($usr);exit;
		return $usr;
	}
	
	public function add(){
		$db = Core::getDBO();
		//$this->view="users";	//used for redirect
		$this->table="users";
		try{
			if($this->data['user_pass'] <> $this->data['confirm_password']){
				$msg="Password deosn't match!!!";
				$this->setMessage($msg);
				throw new Exception($msg, 610);
				//return true;
			}
			unset($this->data['confirm_password']);
			$this->data['user_pass'] = User::hash_password($this->data['user_pass']);
			//unset($this->data['action']);
			$id = parent::add();
			if($id){
				$media_id = 0;
				//if(isset($_FILES['file']) && $_FILES['file']){
				if(isset($_FILES['photo']['name']) && $_FILES['photo']['name']){
					$path = 'users' . DS . $id;
					Images::$_user=$id;
					$media_id = Images::upload($_FILES["photo"], $path);
					if($media_id){
						$sql="UPDATE users SET photo_id={$media_id} WHERE id={$id} ";
						$u = $db->update_by_sql($sql);
					}
				}
				$sql = "INSERT INTO user_subscriptions(user_id, article_id, qty) VALUES ({$id}, 1, 1) ";
				$ress=$db->insert_by_sql($sql);
				//$msg = 'Your account has been created, Require admin review';
				$msg = "Your account ref#:{$id} has been created.";
				$this->setMessage($msg);
				setLog($msg, 'log');
				$this->redirect('?com=users&view=login');
			}else{
				$msg = 'Account cant be created.';
				setLog($msg, 'error');
				throw new Exception($msg, 610);
				return false;
			}
			
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			echo $res;exit;
		}
	}
	public function update(){
		$this->view="users";	//used for redirect
		//unset($this->data['action']);
		$this->table="users";
		parent::update();
		
	}
	public function remove(){
		$this->view="users";	//used for redirect
		$this->table="users";
		parent::remove();
	}

}
