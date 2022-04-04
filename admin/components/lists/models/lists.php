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

	public function getTags(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT t.* FROM list_tags AS t ";
		$sql .= "WHERE branch_id={$u['branch_id']} ";
		$sql .= "ORDER BY t.tag ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getMonths(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT m.* FROM list_months AS m ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getSeasons(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$sql = "SELECT s.* FROM list_seasons AS s ";
		
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

}

