<?php
defined('_MEXEC') or die ('Restricted Access');

class User{

	protected static $db_fields = array('id', 'user_name', 'name', 'user_pass');
	public $user;
	private $company, $packages;
	private static $_privs=array();
	public static $instance;
	public function authenticate($username="", $pass="",$silent=null ) {
		$db=core::getDBO();
		$app=core::getApplication();
		$pass = addslashes($pass);
		$password=self::hash_password($pass);
		if(!class_exists('View')){
			import('core.application.component.view');
		}
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$usr = $u_model->validate_user($username, $password);
		if($usr){
			if(!$usr['published']){
				$msg=Localize::_('user_inactive_msg');
				$app->setMessage($msg);
				$url_usr = "?com=users&view=login";
				$app->redirect($url_usr);
			}
			$this->user = $usr;
			$_SESSION[_CLIENT]['user'] = $usr; //un comment this code for production
		}else{
			$msg = "Invalid Login Name or Password";
			$app->setMessage($msg);
			$url_usr = "?com=users&view=login";
			$app->redirect($url_usr);
		}
		
		$days = time() + (60*60*24*6);
		if(isset($_POST['remember_me'])){
			setcookie('remember_me', 1, $days,'/');
			$token = $this->setRememberToken($username);
			setcookie('remember_token', $token, $days,'/');
			setcookie('username', $username, $days,'/');
			/*
			setcookie('password', $pass, $days,'/');*/
		}elseif(!isset($_POST['remember_me'])){
			/*if(isset($_COOKIE["username"])){
				//setcookie ("username","");
			}
			if(isset($_COOKIE["password"])){
				//setcookie ("password","");
			}*/
		}

		if(!$silent){
			$app->redirect(LOGIN_SUCCESS_URI);
		}
		return !empty($this->user) ? $this->user : false;
	}

	public static function hash_password($pass='') {
		if (!$pass){
			return false;
		}
		//$hash = hash('sha256',$pass); // sha1,sha256,sha384,sha512
		//$hash = password_hash('abc123',PASSWORD_DEFAULT);
		$hash = md5($pass);
		return $hash;
	}

	public function setRememberToken($username){
		
		//$new_token=self::hash_password('ss');
		$new_token=self::hash_password(rand(1000,9999999));
		$db=Core::getDBO();
		$username = addslashes($username);
		$sql = "UPDATE users AS u ";
		$sql .= "SET remember_token = '{$new_token}' ";
		$sql .= "WHERE user_name = '{$username}' ";
		//$sql .= "AND user_pass = '{$password}' ";
		$sql .= "AND u.published = 1 ";
		//echo $sql; //exit;
		$usr = $db->get_by_sqlRow($sql);
		//var_dump($usr);exit;
		return $new_token;
	}
	
	public static function getInstance() {
		if (!self::$instance){
			self::$instance = new User();
		}
		return self::$instance;
	}

	private function getCompanyBranch($user){
		$db = core::getDBO();
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$row = $u_model->get_company_by_id();
		if ($row) {
			$this->company = $row;
			$_SESSION[_CLIENT]['company'] = $row; // un comment this code for developement version
			return true;
		}else{
			return false;
		}
	}

	public function getPrivs($user=null){
		if(!$user){
			$user = $this->getUser();
		}
		$user_id = $user['id'];
		if(isset(self::$_privs[$user_id])){
			return self::$_privs[$user_id];
		}
		
		
		$db = core::getDBO();
		if(!class_exists('View')){
			import('core.application.component.view');
		}
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$row = $u_model->getUserPrivileges($user);
		if ($row) {
			self::$_privs[$user_id] = $row;
			return self::$_privs[$user_id];
		}else{
			return false;
		}
	}

