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


class ModelContact extends Model{

	public function add(){
		import('core.mail.email');
		$mail = new Email();
		$message='<div><h2>' . $this->data['subject'] . '</h2><ul>';
		$message.='<li>Name: ' . $this->data['full_name'] . '</li>';
		$message.='<li>Email: ' . $this->data['e_mail'] . '</li>';
		$message.='<li>Phone: ' . $this->data['phone'] . '</li></ul>';
		$message.='<p>' . $this->data['message'] . '</p></div>';
		
		$to=array([MAIL_ADMIN,'Admin']);
		$mail->sendMail($this->data['subject'], $message, $to);
		//$user = Core::getUser()->getUser();
		$this->view="contactus";	//used for redirect
		//unset($this->data['action']);
		$this->msg_pre = 'Inquiry reference number: ';
		$this->msg_post = '';
		
		$this->table="contacted_us";
		$user = Core::getUser()->isLogin();
		$user_id=0;
		if($user){
			$user_id=$user['id'];
		}
		$this->data['user_id'] = $user_id;
		//parent::add();
	}
	public function update(){
		$user = Core::getUser()->getUser();
		$this->view="contactus";	//used for redirect
		//unset($this->data['action']);
		$this->table="contacted_us";
		
		
		$up = parent::update();
	}
	
	public function remove(){
		$this->view="contactus";	//used for redirect
		$this->table="contacted_us";
		$user = Core::getUser()->getUser();
		$db=Core::getDBO();
		$id=0;
		if(isset($_POST) && $_POST){
			$id=$_POST;
		}else{
			return false;
		}

		$sql = "DELETE FROM contacted_us ";
		$sql .= "WHERE parent_id= {$id}";
		$rows = $db->delete_by_sql($sql);
		$sql = "DELETE FROM contacted_us ";
		$sql .= "WHERE id= {$id}";
		$rows = $db->delete_by_sql($sql);
		return $rows;
		//parent::remove();
	}

}

