<?php
defined('_MEXEC') or die ('Restricted Access');


class ModelReturn extends Model{

	public function updateReturn($data){
		if(!$data['cash']){
			$data['cash']=0;
		}
		if(!$data['credit']){
			$data['credit']=0;
		}
		$db=Core::getDBO();
		$db->start();
		$error=false;
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$return_id=$data['return_id'];
		$sql = "UPDATE branch_purchase_returns ";
		$sql .= "SET comments='{$data['comments']}', ";
		
		
		if(isset($data['return_date']) && $data['return_date']){
			$data['return_date'] = $db->toDBDate($data['return_date']);
		}else{
			$data['return_date'] = $db->getCurrentDate();
		}
		
		
		$sql .= "return_date='{$data['return_date']}', ";
		$sql .= "status='{$data['status']}', ";
		$branch_store = 0;
		$sql .= "branch_store='{$branch_store}', ";
		//$sql .= "ref_inv_no={$data['ref_inv_no']}, ";
		//$sql .= "invoice_date='{$data['invoice_date']}', ";
		$sql .= "supplier_id='{$data['supplier_id']}' ";
		$sql .= "WHERE id='{$return_id}' AND branch_id = '{$branch_id}'";
		$ru = $db->update_by_sql($sql);
		$res = $this->finishRetDetails($data);	
		//}
		if(!$res){$error=true;}
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		//}else{
			//$error= 'Can\'t update record';
		}
		//echo $error;exit;
		if($error){
			$db->rollback();
			return false;
		}
		
