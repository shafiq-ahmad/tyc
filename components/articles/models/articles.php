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

class ModelArticles extends Model{
	
	public function getData(){
		$db=Core::getDBO();
		$user=Core::getUser()->getUser();
		$txt = trim($this->getVar('txt',null,'get'));
		
		try{
			$sql = "SELECT a.* FROM articles AS a ";
			$sql .= "WHERE a.published=1 ";
			if($txt){
				$sql.="AND a.title LIKE '%{$txt}%'";
			}
		
			$rows = $db->get_by_sqlRows($sql);
			//var_dump($row);exit;
			if(Application::$options->task=='json'){
				$res = json_encode(
				array(
					'data' => $rows,
				)
				);
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			return $rows;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			//setLog($res,'error');
			echo $res;exit;
		}
	}

	public function getUnitGroups($selected=0) {
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id=$u['branch_id'];
		$sql  = "SELECT ug.* FROM unit_groups AS ug ";
		$sql  .= "WHERE ug.published = 1 ";
		//$sql  .= "ORDER BY ordering ASC ";
		//echo $sql;exit;

		$rows = $db->get_by_sqlRows($sql);
		if(!$rows){return false;}
		//$html = '<SELECT name="' . $name . '" id="' . $name . '" class="' . $name . '">';
		$options = array();
		foreach ($rows as $row){
			//print_r($row);echo '<br/><br/>';
			$sel = "";
			if($row['id'] == $selected){$sel='selected="selected"';}
			
			$opt = '<OPTION value="' . $row['id'] . '" ' . $sel . '>' . $row['title'] . '</OPTION>';
			//$options[$row['parent_cat']]['name'] = $row['parent_title'];
			$options[] = $opt;
		}
		//$html .= '</SELECT>';
		return $options;
	}

	public function getUnits($group_id=null) {
		$db=Core::getDBO();
		$sql  = "SELECT u.*, ug.is_mass, ug.is_distance FROM units AS u ";
		$sql .= "INNER JOIN unit_groups AS ug ON (u.unit_group= ug.id) ";
		$sql  .= "WHERE u.published = 1 ";
		if($group_id){
			$sql  .= "unit_group = {$group_id} ";
		}
		$sql  .= "ORDER BY unit_value ASC ";
		//echo $sql;exit;

		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getPriceList($article_id=null, $unit_id=null, $unit_group=null) {
		$db=Core::getDBO();
		$sql  = "SELECT pl.*, u.title AS unit_title, u.unit_value AS factor FROM article_price_list AS pl ";
		$sql .= "INNER JOIN units AS u ON (pl.unit_id= u.id) ";
		$sql  .= "WHERE u.published = 1 ";
		if($article_id){
			$sql  .= "AND pl.article_id = {$article_id} ";
		}
		if($unit_id){
			$sql  .= "AND pl.unit_id = {$unit_id} ";
		}
		if($unit_group){
			$sql  .= "AND u.unit_group = {$unit_group} ";
		}
		$sql  .= "ORDER BY u.unit_value ASC ";
		//echo $sql;exit;

		$rows = $db->get_by_sqlRows($sql);
		//print_r($rows);exit;
		return $rows;
	}

	public function searchTitle($txt=null) {
		/*
		$sql = mysql_query("SELECT * FROM artiles WHERE MATCH ( Name, id_number ) AGAINST ('"exact phrase"' IN BOOLEAN MODE);");
		$sql = "SELECT * FROM articles WHERE MATCH ( Name, id_number ) AGAINST ('+first_word +second_word +third_word' IN BOOLEAN MODE);");
		*/
		$db=Core::getDBO();
		$sql  = "SELECT pl.*, u.title AS unit_title, u.unit_value AS factor FROM article_price_list AS pl ";
		$sql .= "INNER JOIN units AS u ON (pl.unit_id= u.id) ";
		$sql  .= "WHERE u.published = 1 ";
		if($article_id){
			$sql  .= "AND pl.article_id = {$article_id} ";
		}
		if($unit_id){
			$sql  .= "AND pl.unit_id = {$unit_id} ";
		}
		if($unit_group){
			$sql  .= "AND u.unit_group = {$unit_group} ";
		}
		$sql  .= "ORDER BY u.unit_value ASC ";
		//echo $sql;exit;

		$rows = $db->get_by_sqlRows($sql);
		//print_r($rows);exit;
		return $rows;
	}

	public function search(){
		$txt = $this->getVar('txt', '', 'post');
		try{
			if(!$txt){
				$msg="Empty search!";
				throw new Exception($msg, 610);
			}
			$db=Core::getDBO();
			$u = Core::getUser()->getUser();
			$sql = "SELECT a.id, a.title AS label FROM articles AS a ";
			$sql .= "WHERE a.published=1 ";
			/*$arr = explode(' ',$txt);
			$str_search='';
			foreach($arr as $a){
				$str_search = ' +' . $a . $str_search;
			}
			$sql .= " AND MATCH (title,body) AGAINST ('" . $str_search . "' IN BOOLEAN MODE) ";*/
			$sql .= " AND a.title LIKE '%{$txt}%' ";
			//echo $sql;exit;
			setLog($sql, "Log");
			$rows = $db->get_by_sqlRows($sql);
			if(!$rows){
				$msg="No Record Found.";
				throw new Exception($msg, 610);
			}
			echo json_encode($rows);exit;
			//return $rows;
		
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			//setLog($res,'error');
			echo $res;exit;
		}
	}


}