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


class ModelCart_admin extends Model{
	private $img_limit = 20;

	public function add(){}
	public function update(){
		$m = $this->getModel('vehicle');
		$m->table = 'vehicles';
		$m->data = $this->data;
		$res=$m->update();
		$this->setRedirect("index.php?com=vehicles&view=vehicle_admin&task=edit&id={$this->data['id']}");
		if(isset($this->data['admin_remarks']) && $this->data['admin_remarks']){
			$m = $this->getModel('vehicles');
			$v = $m->getVehicles($this->data['id'], false);
			$data = array();
			$data['user_id'] = $v['user_id'];	//get user_id from vehicles table
			$data['subject'] = 'Admin sent you a message about:' . $this->data['title'];
			$data['body'] = $this->data['admin_remarks'];
			$mail = new Mail();
			$mail->send($data);
		
		}
		//echo $res;
		return true;
		//exit
		
	}
	
	public function setVehicleImages($vehicle,$media){
		$db = Core::getDBO();
		foreach($media as $m){
			$sql = "INSERT INTO vehicles_image_media (vehicle_id,media_id) VALUES ( ";
			$sql .= "{$vehicle}, {$m}) ";
			$db->insert_by_sql($sql);
		}
	}
	
	public function getVehicleImages($vehicle, $user=null){
		$db = Core::getDBO();
		$user=User::isLogin();
		//$user = Core::getUser()->getUser();
		
		$sql = "SELECT m.*, vim.vehicle_id FROM vehicles_image_media AS vim ";
		$sql .= "INNER JOIN media AS m ON (m.id=vim.media_id) ";
		$sql .= "WHERE vim.vehicle_id ={$vehicle} ";
		if($user){
			$sql .= " AND m.user_id = {$user['id']} ";
		}
		return $db->get_by_sqlRows($sql);
	}
	
	public function getImage($id){
		$db = Core::getDBO();
		//$user=User::isLogin();
		
		$sql = "SELECT m.*, vim.vehicle_id FROM vehicles_image_media AS vim ";
		$sql .= "INNER JOIN media AS m ON (m.id=vim.media_id) ";
		$sql .= "WHERE vim.media_id ={$id} ";
		//if($this->user){
			//$sql .= "AND m.user_id = {$this->user['id']} ";
		//}
		return $db->get_by_sqlRow($sql);
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
		$this->view="makes";	//used for redirect
		$this->table="makes";
		$db=Core::getDBO();
		$user = Core::getUser()->getUser();
		
		$vehicle = $this->data['id'];
		$images = $this->getVehicleImages($vehicle,$user);
		if($images){
			foreach($images as $i){
				$this->image_id=$i['id'];
				// remove data of images in db along with images
				$this->removeImage();
			}
			
		}
		
		$sql = "DELETE FROM vehicles ";
		$sql .= "WHERE id= {$vehicle}";
		$rows = $db->update_by_sql($sql);
		return $rows;
		//parent::remove();
	}

}

