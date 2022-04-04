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


class ModelCategories extends Model{

	public function getParents(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ac.* FROM article_cats AS ac ";
		$sql .= "WHERE ac.published=1 AND ac.parent_cat IS NOT NULL AND branch_id=0 OR branch_id={$u['branch_id']} ";
		$sql .= "ORDER BY ac.title ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getChilds($id=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT ac.id, ac.title, COUNT(a.article_code) AS cnt ";
		$sql .= "FROM article_cats AS ac ";
		$sql .= "LEFT JOIN articles AS a ON (ac.id = a.category) ";
		$sql .= "LEFT JOIN branch_articles AS ba ON (a.article_code = ba.article_code) ";
		$sql .= "WHERE ba.branch_id={$u['branch_id']} OR ac.branch_id={$u['branch_id']} ";
		if($id){
			$sql .= "AND ac.id={$id} ";
		}
		$sql .= "GROUP BY ac.id";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getCategories() {
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id=$u['branch_id'];
		$sql  = "SELECT ac.* FROM article_cats AS ac ";
		$sql  .= "WHERE ac.published = 1 ";
		$sql  .= "ORDER BY ordering ASC ";
		//echo $sql;exit;

		return $db->get_by_sqlRows($sql);
	}

	public function getCategoriesHTML($selected=0) {	
		$rows = $this->getCategories();
		//print_r($rows);exit;
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
	public function getCategoriesHTML_bak($selected=0) {	
		$rows = $this->getCategories();
		//print_r($rows);exit;
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

}

