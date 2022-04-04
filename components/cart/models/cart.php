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


class ModelCart extends Model{
	private $img_limit = 20;

	public function add(){
		//$id = parent::add();
	}
	public function update(){
		//$up = parent::update();
		
	}
	
	public function getPaymentMethods($id=null){
		$db = Core::getDBO();
		//$user=User::isLogin();
		
		$sql = "SELECT pm.* FROM payment_methods AS pm ";
		$sql .= "WHERE published = 1 ";
		if($id){
			$sql .= "AND pm.id ={$id} ";
			return $db->get_by_sqlRow($sql);
		}
		return $db->get_by_sqlRows($sql);
	}
	
	public function setCover(){
		$db=Core::getDBO();
		$id=$_POST['id'];
		$media_id=$_POST['media_id'];
		$sql = "UPDATE vehicles SET ";
		$sql .= "image_id = {$media_id} ";
		$sql .= "WHERE id={$id}";
		$res = $db->update_by_sql($sql);
	}

	public function approveVehicle(){
		$db=Core::getDBO();
		$id=$_POST['id'];
		$sql = "UPDATE vehicles SET ";
		$sql .= "visibility = 2 ";
		$sql .= "WHERE id={$id}";
		$res = $db->update_by_sql($sql);
	}

	public function removeImage(){
		$db=Core::getDBO();
		if(!$this->image_id){
			$this->image_id=$_POST['id'];
		}
		$user = Core::getUser()->getUser();
		$image = $this->getImage($this->image_id);
		$f1[] = Images::removeMedia($image['file']);
		$f1[] = Images::removeMedia($image['img_pc']);
		$f1[] = Images::removeMedia($image['img_tablet']);
		$f1[] = Images::removeMedia($image['img_mobile']);
		$f1[] = Images::removeMedia($image['img_thumb']);
		
		//exit;
		$sql = "DELETE vim FROM vehicles_image_media vim ";
		$sql .= "INNER JOIN media m ON (m.id=vim.media_id) ";
		$sql .= "WHERE m.id={$this->image_id} AND m.user_id = {$user['id']}";
		$res = $db->delete_by_sql($sql);
		
		$sql = "DELETE FROM media  ";
		$sql .= "WHERE id={$this->image_id} AND user_id = {$user['id']} ";
		$res = $db->delete_by_sql($sql);
		return $res;
	}
	
	public function remove(){
		$this->table="vehicles";
		$db=Core::getDBO();
		
		$vehicle = $this->data['id'];
		
		$sql = "UPDATE vehicles SET visibility=0 ";
		$sql .= "WHERE id= {$vehicle}";
		$rows = $db->update_by_sql($sql);
		return $rows;
		//parent::remove();
	}

}

