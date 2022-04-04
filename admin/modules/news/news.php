<?php
defined('_MEXEC') or die ('Restricted Access');


	function getMainMenu_news(){
		global $connection;
		$sql  = "SELECT * FROM menu ";
		$sql .= "WHERE parent_id = 1 AND published = 1 ORDER BY ordering ";
		$result_set = mysql_query($sql, $connection);
		if (mysql_num_rows($result_set) >= 1) {
		$package_list = array();
		while ($row = mysql_fetch_array($result_set)) {
		  $package_list[] = $row;
		}
			return $package_list;
		}else{
			return false;
		}
	}


require_once("tmpl/default.php");

?>