	public function hasPriv($priv, $privs=null,$regex=false){
		if(!$privs){
			$privs = $this->getPrivs();
		}
		$arr_col = array_column($privs,'privilege_alias');
		if(!$regex){
			$aus = array_search($priv, $arr_col);
			if($aus || $aus===0){
				return ($privs[$aus]);
			}
		}else{
			$matches  = preg_grep("/^{$priv}/i", $arr_col);
			return $matches;
			
		}
		return false;
	}

	public function pageAccess($req_power){
		$user = $this->getUser();
		$acl = $user['acl'];
		
		$calc_power = $acl & $req_power;
		if($req_power === $calc_power){
			return true;
		}else{
			return false;
		}
	}

	public function renewUser($id){
		$view_obj = new View();
		$u_model=$view_obj->getModel('users.user');
		$_SESSION[_CLIENT]['user'] = $u_model->getById($id);
		return true;
	}
	
	public function getUser($renew=null){
		$app=core::getApplication();
		//if($this->user){
		//	return $this->user;
		//}else
		if(isset($_SESSION[_CLIENT]['user']) && $_SESSION[_CLIENT]['user']){
			if($renew){
				$this->renewUser($_SESSION[_CLIENT]['user']['id']);
			}
			return $_SESSION[_CLIENT]['user'];
		//}elseif(isset($_COOKIE["username"]) && isset($_COOKIE["password"])){
		}elseif(isset($_COOKIE["username"]) && isset($_COOKIE["remember_token"])){
			//$res = $this->authenticate($_COOKIE["username"],$_COOKIE["password"],true);
			$view_obj = new View();
			$u_model=$view_obj->getModel('users.user');
			$res = $u_model->validate_user_token($_COOKIE["username"],$_COOKIE["remember_token"]);
			if($res){
				$_SESSION[_CLIENT]['user'] = $res;
				return $res;
			}else{
				$url_usr = "?com=users&view=login";
				$app->redirect($url_usr);
			}
			return false;
		}else{
			if(isset($_GET['com']) && $_GET['com']!='users' && isset($_GET['view']) && $_GET['view']!='login'){
				$url_usr = "?com=users&view=login";
				$app->redirect($url_usr);
			}
			return false;
		}
	}

	public static function isLogin(){
		$app=core::getApplication();
		//if($this->user){
		//	return $this->user;
		//}else
		if(isset($_SESSION[_CLIENT]['user']) && $_SESSION[_CLIENT]['user']){
			return $_SESSION[_CLIENT]['user'];
		}elseif(isset($_COOKIE["username"]) && isset($_COOKIE["remember_token"])){
			if(!class_exists('View')){import('core.application.component.view');}
			$view_obj = new View();
			$u_model=$view_obj->getModel('users.user');
			$res = $_SESSION[_CLIENT]['user'] = $u_model->validate_user_token($_COOKIE["username"],$_COOKIE["remember_token"]);
			if($res){
				return $res;
			}
		}
		return false;
	}

	public function getUserIdByLoginName($user_name){
		$db=Core::getDBO();
		$sql  = "SELECT id FROM users WHERE user_name = '{$user_name}' LIMIT 1 ";
		$row = $db->get_by_sql($sql);
		//print_r($row);
		if ($row) {
			return $row;
		}else{
			return false;
		}
	}

	public function findLoginName($user_name){
		$db=Core::getDBO();
		$sql  = "SELECT * FROM users WHERE user_name = '{$user_name}' LIMIT 1 ";
		return $db->get_by_sql($sql);
	}
		
	public function findEmail($email){
		$db=Core::getDBO();
		$sql  = "SELECT * FROM users WHERE e_mail = '{$email}' LIMIT 1 ";
		return $db->get_by_sql($sql);
	}
	
	public function validateUser($user_name, $email){
		$msg='';
		if($this->findLoginName($user_name)){$msg .= 'Login name already exist, please try another one. <br />';}
		if($this->findEmail($email)){$msg .= 'E-mail ID already exist, please try another one. <br />';}
		return $msg;
	}

	
}

