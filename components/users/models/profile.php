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

class ModelProfile extends Model{
	
	public function update(){
		$db = Core::getDBO();
		$id = $this->getVar('id', null,'post');
		if(!$id){
			$id = Core::getUser()->getUser()['id'];
		}
		//echo $id;exit;
		$media_id = 0;
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']){
			$path = 'users' . DS . $id;
			$media_id = Images::upload($_FILES["file"], $path);
		}
		//if(!$this->validateData($this->data)){return false;}
		$sql = "UPDATE users ";
		$sql .= "SET e_mail='{$this->data['e_mail']}', ";
		$sql .= "phone='{$this->data['phone']}', ";
		$sql .= "country='{$this->data['country']}', ";
		$sql .= "full_name='{$this->data['full_name']}', ";
		if($media_id){
			$sql .= "photo_id='{$media_id}', ";
		}
		$sql .= "address='{$this->data['address']}' ";
		//$sql .= "print_paper_size='{$this->data['print_paper_size']}' ";
		$sql .= "WHERE id='{$id}'";
		//echo $sql;exit;
		
		$ru = $db->update_by_sql($sql);
		if($ru){
			$db->setMessage(': Record updated.<br/>');
		}
		$this->setRedirect("index.php?com=users&view=profile");
		if($ru){
			$c = count($ru);
			$this->setMessage("{$c} record updated. ", "info");
		}

		return true;
	}

	public function change_password(){
		if(!$this->data){return false;}
		$db = Core::getDBO();
		$username=core::getUser()->getUser()['user_name'];
		/*
		$pass = User::hash_password($this->data['old_password']);
		$view_obj = new View();
		$model=$view_obj->getModel('users.user');
		$usr = $model->validate_user($username, $pass);
		if(!$usr){
			$message = ': Invalid Old Password.<br/>';
			$db->setMessage($message);
			return false;
		}*/
		$new = trim($this->data['new_password']);
		$confirm = trim($this->data['confirm_password']);
		if(!$new || $new != $confirm){
			$message = ': Invalid New Password.<br/>';
			$db->setMessage($message);
			return false;
		}
		$new_password = User::hash_password($new);
		$sql = "UPDATE users ";
		$sql .= "SET user_pass='{$new_password}' ";
		$sql .= "WHERE user_name='{$username}'";
		$ru = $db->update_by_sql($sql);
		if($ru){
			$message = ': Record updated.<br/>';
			$db->setMessage($message);
		}
		return true;
		
	}



}

