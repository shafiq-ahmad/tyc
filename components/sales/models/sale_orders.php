<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelSale_orders extends Model{

	public function getData($limit=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		try{
			//$branch_id = $u['branch_id'];
			$user_id = $u['id'];
			$start_date='';
			$end_date='';
			if(isset($_GET['start_date'])){
				$start_date = $db->toDBDate($_GET['start_date']);
			}//else{$start_date = $db->getCurrentDate('date');}
			if(isset($_GET['end_date'])){
				$end_date = $db->toDBDate($_GET['end_date']);
			}//else{$end_date = $db->getCurrentDate('date');}
			$sql = "SELECT s.*, ss.title AS status_name, vt.title AS vat_profile, uc.full_name AS cust_name ";
			$sql .= "FROM sales AS s ";
			$sql .= "INNER JOIN sale_statuses AS ss ON (s.sale_status = ss.id) ";
			$sql .= "INNER JOIN vat_types AS vt ON (s.vat_type_id = vt.id) ";
			$sql .= "INNER JOIN users AS uc ON (s.customer_id = uc.id) ";
			$sql .= "WHERE s.sale_status = 2 ";
			//echo $sql;exit;
			if($start_date && $end_date){
				$sql .= " AND s.sale_date >= '{$start_date}' AND s.sale_date <='{$end_date}' ";
			}
			$sql .= "ORDER BY id DESC ";
			if($limit){
				$sql .= "LIMIT {$limit} ";
			}
			$rows = $db->get_by_sqlRows($sql);
			//var_dump($rows);exit;
			return $rows;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			//setLog($res,'error');
			echo $res;exit;
		}
	}

	public function remove(){
		$this->table="sales";
		$id=$this->data['id'];
		unset($this->data);
		//$this->data['sale_status']='0';
		$this->data['id']=$id;
		$this->setRedirect('?com=sales&view=sale_trash');
		$msg = Localize::_('order_removed');
		$this->msg_post=$msg;
		$this->setMessage($msg);
		
		parent::remove();
	}
	
	
}
