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


class ModelReturns extends Model{

	public function getBranchPrReturns(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT pr.*, sup.title AS supplier_title ";
		$sql .= "FROM branch_purchase_returns AS pr ";
		$sql .= "LEFT JOIN suppliers AS sup ON (pr.supplier_id = sup.id) ";
		$sql .= "WHERE pr.status=1 AND pr.branch_id = {$branch_id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

}
