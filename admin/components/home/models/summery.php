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


class ModelSummery extends Model{

	public function getBraSaleSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT bs.id) AS SaleBills, SUM(bs.sub_total) AS TotalSum, SUM(bs.discount_amount) AS DiscountSum, ";
		$sql .= "SUM(IF(bs.discount_amount>0,1,0)) AS countDiscount, SUM(IF(bs.credit>0,1,0)) AS countCredit,  ";
		$sql .= "SUM(bs.sub_total-bs.discount_amount-bs.credit) AS cashSum, SUM(bs.credit) AS creditSum ";
		$sql .= "";
		$sql .= "FROM branch_sales AS bs ";
		//$sql .= "LEFT JOIN branch_sale_articles AS bsa ON (bsa.sale_id = bs.id) ";
		//$sql .= "LEFT JOIN articles AS a ON (bsa.article_code = a.article_code) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND bs.sub_total <> 0 ";
		//$sql .= " AND bs.sale_date = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND bs.sale_date >= '{$start_date}' AND bs.sale_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}
	
	public function getBraSaleReturnSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(sr.id) AS Bills, SUM(sr.sub_total) AS TotalSum, SUM(sr.cash) AS TotalCash, SUM(sr.credit) AS TotalCredit ";
		$sql .= "";
		$sql .= "FROM branch_sales_return AS sr ";
		$sql .= "WHERE sr.branch_id = {$branch_id} ";
		//$sql .= " AND sr.return_date = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND sr.return_date >= '{$start_date}' AND sr.return_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

	public function getBraExpenseSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(ex.id) AS Bills, SUM(ex.amount) AS TotalSum ";
		$sql .= "";
		$sql .= "FROM expenses AS ex ";
		$sql .= "WHERE ex.branch_id = {$branch_id} ";
		//$sql .= " AND ex.expense_date = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND ex.expense_date >= '{$start_date}' AND ex.expense_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

	public function getBraPurchaseSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT bp.purchase_id) AS Bills, SUM(bp.amount) AS TotalSum, SUM(bp.cash) AS cashSum, SUM(bp.credit) AS creditSum, ";
		$sql .= "SUM(IF(bp.status>0,1,0)) AS BillClosed, (COUNT(DISTINCT bp.purchase_id)-SUM(IF(bp.status>0,1,0))) AS BillsOpen ";
		//$sql .= "COUNT(DISTINCT bpa.article_code) AS itemCount, SUM(bpa.article_code) itemsQty ";
		$sql .= "FROM branch_purchases AS bp ";
		//$sql .= "LEFT JOIN branch_purchase_articles AS bpa ON (bpa.purchase_id = bp.purchase_id) ";
		//$sql .= "LEFT JOIN articles AS a ON (bsa.article_code = a.article_code) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} ";
		//$sql .= " AND bp.purchase_date = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND bp.purchase_date >= '{$start_date}' AND bp.purchase_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

	public function getBraPurchaseReturnSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT bpr.id) AS Bills, SUM(bpr.amount) AS TotalSum, SUM(bpr.cash) AS cashSum, SUM(bpr.credit) AS creditSum, ";
		$sql .= "SUM(IF(bpr.status>0,1,0)) AS BillClosed, (COUNT(DISTINCT bpr.id)-SUM(IF(bpr.status>0,1,0))) AS BillsOpen ";
		$sql .= "FROM branch_purchase_returns AS bpr ";
		$sql .= "WHERE bpr.branch_id = {$branch_id} ";
		//$sql .= " AND bpr.return_date = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND bpr.return_date >= '{$start_date}' AND bpr.return_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

	public function getCashPaymentsSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT cp.date_time) AS Bills, SUM(cp.cash) AS cashSum ";
		$sql .= "FROM cash_payment_logs AS cp ";
		$sql .= "WHERE cp.branch_id = {$branch_id} ";
		//$sql .= " AND cp.date_time = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND cp.date_time >= '{$start_date}' AND cp.date_time <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

	public function getCashReceiptsSummery(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$user_id = $u['user_id'];
		$start_date='';
		$end_date='';
		if(isset($_GET['start_date'])){
			$start_date = $db->toDBDate($_GET['start_date']);
		}else{
			$start_date = $db->getCurrentDate('date');
		}
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT cr.date_time) AS Bills, SUM(cr.cash) AS cashSum ";
		$sql .= "FROM cash_receipt_logs AS cr ";
		$sql .= "WHERE cr.branch_id = {$branch_id} ";
		//$sql .= " AND cr.date_time = '{$start_date}' ";
		if($start_date && $end_date){
			$sql .= "AND cr.date_time >= '{$start_date}' AND cr.date_time <='{$end_date}' ";
		}
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}


}
