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


class ModelPur_report extends Model{


	public function getBranchPurByItems(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_POST['start_date'])){
			$start_date = $db->toDBDate($_POST['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_POST['end_date'])){
			$end_date = $db->toDBDate($_POST['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		//$start_date='2018-06-13';
		$sql = "SELECT a.article_code, pac.title AS pcat_title, ac.title AS cat_title, a.title, a.unit, AVG(bpa.sale_price) AS salePrice, ";
		$sql .= "AVG(bpa.unit_price) AS costPrice, AVG(bpa.unit_net_price) AS unitNetPrice, SUM(bpa.qty_scheme) AS qtyScheme, SUM(bpa.unit_price*bpa.qty_scheme) AS total, ";
		$sql .= "SUM(bpa.sale_price - bpa.unit_price)*AVG(bpa.qty_scheme) AS margin ";
		$sql .= "FROM branch_purchases AS bp ";
		$sql .= "LEFT JOIN suppliers AS s ON (bp.supplier_id = s.id) ";
		$sql .= "LEFT JOIN branch_purchase_articles AS bpa ON (bpa.purchase_id = bp.purchase_id) ";
		//$sql .= "LEFT JOIN branch_articles AS ba ON (bpa.article_code = ba.article_code) ";
		$sql .= "LEFT JOIN articles AS a ON (bpa.article_code = a.article_code) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (ac.id = a.category) ";
		$sql .= "LEFT JOIN article_cats AS pac ON (pac.id = ac.parent_cat) ";
		
		$sql .= "WHERE bp.branch_id = {$branch_id} AND a.article_code IS NOT NULL ";
		if($start_date && $end_date){
			$sql .= " AND bp.purchase_date >= '{$start_date}' AND bp.purchase_date <='{$end_date}' ";
		}
		$sql .= "GROUP BY a.article_code, pcat_title, cat_title, a.unit, a.title ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//print_r ($rows);exit;
		return $rows;
	}

}
