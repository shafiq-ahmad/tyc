<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelEmployee extends Model{


	public function getDataByID($id){
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
		$db=Core::getDBO();
		$user = Core::getUser();
		$u = $user->getUser();
		//print_r( $id);exit;
		$branch_id = $u['branch_id'];
		$sql = "SELECT e.id, e.title, e.dept, e.designation, e.address, e.mobile, e.phone, ";
		$sql .= "d.title AS dept_title, ed.title AS designation_title FROM employees AS e ";
		$sql .= "LEFT JOIN departments AS d ON (d.id = e.dept) ";
		$sql .= "LEFT JOIN emp_designations AS ed ON (ed.id = e.designation) ";
		$sql .= "WHERE e.branch_id = {$branch_id} ";
		$sql .= "AND e.id = '{$id}'  ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function setData($data){
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
		//print_r($data);exit;
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		
		
		if(!$this->validateData($data)){return false;}
		if(isset($data['title']) && !$data['title']){
			$db->setMessage('Please enter a Title.');
			return false;
		}
		$sql = "UPDATE employees ";
		$sql .= "SET ";
		$sql .= "title='{$data['title']}', ";
		$sql .= "dept={$data['dept']}, ";
		$sql .= "designation='{$data['designation']}', ";
		$sql .= "address='{$data['address']}', ";
		$sql .= "mobile='{$data['mobile']}', ";
		$sql .= "phone='{$data['phone']}' ";
		$sql .= "WHERE id='{$data['id']}'";
		$ea = $db->update_by_sql($sql);
		$message='';
		if($ea){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
			return false;
		}
		return true;
	}

	public function createRecord($data=null){
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
		$db = Core::getDBO();
		$user = Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$id=0;
		if(isset($_GET['id'])){
			$id = $_GET['id'];
		}
		if(!$id){return false;}
		$this->validateData($data);
		if($this->getBranchData($id)){
			$message = ': Item record already exists.<br/>';
			$db->setMessage($message);
			return false;
		}
		$sql = "INSERT INTO employees ";
		
		$sql .= "(branch_id,title,dept,designation,address,mobile,phone) VALUES ( ";
		$sql .= "'{$branch_id}', ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$data['dept']}', ";
		$sql .= "'{$data['designation']}', ";
		$sql .= "'{$data['address']}', ";
		$sql .= "'{$data['mobile']}', ";
		$sql .= "'{$data['phone']}' ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			$link = "?com=employees&view=employee&task=edit&id={$id}";
			$message .= $ri . ': Record saved. <a target="_blank" href="' . $link . '">Edit</a><br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	private function validateData(&$data){
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
		$db = Core::getDBO();
		if(isset($data['title']) && !$data['title']){
			$data['title']="";
		}
		if(isset($data['dept']) && !$data['dept']){
			$data['dept']=0;
		}
		if(isset($data['designation']) && !$data['designation']){
			$data['designation']=0;
		}
		if(isset($data['address']) && !$data['address']){
			$data['address']="";
		}
		if(isset($data['mobile']) && !$data['mobile']){
			$data['mobile']='';
		}
		if(isset($data['phone']) && !$data['phone']){
			$data['phone']="";
		}
		return $data;
	}


}
