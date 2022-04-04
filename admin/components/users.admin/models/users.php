<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelUsers extends Model{
	
	public function getCompanyUsers(){
		$user=Core::getUser();
		$u=$user->getUser();
		$c=$user->getCompany();
		$db=Core::getDBO();
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "INNER JOIN company_branches AS cb ON (u.branch_id = cb.id) ";
		$sql .= "INNER JOIN companies AS c ON (cb.company_id = c.id) ";
		$sql .= "WHERE c.id = '{$c['company_id']}'  ";	//or company_id
		//$sql .= "AND u.published = 1 ";
		//$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public function getCompanyUser($id){
		$user=Core::getUser();
		$u=$user->getUser();
		$c=$user->getCompany();
		$db=Core::getDBO();
		$sql = "SELECT u.*, ug.group_name, ug.power_level FROM users AS u ";
		$sql .= "INNER JOIN user_groups AS ug ON (u.group_id = ug.group_id) ";
		$sql .= "INNER JOIN company_branches AS cb ON (u.branch_id = cb.id) ";
		$sql .= "INNER JOIN companies AS c ON (cb.company_id = c.id) ";
		$sql .= "WHERE c.id = '{$c['company_id']}' AND user_id = {$id}  ";	//or company_id
		//$sql .= "AND u.published = 1 ";
		//$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRow($sql);
		return $usr;
	}
	
	public function getCompanyBranches(){
		$user=Core::getUser();
		$u=$user->getUser();
		$c=$user->getCompany();
		$db=Core::getDBO();
		$sql = "SELECT cb.* FROM company_branches AS cb ";
		$sql .= "INNER JOIN companies AS c ON (cb.company_id = c.id) ";
		$sql .= "WHERE c.id = '{$c['company_id']}' AND cb.id = {$u['branch_id']}  ";	//or company_id
		//$sql .= "AND u.published = 1 ";
		//$sql .= "LIMIT 1";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
}
