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


class ModelHome extends Model{

	public function getTowns($country=0) {
		$db=Core::getDBO();
		$sql  = "SELECT t.*,c.title AS city FROM towns AS t INNER JOIN cities AS c ON (t.city_id=c.id) ";
		$sql  .= "WHERE t.published = 1 AND c.published=1 ";
		if($country){
			$sql  .= "AND c.country_id = {$country} ";
		}
		return $db->get_by_sqlRows($sql);
	}

	function getCountryNameById($id){
		$db=Core::getDBO();
		$sql  = "SELECT name FROM countries WHERE id={$id} ";
		return $db->get_by_sql($sql);
	}
	
	function getCountryList(){
		$db=Core::getDBO();
		$sql  = "SELECT * FROM countries ";
		return $db->get_by_sql($sql);
	}

	function getCities(){
		$db=Core::getDBO();
		$sql  = "SELECT * FROM cities ";
		return $db->get_by_sql($sql);
	}


	// Get article brands
	function getArticleBrands() {
		$db=Core::getDBO();
		global $user;
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql  = "SELECT * FROM article_brands AS ab ";
		$sql  .= "WHERE ab.published=1 AND ab.town_id = {$c['town_id']} ";

		return $db->get_by_sqlRows($sql);
	}


	function sendEMail($msg,$subject,$from,$to){
		$db=Core::getDBO();

	}


	function sendSMS($msg,$subject,$from,$to){
		$db=Core::getDBO();

	}

}