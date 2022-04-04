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


class ModelContactus extends Model{

	public function getData($id=null, $status=null, $published=null){

		$db=Core::getDBO();
		//$user=Core::getUser();
		//status, parent_id, published
		$sql = "SELECT * FROM contacted_us ";
		$where = 'WHERE';
		$and = '';
		if($status){
			$sql .= "{$where} status={$status} ";
			$where='';
			$and = 'AND';
		}

		if($published){
			$sql .= "{$where} {$and} published={$published} ";
			$where='';
			$and = 'AND';
		}

		if(strpos($id,',')>=1){
			echo strpos($id,',');
			$id=explode(',',$id);
		}
		if($id){
			if(is_array($id)){
				$in = implode(',',$id);
				$sql.="{$where} {$and} v.id IN ='{$in}'";
			}else{
				$sql.="{$where} {$and} v.id={$id}";
				$rows = $db->get_by_sqlRow($sql);
				return $rows;
			}
		}
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	
	public function getAdminData($id=null, $status=null, $published=null, $limit=50){

		$db=Core::getDBO();
		//$user=Core::getUser();
		//status, parent_id, published
		$sql = "SELECT us.*, cs.title AS status_title, u.full_name AS user_full_name, c.title AS city_title FROM contacted_us AS us ";
		$sql .= "INNER JOIN contact_statuses AS cs ON (us.status = cs.id) ";
		$sql .= "LEFT JOIN users AS u ON (us.user_id = u.id) ";
		$sql .= "LEFT JOIN cities AS c ON (us.city_id = c.id) ";
		$where = 'WHERE';
		$and = '';
		if($status){
			$sql .= "{$where} status >0 AND status={$status} ";
			$where='';
			$and = 'AND';
		}

		if($published){
			$sql .= "{$where} {$and} published={$published} ";
			$where='';
			$and = 'AND';
		}

		if(strpos($id,',')>=1){
			echo strpos($id,',');
			$id=explode(',',$id);
		}
		if($id){
			if(is_array($id)){
				$in = implode(',',$id);
				$sql.="{$where} {$and} v.id IN ='{$in}'";
			}else{
				$sql.="{$where} {$and} v.id={$id}";
				$rows = $db->get_by_sqlRow($sql);
				return $rows;
			}
		}
		$sql .= ' ORDER BY us.id DESC';
		if($limit){
			$sql .= " LIMIT {$limit} ";
		}
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	

	public function getUserData($id=null,$visibile=true){
		$db=Core::getDBO();
		$user=Core::getUser()->getUser();
		$sql = "SELECT u.full_name AS owner_name, y.title AS yearfull, m.title AS make_name, t.title AS tra_name, ";
		$sql .= "v.* ";
		$sql .= "FROM vehicles AS v ";
		$sql .= "LEFT JOIN users AS u ON (u.id = v.user_id) ";
		$sql .= "LEFT JOIN years AS y ON (y.id = v.year) ";
		$sql .= "LEFT JOIN makes AS m ON (m.id = v.make_id) ";
		$sql .= "LEFT JOIN transmission AS t ON (t.id = v.transmission) ";
		//$sql .= "LEFT JOIN countries AS c ON (c.id = ct.country_id) ";
		$where = 'WHERE ';
		$sql .= "WHERE v.user_id = {$user['id']} ";
		$and = 'AND';
		if($visibile){
			$sql .= "{$and} (v.visibility=1 OR v.visibility=3) ";
			$and = 'AND';
			$where = '';
		}

		if(strpos($id,',')>=1){
			echo strpos($id,',');
			$id=explode(',',$id);
		}
		if($id){
			if(is_array($id)){
				$in = implode(',',$id);
				$sql.="{$and} v.id IN ='{$in}'";
				//$and = 'AND';
			}else{
				$sql.="{$and} v.id={$id}";
				$rows = $db->get_by_sqlRow($sql);
				//return $rows;
			}
		}
		//return $sql;
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}
	

	public function add(){}
	public function update(){}
	public function remove(){}

}

