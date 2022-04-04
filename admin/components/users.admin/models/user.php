<?php
defined('_MEXEC') or die ('Restricted Access');

import('core.application.component.model');
class ModelUser extends Model{
	
	public function get_by_id($user_id=0){
		$db=Core::getDBO();
		if(!$user_id){
			$user_id=core::getUser()->getUser()['user_id'];
		}
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_id = '{$user_id}' AND is_admin = 1 ";
		$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRow($sql);
		return $usr;
	}
	
	public function get_company_by_id($branch_id=0){
		$db=Core::getDBO();
		if(!$branch_id){
			$branch_id=core::getUser()->getUser()['branch_id'];
		}
		
		$sql  = "SELECT cb.*, c.title, c.admin_id, bs.id AS store_id, cb.address FROM company_branches AS cb ";
		$sql  .= "INNER JOIN companies AS c ON (c.id = cb.company_id) ";
		$sql .= "LEFT JOIN branch_stores AS bs ON (cb.id = bs.branch_id) ";
		$sql  .= "WHERE cb.id = '{$branch_id}' LIMIT 1 ";
		//echo $sql;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}
	
	public function setUserByID($data){
		$db=Core::getDBO();
		$sql = "UPDATE users ";
		$sql .= "SET ";
		$sql_arr=array();
		if(isset($data['full_name']) && $data['full_name']){
			$sql_arr[] = "full_name='{$data['full_name']}'";
		}else{
			$db->setMessage('Invalid name.');
			return false;
		}
		if(isset($data['reset_password']) && $data['reset_password']){
			$password = User::hash_password(trim($data['reset_password']));
			$sql_arr[] .= "user_pass='{$password}'";
		}
		if(isset($data['e_mail']) && $data['e_mail']){
			$sql_arr[] .= "e_mail='{$data['e_mail']}'";
		}
		if(isset($data['phone']) && $data['phone']){
			$sql_arr[] .= "phone='{$data['phone']}'";
		}
		if(isset($data['privileges']) && $data['privileges']){
			//$privs = json_encode($data['privileges']);	//save privileges asa JSON format
			//$privs = implode("','",$data['privileges']);	//save privileges asa text format
			$privs = implode(',',$data['privileges']);	//save privileges asa text format
			$sql_arr[] = "privileges='{$privs}' ";
			//$sql_arr[] = 'privileges="\'' . $privs .'\'"';	//enclose in single quotes
		}
		if(isset($data['cnic']) && $data['cnic']){
			$sql_arr[] = "cnic='{$data['cnic']}' ";
		}
		if(isset($data['zip_code']) && $data['zip_code']){
			$sql_arr[] = "zip_code='{$data['zip_code']}'";
		}
		if(isset($data['city']) && $data['city']){
			$sql_arr[] = "city='{$data['city']}' ";
		}
		if(isset($data['address']) && $data['address']){
			$sql_arr[] = "address='{$data['address']}'";
		}
		if(isset($data['notes']) && $data['notes']){
			$sql_arr[] = "notes='{$data['notes']}'";
		}
		if(isset($data['published']) && ($data['published']==='0' || $data['published']=='1')){
			$sql_arr[] = "published='{$data['published']}'";
		}
		if(isset($data['branch_id']) && $data['branch_id']){
			$sql_arr[] = "branch_id='{$data['branch_id']}'";
		}
		$sql .= implode(',',$sql_arr);
		$sql .= " WHERE user_id='{$data['id']}'";
		//echo $sql;exit;
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not updated.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
	}

	public function validate_user($username, $password){
		$db=Core::getDBO();
		if(!$username){
			$username=core::getUser()->getUser()['user_name'];
		}
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_name = '{$username}' ";
		$sql .= "AND user_pass = '{$password}' ";
		$sql .= "AND u.published = 1 AND is_admin = 1 ";
		$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRow($sql);
		return $usr;
	}
	
}
