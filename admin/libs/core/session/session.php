<?php
defined('_MEXEC') or die ('Restricted Access');

class Session extends User {

	protected static $db_fields = array('id', 'user_name', 'name', 'user_pass');
	private $user;
	private $company;
	private $packages;
	
	public function authenticate($username="", $pass="") {
		global $db;
		//$username = $db->escape_value($username);
		//$password = $db->escape_value($pass);
		$username = $username;
		$password = $pass;
		$password=md5($pass);
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "WHERE user_name = '{$username}' ";
		$sql .= "AND user_pass = '{$password}' ";
		$sql .= "AND u.published = 1 ";
		$sql .= "LIMIT 1";
		$usr = $db->get_by_sqlRow($sql);
		//use count($user)=1 function to find if variable row=1
		if($usr){
			$this->user = $usr;
			$_SESSION[self::$client]['user'] = $usr; //un comment this code for production
		}else{
			$msg = "Invalid Login Name or Password";
			setMessage($msg);
			$url_usr = "?com=user&view=login";
			redirect($url_usr);
		}
		
		$company = $this->getCompanyBranch($this->user);
		//return !empty($this->user) ? array_shift($this->user) : false;
		$url_usr = "?com=home";
		redirect($url_usr);
		//return !empty($this->user) ? $this->user : false;
	}


	private function getCompanyBranch($user){
		global $db;
		$sql  = "SELECT cb.*, c.title AS company_title, bs.id AS store_id, cb.address FROM company_branches AS cb ";
		$sql  .= "INNER JOIN companies AS c ON (c.id = cb.company_id) ";
		$sql .= "LEFT JOIN branch_stores AS bs ON (cb.id = bs.branch_id) ";
		$sql  .= "WHERE cb.id = '{$user['branch_id']}' LIMIT 1 ";
		//echo $sql;
		$row = $db->get_by_sqlRow($sql);
		//print_r($row);exit;
		if ($row) {
			$this->company = $row;
			$_SESSION[self::$client]['company'] = $row; // un comment this code for developement version
			return true;
		}else{
			return false;
		}
	}

	
}


$session = new Session();

