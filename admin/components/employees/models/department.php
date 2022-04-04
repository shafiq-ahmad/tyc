<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelDepartment extends Model{

	public function getDataByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM departments ";
		$sql .= "WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		//`departments`(`id`, `title`)
		$db=Core::getDBO();
		$id = 0;
		if(isset($data['id']) && $data['id']){
			$id = $data['id'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$id = $_GET['id'];
		}
		if(!$id){
			setMessage('Invalid ID.');
			return false;
		}
		if(!isset($data['title']) && !$data['title']){
			setMessage('Invalid title.');
			return false;
		}
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "UPDATE departments ";
		$sql .= "SET ";
		$sql .= "title='{$data['title']}' ";
		$sql .= "WHERE id='{$data['id']}'";
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=employees&view=departments&id={$data['id']}");
		}else{
			$message .= ': Record not updated.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
	}

	function createData($data){
		//`departments`(`id`, `title`)
		if(!isset($data['title']) && !$data['title']){
			setMessage('Invalid title.');
			return false;
		}
		$db=Core::getDBO();
		$sql = "INSERT INTO departments ";
		$sql .= "(title) VALUES ( ";
		$sql .= "'{$data['title']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=employees&view=departments");
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
	}


}

