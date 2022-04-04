<?php
defined('_MEXEC') or die ('Restricted Access');

if(!class_exists('Model')){
	import('core.application.component.model');
}
class ModelEmployees extends Model{

	public function getData($txt=''){
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
		$db=Core::getDBO();
		$u = Core::getUser()->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT e.id, e.title, e.dept, e.designation, e.address, e.mobile, e.phone, ";
		$sql .= "d.title AS dept_title, ed.title AS designation_title FROM employees AS e ";
		$sql .= "LEFT JOIN departments AS d ON (d.id = e.dept) ";
		$sql .= "LEFT JOIN emp_designations AS ed ON (ed.id = e.designation) ";
		$sql .= "WHERE e.branch_id = {$branch_id} ";
		if($txt){
			$sql .= " AND e.title LIKE '%{$txt}%' ";
		}
		//$sql .= "WHERE ac.parent_cat IS NOT NULL  ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}
