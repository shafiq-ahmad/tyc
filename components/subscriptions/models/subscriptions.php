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


class ModelSubscriptions extends Model{

	public function getSubscriptions($id=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "SELECT a.* ";
		$sql .= "FROM articles AS a ";
		$sql .= "WHERE a.published=1 AND article_type=5 ";
		if($id){
			$sql .= "AND a.id={$id} ";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function getUserSubscriptions($id=null){
		$db=Core::getDBO();
		$user=Core::getUser()->getUser();
		$sql = "SELECT u.* ";
		$sql .= "FROM users AS u ";
		$sql .= "WHERE u.published=1 ";
		//echo $sql;exit;
		if($id){
			$sql .= "AND u.id={$id} ";
			$rows = $db->get_by_sqlRow($sql);
		}else{
			$rows = $db->get_by_sqlRows($sql);
		}
		return $rows;
	}

	public function pay(){
		exit;
	}
	public function add(){}
	public function update(){}
	public function remove(){}

}

