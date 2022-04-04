<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelSales extends Model{

	public function getData(){
		$db=Core::getDBO();
		$user=Core::getUser();
		//$u=$user->getUser();
		//$user_id = $u['id'];
		
		$limit=$this->getVar('limit',20,'post');
		//$start_date=$this->getVar('start_date',$db->getCurrentDate('date'),'get');
		$user_id = $this->getVar('user_id','','get');
		$customer_id = $this->getVar('customer_id','','get');
		$start_date=$this->getVar('start_date','','get');
		$end_date=$this->getVar('end_date',$db->getCurrentDate('date'),'get');
		$sql = "SELECT s.*, ss.title AS status_name ";
		$sql .= "FROM sales AS s ";
		$sql .= "LEFT JOIN sale_statuses AS ss ON (s.sale_status = ss.id) ";
		$sql .= "WHERE s.sale_status >= 3 ";
		if($user_id){
			$sql .= "AND s.user_id = {$user_id} ";
		}
		if($customer_id){
			$sql .= "AND s.customer_id = {$customer_id} ";
		}
		if($start_date && $end_date){
			$sql .= " AND s.sale_date >= '{$start_date}' AND s.sale_date <='{$end_date}' ";
		}
		$sql .= "ORDER BY id DESC ";
		if($limit){
			$sql .= "LIMIT {$limit} ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//var_dump($rows);exit;
		return $rows;
	}

	public function getCustomerSale($user_id=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		if(!$user_id){
			$u=$user->getUser();
			$user_id = $u['id'];
		}
		$limit=$this->getVar('limit',20,'post');
		$user_id = $this->getVar('user_id','','get');
		$sql = "SELECT s.*, ss.title AS status_name ";
		$sql .= "FROM sales AS s ";
		$sql .= "LEFT JOIN sale_statuses AS ss ON (s.sale_status = ss.id) ";
		$sql .= "WHERE s.sale_status >= 3 ";
		if($user_id){
			$sql .= "AND s.customer_id = {$user_id} ";
		}
		$sql .= "ORDER BY id DESC ";
		if($limit){
			$sql .= "LIMIT {$limit} ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		//var_dump($rows);exit;
		return $rows;
	}

	public function getDailySale(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$user_id = $u['id'];
		$start_date='';
		$t = time()-(3600*24*30);
		$start_date = strftime("%Y-%m-%d", $t);
		if(isset($_GET['end_date'])){
			$end_date = $db->toDBDate($_GET['end_date']);
		}else{
			$end_date = $db->getCurrentDate('date');
		}
		$sql = "SELECT (sale_date) AS date_day, SUM(sub_total) AS sum_total, SUM(credit) AS sum_credit, SUM(discount_amount) AS sum_discount ";
		$sql .= "FROM sales AS s ";
		$sql .= "WHERE s.user_id = {$user_id} ";
		//echo $sql;exit;
		if($start_date && $end_date){
			$sql .= " AND s.sale_date >= '{$start_date}' AND s.sale_date <='{$end_date}' ";
		}
		$sql.="GROUP BY s.sale_date ";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	
	public function getAllInvoice($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$user_id = $u['id'];
		$sql = "SELECT s.*, c.title AS cust_title, u.full_name ";
		$sql .= "FROM sales AS s  ";
		$sql .= "LEFT JOIN customers AS c ON (s.customer_id = c.id) ";
		$sql .= "LEFT JOIN users AS u ON (s.user_id = u.user_id) ";
		$sql .= "WHERE s.user_id = {$user_id} AND s.id = {$id} ";
		//$sql .= "AND s.sale_status=0 ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}


	public function cancel(){
		$this->table="sales";
		$id=$this->data['id'];
		unset($this->data);
		$this->data['sale_status']='0';
		$this->data['id']=$id;
		$this->setRedirect('?com=sales&view=user_orders');
		$msg = Localize::_('order_canceled');
		$this->msg_post=$msg;
		$this->setMessage($msg);
		
		parent::update();
	}
	
	
}