		$db->commit();
		return true;
	}

	public function finishRetDetails($data){
		//purchases table: update totals, status=1,
		//var_dump($data);exit;
		$db = core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$arts = $this->getReturnArticles($data['return_id']);
		$error='';
		$total=0;
		$my_art_m = $this->getModel('articles.branch_article');
		foreach ($arts as $art){
			//print_r($art);exit;
			$qty = $art['qty_scheme']+$art['scheme'];
			$sql = "UPDATE branch_articles ";
			$sql .= "SET qty = qty - {$qty} ";
			/*if(isset($data['update_main_prices']) && $data['update_main_prices']){
				$sql .= ", cost_price='{$data['unit_price']}', ";
				$sql .= "sale_price='{$data['sale_price']}' ";
			}
			
			if($art['expire_date']){
				$my_art = $my_art_m->getBranchData($art['article_code']);
				$d = new DateTime($art['expire_date']);
				//var_dump($d->format(DateTime::RFC3339_EXTENDED)); 
				//$expiry_json = json_encode($my_art['expire_date']);
				$new_josn_exp_arr = array('qty'=>$art['qty_scheme'], 'expiry'=>$d->format(DateTime::ATOM));
				
				if($my_art['stock_expiry_dates']){
					//use php object append
					$json_old_arr = json_decode($my_art['stock_expiry_dates'],true);
					$json_old_arr['term'][]=$new_josn_exp_arr;
					$json_old = json_encode($json_old_arr);
					$sql.=",stock_expiry_dates = '{$json_old}' ";
				}else{
					$new_josn_exp = json_encode(array('term'=>array($new_josn_exp_arr)));
					$sql.=",stock_expiry_dates = '{$new_josn_exp}' ";
				}
				
			}*/
			
			
			$sql .= "WHERE branch_id='{$branch_id}' AND article_code = '{$art['article_code']}'";
			$ru  = $db->update_by_sql($sql);
			if(!$ru){
				$error=true;
				$db->setMessage('Error updating stock/expiry alert<br/>');
			}
			$total += ($art['unit_price']*$art['qty_scheme']);
		}
		$total_equation = round($total)-round($data['cash'])-round($data['credit']);
		//echo $total_equation;exit;
		if(round($total_equation)!=0){
			$error=true;
			$db->setMessage("Please currect cash and credit value: (difference is {$total}) <br/>Total ({$total}) = Cash:{$data['cash']}+Credit:{$data['credit']} <br/>");
			$db->rollback();
			return false;
		}
		if($error){
			$db->rollback();
			return false;
		}
		$return_id=$data['return_id'];
		$sql="UPDATE branch_purchase_returns SET ";
		$sql.="amount='{$total}', ";
		$sql.="cash='{$data['cash']}', ";
		$sql.="credit='{$data['credit']}', ";
		$sql.="status=1 ";
		$sql.="WHERE id='{$return_id}' AND branch_id='{$branch_id}' ";
		$ru  = $db->update_by_sql($sql);
		if(!$ru){
			$error=true;
			$db->setMessage('Error update purchase return info.');
			$db->rollback();
			return false;
		}
		$db->setMessage("Action successful");
		//if credit then save record in supplier_credit table
		

		if($data['credit']){
			if($data['supplier_id']){

				$arr_credit=array();
				$arr_credit['supplier_id'] = $data['supplier_id'];
				$arr_credit['ref_no'] = "purchases.return.{$return_id}";
				$arr_credit['amount'] = $data['credit'];
				$sup_id = $this->getModel('suppliers.credit')->createData($arr_credit,false);
				if(!$sup_id){
					$error=true;
					$db->setMessage('Un able to save the Supplier payments. Operation failed<br/>');
					$db->rollback();
					return false;
				}
				$sql = "UPDATE suppliers s INNER JOIN supplier_credits sc ON (s.id = sc.supplier_id) ";
				$sql .= "SET ";
				$sql .= "sc.old_account_value=s.account_value, ";
				$sql .= "s.account_value=s.account_value-{$data['credit']} ";
				$sql .= "WHERE s.id='{$data['supplier_id']}' AND s.branch_id = {$branch_id} AND sc.ref_no = '{$arr_credit['ref_no']}'";
				$ru = $db->update_by_sql($sql);
				if(!$ru){
					$error=true;
					$db->setMessage("Can't update supplier account.<br/>");
				}
			}else{
				$db->setMessage('Please choose a supplier.<br/>');
				//$db->rollback();
				$error=true;
				//return false;
			}
		}
		$station_id=0;
		if(isset($data['station_id']) && $data['station_id']){
			$station_id = $data['station_id'];
		}
		if(!$station_id){
			$stn = $this->getModel('cash.cash')->getDefaultStation();
			$station_id = $stn['id'];
		}
		if($data['cash']){
			/*$arr_cash=array();
			$cash=$data['cash'];
			$arr_cash['ref_no'] = "purchases.return.{$return_id}";
			$arr_cash['cash'] = $cash;
			$arr_cash['station_id'] = $station_id;
			$arr_cash['file_name'] = 'branch_purchase_returns';
			$arr_cash['file_id'] = $return_id;
			$cp = $this->getModel('cash.receipt');
			//echo $return_id . '...';
			$cr = $cp->createData($arr_cash);
			if(!$cr){
				$error=true;
				$db->setMessage('Error cash payment. ');
			}*/
		}
		if($error){
			$db->rollback();
			return false;
		}
		
		//$db->commit();
		return true;
	}

	public function createReturn($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		//print_r($data);exit;
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "INSERT INTO branch_purchase_returns ";
		$sql .= "(comments,return_date,status,branch_store,ref_inv_no,invoice_date,supplier_id,branch_id) VALUES ( ";
		$sql .= "'{$data['comments']}', ";
		$sql .= "'{$data['return_date']}', ";
		$status=0;
		//if($data['status']){$status=$data['status'];}
		$sql .= "'{$status}', ";
		$branch_store = 0;
		$sql .= "'{$branch_store}', ";
		$sql .= "'{$data['ref_inv_no']}', ";
		$invoice_date="NULL";
		if(isset($data['invoice_date'])){
			$invoice_date = "'{$data['invoice_date']}'";
		}
		$sql .= "{$invoice_date}, ";
		$sql .= "'{$data['supplier_id']}', ";
		$sql .= "'{$branch_id}' ";
		$sql .= ")";
		$ri = $db->insert_by_sql($sql);
		$message='';
		if($ri){
			$message .= ': Record saved.<br/>';
			$db->setMessage($message);
		}else{
			$message .= ': Record not saved.<br/>';
			$db->setMessage($message,'error');
			return false;
		}
		if($db->insert_id()){
			$id = $db->insert_id();
			//echo $id;exit;
			return $id;
		}
		return false;
	}

	public function getNewID(){
		$db=Core::getDBO();
		$sql = "SELECT MAX(return_id)+1 ";
		$sql .= "FROM branch_purchase_returns ";
		$row = $db->get_by_sqlRow($sql);
		$id=1;
		if(isset($row[0])){
			$id = $row[0];
		}
		return $id;
	}

	public function getReturns(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT pr.* ";
		$sql .= "FROM branch_purchase_returns AS pr ";
		$sql .= "LEFT JOIN branch_purchase_return_articles AS pra ON (pr.return_id = pra.return_id) ";
		$sql .= "WHERE pr.status!=0 AND pr.branch_id = {$branch_id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getReturnByID($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT pr.* ";
		$sql .= "FROM branch_purchase_returns AS pr ";
		$sql .= "LEFT JOIN branch_purchase_return_articles AS pra ON (pr.id = pra.return_id) ";
		$sql .= "WHERE pr.branch_id = {$branch_id} AND pr.id={$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRow($sql);
		return $rows;
	}


	public function getReturnArticles($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT pr.*, pra.*, ac.title AS art_title, ac.ref_code, ba.cost_price ";
		$sql .= "FROM branch_purchase_returns AS pr  ";
		$sql .= "INNER JOIN branch_purchase_return_articles AS pra ON (pr.id = return_id) ";
		$sql .= "INNER JOIN articles AS ac ON (pra.article_code= ac.article_code) ";
		$sql .= "INNER JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		//$sql .= "INNER JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql .= "WHERE pr.branch_id = {$branch_id} AND pr.id = {$id} ";
		$rows = $db->get_by_sqlRows($sql);
		//echo $sql;exit;
		return $rows;
	}


}