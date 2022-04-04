<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelDesignations extends Model{

	public function getData(){
		//`emp_designations`(`id`, `title`)
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ed.* FROM emp_designations AS ed ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getCombo($selected=0) {	
		$rows = $this->getData();
		//print_r($rows);exit;
		if(!$rows){return false;}
		$options = array();
		foreach ($rows as $row){
			$sel = "";
			if($row['id'] == $selected){$sel='selected="selected"';}
			
			$opt = '<OPTION value="' . $row['id'] . '" ' . $sel . '>' . $row['title'] . '</OPTION>';
			$options[] = $opt;
		}
		//$html .= '</SELECT>';
		return $options;
	}	

}

