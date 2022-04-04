<?php
defined('_MEXEC') or die ('Restricted Access');

class ModelArticle extends Model{
	
	public function getRow($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$sql = "SELECT * FROM articles WHERE id='{$id}' LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		//echo $sql;print_r($row);exit;
		return $row;
	}

	public function getRowByTitle($title, $type=1){
		if(!$title){return false;}
		$db = Core::getDBO();
		$sql = "SELECT * FROM articles WHERE title='{$title}' AND article_type = '{$type}' LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		//echo $sql;print_r($row);exit;
		return $row;
	}

	public function getData($id){
		$db=Core::getDBO();
		$user = Core::getUser();
		$u = $user->getUser();
		$branch_id = $u['branch_id'];
		//$sql = "SELECT a.*, sa.opening_qty, sa.qty, 1 AS qty1, sa.loc, apl.purchase_price, apl.sale_price, ";
		$sql = "SELECT a.*, sa.opening_qty, sa.qty, 1 AS qty1, sa.loc, ";
		$sql .= "ac.title AS sub_category_title, sa.stock_expiry_dates ";
		$sql .= "FROM articles AS a ";
		$sql .= "LEFT JOIN store_articles AS sa ON (a.id = sa.article_id) ";
		//$sql .= "LEFT JOIN article_price_list AS apl ON (a.id = apl.article_id) ";
		$sql .= "LEFT JOIN article_cats AS ac ON (a.category= ac.id) ";
		$sql .= "WHERE a.published=1 AND a.id = '{$id}'  ";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function updateArticlePrice($data){
		$db=Core::getDBO();
		$user=Core::getUser();
		$sql = "UPDATE article_price_list SET ";
		$sql .= "barcode = '{$data['barcode']}', sale_price='{$data['sale_price']}', purchase_price='{$data['purchase_price']}' ";
		$sql .= "WHERE article_id = '{$data['article_id']}', unit_id='{$data['unit_id']}'; ";
		$ri = $db->update_by_sql($sql);
		$message='';
		if($ri){}else{return false;}
		return true;
	}

	public function insertData($data){
		$this->table='articles';
		$db=Core::getDBO();
		$sql = DBHelper::array_insert_sql($data, $this->table);
		$db->insert_by_sql($sql);
		$id = $db->insert_id();
		return $id;
	}

	public function updateData($data){
		$this->table='articles';
		$db=Core::getDBO();
		$sql = DBHelper::array_update_sql($data, $this->table,"id={$data['id']}");
		//setLog($sql);
		$res = $db->update_by_sql($sql);
		return $res;
	}

	public function add(){
		$this->table='tables';
		$this->tags = json_encode($data['tags']);
		$this->seasons = json_encode($data['seasons']);
		return parent::add();
	}

	public function update(){
		$this->table='articles';
		$this->tags = json_encode($this->data['tags']);
		$this->seasons = json_encode($this->data['seasons']);
		parent::update();
		
	}

	public function remove(){
		//parent::remove();
	}

}
