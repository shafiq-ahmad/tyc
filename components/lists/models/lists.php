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


class ModelLists extends Model{

	public function getCountries($id=null){
		$db=Core::getDBO();
		$sql = "SELECT c.* FROM countries AS c WHERE c.published=1 ";
		if($id){
			$sql .= "AND c.id={$id} ";
			//$sql .= "LIMIT 1 ";
		}
		$sql  .= "ORDER BY c.title ASC ";
		if($id){
			$res = $db->get_by_sqlRow($sql);
		}else{
			$res = $db->get_by_sqlRows($sql);
		}
		//var_dump($res);exit;
		return $res;
	}

	public function getCities($city=null, $country=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT c.title AS country, ct.* ";
		$sql .= "FROM cities AS ct ";
		$sql .= "LEFT JOIN countries AS c ON (c.id = ct.country_id) ";
		$sql .= "WHERE c.published=1 AND ct.published=1 ";
		if($country){
			$sql .= "AND c.id={$country} ";
		}
		if($city){
			$sql .= "AND ct.id={$city} ";
		}
		if($city){
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getCitiesCountry($city = null, $country=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		//$sql = "SELECT CONCAT(c.title,' - ', ct.title) AS title, ct.id ";
		$sql = "SELECT c.title AS country_title, ct.title AS title, ct.id ";
		$sql .= "FROM cities AS ct ";
		$sql .= "LEFT JOIN countries AS c ON (c.id = ct.country_id) ";
		$sql .= "WHERE c.published=1 AND ct.published=1 ";
		if($country){
			$sql .= "AND c.id={$country} ";
		}
		if($city){
			$sql .= "AND ct.id={$city} ";
		}
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getCategoriesHTML($selected=0) {	
		$rows = $this->getCategories();
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

	public function setData($data){
		$db=Core::getDBO();
		if(!$this->validateData($data)){return false;}
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "UPDATE article_cats ";
		$sql .= "SET ";
		$sql .= "title='{$data['title']}' ";
		$sql .= "WHERE id='{$data['id']}' AND branch_id={$u['branch_id']}";
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=categories&id={$data['id']}");
		}else{
			$message .= ': Record not updated.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
	}

	public function delData($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "DELETE FROM article_cats ";
		$sql .= "WHERE id='{$id}' AND branch_id={$u['branch_id']}";
		//echo $sql;exit;
		$ru = $db->update_by_sql($sql);
		$message='';
		if($ru){
			$message .= ': Record deleted.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=categories");
		}
		
	}

	function createData($data){
	}

	public function validateData(&$data){
		$id = 0;
		if(isset($data['id']) && $data['id']){
			$id = $data['id'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$id = $_GET['id'];
		}
		if(!$data['title']){
			setMessage('Invalid title.');
			return false;
		}
		return $data;
	}
	
	public function add2(){
		$data = $_POST;
		if(!$this->validateData($data)){return false;}
		$user=Core::getUser();
		$u=$user->getUser();
		$db=Core::getDBO();
		$sql = "INSERT INTO article_cats ";
		$sql .= "(title,branch_id) VALUES ( ";
		$sql .= "'{$data['title']}', ";
		$sql .= "'{$u['branch_id']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
			$db->redirect("?com=categories");
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
	}
	public function update(){
		//$this->view="countries";	//used for redirect
		//unset($this->data['action']);
		//$this->table="chan chan chachan chan;";
		parent::update();
		
	}
	public function remove(){}

}

