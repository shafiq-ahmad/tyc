<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelSale extends Model{

	public function getData($id, $type=null){
		try{
			if(!$id){
				return false;
				//$msg="No Record selected....";
				//throw new Exception($msg, 610);
			}
			$db=Core::getDBO();
			$user=Core::getUser()->getUser();
			$sql = "SELECT s.*, ss.title AS status_name, u.full_name, ";
			$sql .= "vt.title AS vat_title, vt.vat_action, vt.vat_value ";
			$sql .= "FROM sales AS s ";
			$sql .= "LEFT JOIN users AS u ON (s.user_id = u.id) ";
			$sql .= "LEFT JOIN sale_statuses AS ss ON (s.sale_status = ss.id) ";
			$sql .= "LEFT JOIN vat_types AS vt ON (s.vat_type_id = vt.id) ";
			$sql .= "WHERE s.id = {$id} ";
			if($type){
				$sql .= "AND s.sale_status = {$type} ";
			}
			//$sql .= "ORDER BY id DESC ";
			//echo $sql;exit;
			$sql .= "LIMIT 1 ";
			$row = $db->get_by_sqlRow($sql);
			//var_dump($row);exit;
			return $row;
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

	public function getInvoiceByID($id){
		$db=Core::getDBO();
		$sql = "SELECT * FROM sales WHERE id={$id} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getOpenInvoice($id){
		$db=Core::getDBO();
		$user=Core::getUser();
		$u=$user->getUser();
		$branch_id = $u['branch_id'];
		$sql = "SELECT bs.*, c.title AS cust_title, u.full_name ";
		$sql .= "FROM branch_sales AS bs  ";
		$sql .= "LEFT JOIN customers AS c ON (bs.customer_id = c.id) ";
		$sql .= "LEFT JOIN users AS u ON (bs.user_id = u.user_id) ";
		$sql .= "WHERE bs.branch_id = {$branch_id} AND bs.id = {$id} ";
		$sql .= "AND bs.sale_status=0 ";
		//echo $sql;exit;
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}
	

	public function order(){
		//$db=Core::getDBO();
		//$db->start();
		/*if(!$error){
			$db->commit();
			$j = json_encode($bill);
			//echo $j;
			return $j;
		}else{
			//echo 'hi...';
			$db->rollback();
			return false;
		}*/
		try{
			$user = Core::getUser()->getUser();
			$user_id = $user['id'];
			
			
			$art_model=$this->getModel('articles.article');
			$art = $art_model->getArticleByID($this->data['article_id']);
			$json_arr = array();
			$_is_stock_article = false;
			$j_art=array();
			$j_art['article_id']=$this->data['article_id'];
			$j_art['title']=$art['title'];
			$j_art['qty']=$qty;
			$j_art['stock']=$art['qty'];
			$j_art['cost_price']=$art['cost_price'];
			$j_art['price']=$art['sale_price'];
			//$j_art['tp_price']=$tp_price;
			//$j_art['price_terms']=array($price_terms);
			$j_art['price_terms']=array();
		
		
		
		
			$sale_dt=date('Y-m-d H:i:s');
			$sale_date=date('Y-m-d');
			$data['sale_status']=2;
			$data['sale_date']=$sale_date;
			$data['time_stamp']=$sale_dt;
			$data['customer_id']=$user_id;
			$data['user_id']=$user_id;
			$data['sub_total']=$data['amount'];
			$data['vat_amount']=$data['amount']*0.05;
			$data['method_of_payment']=$this->data['payment_method'];
			$data['data_articles']='[' . json_encode($j_art) . ']';	
			//$this->data->id = $m_art->insertData($data);
			
			unset($this->data['amount']);
			unset($this->data['payment_method']);
			$this->table="sales";
			
			//parent::add();
		}catch (Exception $e){
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
		
	public function paid(){
		$db=Core::getDBO();
		$db->start();
		$error="";
		try{
			$user = Core::getUser()->getUser();
			$user_id = $user['id'];
			$acc_m = $this->getModel('accounts.transaction');
			$model = $this->getModel('sales.sale');
			$art_m=$this->getModel('articles.article');
			$id = $this->getVar('id',null,'get');
			$sale = $model->getData($id);
			$total = $this->getVar('total',null,'post');
			$sub_total = $this->getVar('sub_total',null,'post');
			$vat_amount = $this->getVar('vat_amount',null,'post');
			//var_dump($_GET);exit;
			unset($this->data);
			$this->data=array();
			$this->data['transaction_id'] = $acc_m->addTrans(5, $total, array(0=>array('account_id'=>1, 'amount'=>$sub_total),array('account_id'=>7, 'amount'=>$vat_amount)));//5:sale,
			
			$articles=json_decode($sale['data_articles'],true);
			
			foreach ($articles as $a){
				$art = $art_m->getRow($a['article_id']);
				if($art['article_type']==5){
					//increase user subscription by qty
					$sql = "UPDATE users SET balance_subscriptions=balance_subscriptions+{$a['qty']} ";
					$sql .= "WHERE id = {$sale['user_id']} ";
					$res = $db->update_by_sql($sql);
					if(!$res){
						$error.="<p>Faild subscription update: sale # {$sale['id']}</p>";
					}
					
				}
			}
		
			$this->data['id']=$id;
			$this->data['sale_status']=10;
			$this->data['user_id']=$user_id;
			$this->table="sales";
			$this->setRedirect('?com=sales&view=sale_orders');
			
			parent::update();
			if(!$error){
				$db->commit();
			}else{
				$db->rollback();
				return $error;
			}
		}catch (Exception $e){
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			//setLog($res,'error');
			$db->rollback();
			echo $res;exit;
		}
	}
	
	public function newInv(){
		//$db=Core::getDBO();
		//$id = $db->insert_id();
		$this->table="sales";
		$this->data['sale_date']=date('Y-m-d');
		$sale_status = $this->getVar('sale_status',2,'post');
		$vat_type_id = $this->getVar('vat_type_id',2,'post');
		$this->data['vat_type_id']=$vat_type_id;
		$this->data['sale_status']=$sale_status;
		Application::$options->task='default';
		$id = parent::add();
		$data = $this->getData($id);
		$res = json_encode(array(
			'data' => array('data' => $data)
		));
		echo $res;exit;
	}
	

	
}
