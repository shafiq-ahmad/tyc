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

class ModelCategory extends Model{

	public function getDataByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM article_cats AS ac ";
		$sql .= "WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		$db=Core::getDBO();
		if(!$this->validateData($data)){return false;}
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "UPDATE article_cats ";
		$sql .= "SET ";
		$sql .= "title='{$data['title']}' ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id={$u['branch_id']}";
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=categories&id={$data['id']}");
		}else{
			$message .= ': Record not updated.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
	}

	public function delData($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "DELETE FROM article_cats ";
		$sql .= "WHERE id='{$id}' AND branch_id={$u['branch_id']}";
		//echo $sql;exit;
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record deleted.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=categories");
		}
		
	}

	function createData($data){
		if(!$this->validateData($data)){return false;}
		$user=Core::getUser();
		$u=$user->getUser();
		$db=Core::getDBO();
		$sql = "INSERT INTO article_cats ";
		$sql .= "(title,branch_id) VALUES ( ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$u['branch_id']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=categories");
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
	}

	public function getCategory($id) {
		$db=Core::getDBO();
		$sql  = "SELECT * FROM article_cats WHERE published = 1 AND id={$id} ";

		return $db->get_by_sqlRow($sql);
	}


	public function validateData(&$data){
		$id = 0;
		if(isset($data['id']) && $data['id']){
			$id = $data['id'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$id = $_GET['id'];
		}
		if(!$data['title']){
			setMessage('Invalid title.');
			return false;
		}
		return $data;
	}

}

