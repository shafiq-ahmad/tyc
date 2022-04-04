<?php
defined('_MEXEC') or die ('Restricted Access');


	function getMainMenu(){
		global $db;
		$sql  = "SELECT * FROM menu ";
		$sql .= "WHERE parent_id = 1 AND published = 1 ORDER BY ordering ";
		return false;
		//return $db->get_by_sql($sql);
	}


$rows=getMainMenu();

require_once("tmpl/default.php");

?>
