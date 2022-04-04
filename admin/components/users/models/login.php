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

