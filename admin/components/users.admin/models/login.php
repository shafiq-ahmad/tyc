<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelLogin extends Model{
	
	public function login($data){
		$user=Core::getUser();
		$login_name="";
		$password="";
		$u=array();
		if(isset($data['login_name'])){$login_name=$data['login_name'];}
		if(isset($data['password'])){$password=$data['password'];}
		//$user->authenticate('shehzad','abc123');
		$u = $user->authenticate($login_name,$password);
		//return $u;
	}

}

