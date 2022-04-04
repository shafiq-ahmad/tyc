<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelPurchase extends Model{

	public function updatePurchase($data){
		if(!$data['cash']){
			$data['cash']=0;
		}
		if(!$data['credit']){
			$data['credit']=0;
		}
		if(!$data['credit_terms']){
			$data['credit_terms']='';
		}
		$db=Core::getDBO();
		$db->start();
		$error=false;
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$purchase_id=$data['purchase_id'];
		$sql = "UPDATE branch_purchases ";
		$sql .= "SET comments='{$data['comments']}', ";
		$sql .= "cash='{$data['cash']}', ";
		$sql .= "credit='{$data['credit']}', ";
		$sql .= "credit_terms='{$data['credit_terms']}' ";
		$sql .= "WHERE purchase_id='{$data['purchase_id']}' AND branch_id = '{$branch_id}'";
		$ru = $db->update_by_sql($sql);
		//if($data['finish_purchase']){
		$res = $this->finishPurDetails($data);	
		//}
		if(!res){$error=true;}
		$message='';
		if($ru){
			$message .= ': Record updated.<br/>';
			$db->setMessage($message);
		}else{
			$error= true;
		}
		if($error){
			$db->rollback();
			return false;
		}
		
		$db->commit();
		return true;
		
	}

	public function finishPurDetails($data){
		//purchases table: update totals, status=1,
		//var_dump($data);exit;
		$db = core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$c = $user->getCompany();
		$branch_id = $u['branch_id'];
		$arts = $this->getPurchaseArticles($data['purchase_id']);
		$error='';
		$total=0;
		$my_art_m = $this->getModel('articles.branch_article');
		foreach ($arts as $art){
			//print_r($art);exit;
			$qty = $art['qty_scheme']+$art['scheme'];
			$sql = "UPDATE branch_articles ";
			$sql .= "SET qty = qty + {$qty} ";
			//if(isset($data['update_main_prices']) && $data['update_main_prices']){
				$sql .= ", cost_price='{$art['unit_price']}', ";
				$sql .= "sale_price='{$art['sale_price']}' ";
			//}
			
			if($art['expire_date']){
				$my_art = $my_art_m->getBranchData($art['article_code']);
				$d = new DateTime($art['expire_date']);
				//var_dump($d->format(DateTime::RFC3339_EXTENDED)); 
				//$expiry_json = json_encode($my_art['expire_date']);
				$new_josn_exp_arr = array('qty'=>$art['qty_scheme'], 'expiry'=>$d->format(DateTime::ATOM));
				
				if($my_art['stock_expiry_dates']){
					//use php object append
					$json_old_arr = json_decode($my_art['stock_expiry_dates'],true);
					$json_old_arr[]=$new_josn_exp_arr;
					$json_old = json_encode($json_old_arr);
					$sql.=",stock_expiry_dates = '{$json_old}' ";
				}else{
					//$new_josn_exp = json_encode(array(array($new_josn_exp_arr)));
					$new_josn_exp = json_encode(array($new_josn_exp_arr));
					$sql.=",stock_expiry_dates = '{$new_josn_exp}' ";
				}
				
			}
			
			
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
		$purchase_id=$data['purchase_id'];
		$sql="UPDATE branch_purchases SET ";
		$sql.="amount='{$total}', ";
		$sql.="cash='{$data['cash']}', ";
		$sql.="credit='{$data['credit']}', ";
		$sql.="status=1 ";
		$sql.="WHERE purchase_id='{$purchase_id}' AND branch_id='{$branch_id}' ";
		$ru  = $db->update_by_sql($sql);
		if(!$ru){
			$error=true;
			$db->setMessage('Error update purchase info.');
			$db->rollback();
			return false;
		}
		$db->setMessage("Action successful");
		//if credit then save record in supplier_credit table
		

		if($data['credit']){
			if($data['supplier_id']){
				//$mdl = $this->getModel('suppliers.supplier'); //this Model is not ready
				//don't insert if same purchase id is inserted....
				/*$sql="INSERT INTO supplier_credits (supplier_id, amount, user_id) VALUES( ";
				$sql.="{$data['supplier_id']}, {$data['credit']}, {$u['user_id']} ";
				$sql.=") ";
				$ri = $db->insert_by_sql($sql);*/

				$arr_credit=array();
				$arr_credit['supplier_id'] = $data['supplier_id'];
				$arr_credit['ref_no'] = "purchases.purchase.{$purchase_id}";
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
				$sql .= "s.account_value=s.account_value+{$data['credit']} ";
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
			$arr_cash['ref_no'] = "purchases.purchase.{$purchase_id}";
			$arr_cash['cash'] = $cash;
			$arr_cash['station_id'] = $station_id;
			$arr_cash['file_name'] = 'branch_purchases';
			$arr_cash['file_id'] = $purchase_id;
			$cp = $this->getModel('cash.payment');
			//echo $purchase_id . '...';
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

	public function validateData(&$data){
		$db=Core::getDBO();
		if(!$data['purchase_date']){
			$data['purchase_date'] = $db->getCurrentDate();
		}else{
			$data['purchase_date'] = $db->toDBDate($data['purchase_date']);
		}
		if(!$data['comments']){
			$data['comments']='';
		}
		if(!$data['ref_inv_no']){
			$data['ref_inv_no']='';
		}
		
		if(!$data['supplier_id']){
			$db->setMessage('Please select a supplier.<br/>');
			return false;
		}
		
		return $data;
	}

	public function createPurchase($data){
		if(!$this->validateData($data)){return false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		$c = $user->getCompany();
		$branch_id = $c['id'];
		$sql = "INSERT INTO branch_purchases ";
		$sql .= "(comments,purchase_date,status,ref_inv_no,supplier_id,branch_id) VALUES ( ";
		$sql .= "'{$data['comments']}', ";
		$sql .= "'{$data['purchase_date']}', ";
		$sql .= "'0', ";
		$sql .= "'{$data['ref_inv_no']}', ";
		$sql .= "'{$data['supplier_id']}', ";
		$sql .= "{$branch_id} ";
		$sql .= ")";
		//echo $sql;exit;
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
		$sql = "SELECT MAX(purchase_id)+1 ";
		$sql .= "FROM branch_purchases ";
		$row = $db->get_by_sqlRow($sql);
		$id=1;
		if(isset($row[0])){
			$id = $row[0];
		}
		return $id;
	}

	public function getPurchases(){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bp.* ";
		$sql .= "FROM branch_purchases AS bp ";
		$sql .= "LEFT JOIN branch_purchase_articles AS bpa ON (bp.purchase_id = bpa.purchase_id) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getPurchaseByID($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bp.* ";
		$sql .= "FROM branch_purchases AS bp ";
		$sql .= "LEFT JOIN branch_purchase_articles AS bpa ON (bp.purchase_id = bpa.purchase_id) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} AND bp.purchase_id={$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRow($sql);
		return $rows;
	}


	public function getPurchaseArticles($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		if(!$id){
			return false;
		}
		$branch_id = $u['branch_id'];
		$sql = "SELECT bp.*, bpa.*, ac.title AS art_title, ac.ref_code, ba.cost_price ";
		$sql .= "FROM branch_purchases AS bp  ";
		$sql .= "INNER JOIN branch_purchase_articles AS bpa ON (bp.purchase_id = bpa.purchase_id) ";
		$sql .= "INNER JOIN articles AS ac ON (bpa.article_code= ac.article_code) ";
		$sql .= "INNER JOIN branch_articles AS ba ON (ba.article_code= ac.article_code) ";
		//$sql .= "INNER JOIN article_cats AS acs ON (ac.parent_cat = acs.id) ";
		$sql .= "WHERE bp.branch_id = {$branch_id} AND bp.purchase_id = {$id} ";
		//echo $sql;exit;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}


}
