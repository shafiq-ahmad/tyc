<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelProfile extends Model{
	
	public function update_user($data){
		$db = Core::getDBO();
		$user_id = Core::getUser()->getUser()['user_id'];
		if(!$this->validateData($data)){return false;}
		$sql = "UPDATE users ";
		$sql .= "SET e_mail='{$data['e_mail']}', ";
		$sql .= "phone='{$data['phone']}', ";
		$sql .= "zip_code='{$data['zip_code']}', ";
		$sql .= "city='{$data['city']}', ";
		$sql .= "cnic='{$data['cnic']}', ";
		$sql .= "address='{$data['address']}', ";
		$sql .= "print_paper_size='{$data['print_paper_size']}' ";
		$sql .= "WHERE user_id='{$user_id}'";
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}
		return true;
	}

	public function change_password($data){
		if(!$data){return false;}
		$username=core::getUser()->getUser()['user_name'];
		$pass = User::hash_password($data['old_password']);
		$view_obj = new View();
		$model=$view_obj->getModel('user.user');
		$usr = $model->validate_user($username, $pass);
		$db = Core::getDBO();
		if(!$usr){
			$message = ': Invalid Old Password.<br/>';
			$db->setMessage($message);
			return false;
		}
		$new = trim($data['new_password']);
		$confirm = trim($data['confirm_password']);
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

	public function update_branch_info($data){
		$db = Core::getDBO();
		$branch_id = Core::getUser()->getUser()['branch_id'];
		if(isset($data['title']) && $data['title']){
			$title = $data['title'];
		}else{
			return false;
		}
		$address='';
		if(isset($data['address']) && $data['address']){
			$address = $data['address'];
		}
		$billing_head='';
		if(isset($data['billing_head']) && $data['billing_head']){
			$billing_head = $data['billing_head'];
		}
		$billing_address='';
		if(isset($data['billing_address']) && $data['billing_address']){
			$billing_address = $data['billing_address'];
		}
		$billing_contacts='';
		if(isset($data['billing_contacts']) && $data['billing_contacts']){
			$billing_contacts = $data['billing_contacts'];
		}
		$billing_notes='';
		if(isset($data['billing_notes']) && $data['billing_notes']){
			$billing_notes = $data['billing_notes'];
		}
		$sql = "UPDATE company_branches ";
		$sql .= "SET title='{$data['title']}', ";
		$sql .= "address='{$address}', ";
		$sql .= "billing_head='{$billing_head}', ";
		$sql .= "billing_address='{$billing_address}', ";
		$sql .= "billing_contacts='{$billing_contacts}', ";
		$sql .= "billing_notes='{$billing_notes}' ";
		$sql .= "WHERE id='{$branch_id}'";
		//echo $sql;exit;
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}
		return true;
		
	}

	private function validateData(&$data){
		$db = Core::getDBO();
		if(!isset($data['full_name'])){
			$db->setMessage('User name must be fill');
			return false;
		}
		if(!$data['e_mail']){
			$data['e_mail']="";
		}
		if(!$data['phone']){
			$data['phone']="";
		}
		if(!$data['zip_code']){
			$data['zip_code']=0;
		}
		if(!$data['city']){
			$data['city']='';
		}
		if(!$data['cnic']){
			$data['cnic']="";
		}
		if(!$data['address']){
			$data['address']='';
		}
		if(!$data['print_paper_size']){
			$data['print_paper_size']='';
		}
		return $data;
	}

}

