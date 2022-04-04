<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelSummery extends Model{

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
		//$start_date='2018-06-13';
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT bp.purchase_id) AS Bills, SUM(bp.amount) AS TotalSum, SUM(bp.cash) AS cashSum, SUM(bp.credit) AS creditSum, ";
		$sql .= "SUM(IF(bp.status>0,1,0)) AS BillClosed, (COUNT(DISTINCT bp.purchase_id)-SUM(IF(bp.status>0,1,0))) AS BillsOpen, ";
		$sql .= "COUNT(DISTINCT bpa.article_code) AS itemCount, SUM(bpa.article_code) itemsQty ";
		$sql .= "";
		$sql .= "FROM branch_purchases AS bp ";
		$sql .= "LEFT JOIN branch_purchase_articles AS bpa ON (bpa.purchase_id = bp.purchase_id) ";
		//$sql .= "LEFT JOIN articles AS a ON (bsa.article_code = a.article_code) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} ";
		$sql .= " AND bp.purchase_date = '{$start_date}' ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		print_r ($row);//exit;
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
		//$start_date='2018-06-13';
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT bp.purchase_id) AS Bills, SUM(bp.amount) AS TotalSum, SUM(bp.cash) AS cashSum, SUM(bp.credit) AS creditSum, ";
		$sql .= "SUM(IF(bp.status>0,1,0)) AS BillClosed, (COUNT(DISTINCT bp.purchase_id)-SUM(IF(bp.status>0,1,0))) AS BillsOpen ";
		//$sql .= "COUNT(DISTINCT bpa.article_code) AS itemCount, SUM(bpa.article_code) itemsQty ";
		$sql .= "FROM branch_purchases AS bp ";
		//$sql .= "LEFT JOIN branch_purchase_articles AS bpa ON (bpa.purchase_id = bp.purchase_id) ";
		//$sql .= "LEFT JOIN articles AS a ON (bsa.article_code = a.article_code) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} ";
		$sql .= " AND bp.purchase_date = '{$start_date}' ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

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
		//$start_date='2018-06-13';
		$sql = "SELECT ";
		$sql .= "COUNT(DISTINCT bs.id) AS SaleBills, SUM(bs.sub_total) AS TotalSum, SUM(bs.discount_amount) AS DiscountSum, ";
		$sql .= "SUM(IF(bs.discount_amount>0,1,0)) AS countDiscount, SUM(IF(bs.credit>0,1,0)) AS countCredit,  ";
		$sql .= "SUM(bs.sub_total-bs.discount_amount-bs.credit) AS cashSum, SUM(bs.credit) AS creditSum ";
		$sql .= "";
		$sql .= "FROM branch_sales AS bs ";
		//$sql .= "LEFT JOIN branch_sale_articles AS bsa ON (bsa.sale_id = bs.id) ";
		//$sql .= "LEFT JOIN articles AS a ON (bsa.article_code = a.article_code) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND bs.sub_total <> 0 ";
		$sql .= " AND bs.sale_date = '{$start_date}' ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		//print_r ($row);//exit;
		return $row;
	}

}
