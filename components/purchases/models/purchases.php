<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelPurchases extends Model{

	public function getBranchPurchases(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
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
		$sql = "SELECT bp.*, sup.title AS supplier_title ";
		$sql .= "FROM branch_purchases AS bp ";
		$sql .= "LEFT JOIN suppliers AS sup ON (bp.supplier_id = sup.id) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} ";
		if($start_date && $end_date){
			$sql .= "AND bp.purchase_date >= '{$start_date}' AND bp.purchase_date <='{$end_date}' ";
		}
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


	public function insertPurchaseArt($data){
		//if(!$this->validatePurData($data)){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$purchase_id=0;
		if($data['purchase_id']){
			$purchase_id=$data['purchase_id'];
		}
		
		$data['cost_total']=$data['cost_price']*($data['qty_scheme']);
		$data['margin']=$data['sale_price']-$data['cost_price'];
		$data['sale_total']=$data['sale_price']*($data['qty_scheme']+$data['scheme']);
		
		$update_main_prices=0;
		if(isset($data['update_main_prices'])){
			$update_main_prices=1;
		}
		$sql = "INSERT INTO branch_purchase_articles (";
		$sql .= "purchase_id, article_code, qty_scheme, scheme,unit_price, unit_net_price, sale_price, update_main_prices, discount_per, ";
		$sql .= "discount_total, batch_no, expire_date, old_sale_price, old_unit_price, ";
		$sql .= "in_hand ";
		$sql .= ") VALUES ( ";
		$sql .= "'{$data['purchase_id']}', ";
		$sql .= "'{$data['article_code']}', ";
		$sql .= "'{$data['qty_scheme']}', ";
		$sql .= "'{$data['scheme']}', ";
		$sql .= "'{$data['cost_price']}', ";
		$sql .= "'{$data['unit_net_price']}', ";
		$sql .= "'{$data['sale_price']}', ";
		$sql .= "'{$update_main_prices}', ";
		$sql .= "'{$data['discount_per']}', ";
		$sql .= "'{$data['discount_total']}', ";
		$sql .= "'{$data['batch_no']}', ";
		$sql .= "{$data['expire_date']}, ";
		$sql .= "'{$data['old_sale_price']}', ";
		$sql .= "'{$data['old_unit_price']}', ";
		$sql .= "'{$data['qty']}' ";
		$sql .= ")";
		//echo $sql;exit;
		$ri = $db->update_by_sql($sql);
		
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
		return true;
	}

	public function updatePurchaseArt($data){
		//var_dump($data);exit;
		if(!$this->validatePurData($data)){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$purchase_id=0;
		if($data['purchase_id']){
			$purchase_id=$data['purchase_id'];
		}
		
		$data['cost_total']=$data['cost_price']*($data['qty_scheme']);
		$data['margin']=$data['sale_price']-$data['cost_price'];
		$data['sale_total']=$data['sale_price']*($data['qty_scheme']+$data['scheme']);
		
		$update_main_prices=0;
		if(isset($data['update_main_prices'])){
			$update_main_prices=1;
		}
		$sql = "UPDATE branch_purchase_articles SET ";
		$sql .= "qty_scheme = qty_scheme + {$data['qty_scheme']}, ";
		$sql .= "scheme = scheme + {$data['scheme']}, ";
		$sql .= "batch_no = {$data['batch_no']}, ";
		$sql .= "expire_date = {$data['expire_date']}, ";
		$sql .= "old_sale_price = '{$data['old_sale_price']}', ";
		$sql .= "old_unit_price = '{$data['old_unit_price']}', ";
		$sql .= "in_hand = '{$data['qty']}' ";
		$sql .= "WHERE purchase_id='{$data['purchase_id']}' AND article_code='{$data['article_code']}' ";
		//echo $sql;exit;
		$ri = $db->update_by_sql($sql);
		
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		
		return true;
	}

	public function savePurchaseArt($data){
		//var_dump($data);exit;
		//echo $data['expire_date'];exit;
		//print_r($data);exit;
		if(!$this->validatePurData($data)){return false;}
		$db=Core::getDBO();
		$purchase_id=0;
		if($data['purchase_id']){
			$purchase_id=$data['purchase_id'];
		}
		
		$sql = "SELECT * FROM branch_purchase_articles AS bpa WHERE ";
		$sql .= "purchase_id = '{$data['purchase_id']}' AND ";
		$sql .= "article_code = '{$data['article_code']}' ";
		//echo $sql;exit;
		$ri = $db->get_by_sqlRows($sql);
		
		$res=false;
		if($ri){
			$res = $this->updatePurchaseArt($data);
		}else{
			$res = $this->insertPurchaseArt($data);
		}
		return $res;
	}


	public function saveReturnArt($data){
		if(!$this->validatePurData($data)){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		//Array ( [form_type] => return_items [return_id] => 2 [article_code] => 01005 [qty] => 0 [title] => BAKERI SWEET RUSK L [cost_price] => 90 [sale_price] => 100 
		//[qty_scheme] => 4 [scheme] => 0 [batch_no] => NULL [expire_date] => NULL [cost_total] => 360 [margin] => 10 [sale_total] => 400 [unit_net_price] => 100 
		//[discount_per] => 0 [discount_total] => 0 [old_sale_price] => 0 [old_unit_price] => 0 )
		$c = $user->getCompany();
		$branch_id = $c['id'];
		if(!$data['return_id']){
			$db->setMessage('Invalid return ID.');
			return false;
		}
		$sql = "INSERT INTO branch_purchase_return_articles (";
		$sql .= "return_id, article_code, qty_scheme, scheme,unit_price, unit_net_price, sale_price, discount_per, ";
		$sql .= "discount_total, batch_no, expire_date, old_sale_price, old_unit_price, ";
		$sql .= "in_hand ";
		$sql .= ") VALUES ( ";
		$return_id=0;
		if(isset($data['return_id'])){
			$return_id = $data['return_id'];
		}
		$sql .= "'{$return_id}', ";
		$sql .= "'{$data['article_code']}', ";
		$sql .= "'{$data['qty_scheme']}', ";
		$sql .= "'{$data['scheme']}', ";
		$sql .= "'{$data['cost_price']}', ";
		$sql .= "'{$data['unit_net_price']}', ";
		$sql .= "'{$data['sale_price']}', ";
		$sql .= "'{$data['discount_per']}', ";
		$sql .= "'{$data['discount_total']}', ";
		$sql .= "{$data['batch_no']}, ";
		$sql .= "{$data['expire_date']}, ";
		$sql .= "'{$data['old_sale_price']}', ";
		$sql .= "'{$data['old_unit_price']}', ";
		$sql .= "'{$data['qty']}' ";
		$sql .= ")";
		$ri = $db->update_by_sql($sql);
		
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		return true;
	}

	public function remPurItem($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "DELETE FROM branch_purchase_articles WHERE ";
		$sql .= "purchase_id = {$data['id']} AND article_code='{$data['itm']}' ";
		//echo $sql . '<br/>';
		$ri = $db->delete_by_sql($sql);
		$message='';
		if($ri){}else{return false;}
		return true;
	}
	public function remRetItem($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		$c = $user->getCompany();
		$mod=$this->getModel('articles.article');
		$branch_id = $c['id'];
		$sql = "DELETE FROM branch_purchase_return_articles WHERE ";
		$sql .= "return_id = {$data['id']} AND article_code='{$data['itm']}' ";
		$ri = $db->delete_by_sql($sql);
		
		$mod=$this->getModel('articles.article');
		$art = $mod->getArticleByID($data['itm']);
		if(!$art){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		$message='';
		if(!$ri){return false;}
		return true;
	}


	public function validatePurData(&$data){
		$db=Core::getDBO();
		$article_code = 0;
		$mod=$this->getModel('articles.article');
		if(isset($data['article_code']) && $data['article_code']){
			$data['article_code'] = $data['article_code'];
		}elseif(isset($_GET['id']) && $_GET['id']){
			$data['article_code'] = $_GET['id'];
		}
		if(!$data['article_code']){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		$art = $mod->getArticleByID($data['article_code']);
		if(!$art){
			$db->setMessage('Invalid Item code.');
			return false;
		}
		$data['qty']=$art['qty'];
		
		if($data['qty_scheme']<=0){
			$db->setMessage('Invalid Qty + scheme.');
			return false;
		}
		if($data['cost_price']<=0){
			$db->setMessage('Invalid Cost price.');
			return false;
		}
		if($data['sale_price']<=0){
			$db->setMessage('Invalid Sale price.');
			return false;
		}
		if(!$data['scheme']){
			$data['scheme']=0;
		}
		$data['cost_total']=$data['cost_price']*($data['qty_scheme']);
		$data['margin']=$data['sale_price']-$data['cost_price'];
		$data['sale_total']=$data['sale_price']*($data['qty_scheme']+$data['scheme']);
		if(!$data['batch_no']){
			$data['batch_no']="NULL";
		}
		//echo $data['expire_date'];
		if($data['expire_date']){
			$data['expire_date']="'{$db->toDBDate($data['expire_date'])}'";
		}else{
			$data['expire_date']="NULL";
		}
		
		
		//vars for later versions
		$data['unit_net_price']=$data['sale_price'];
		$data['discount_per']=0;
		$data['discount_total']=0;
		$data['old_sale_price']=0;
		$data['old_unit_price']=0;
		
		
		return $data;
	}

}
