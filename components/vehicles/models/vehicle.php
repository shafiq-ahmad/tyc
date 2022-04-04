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


class ModelVehicle extends Model{
	private $img_limit = 20;

	public function add(){
		$user = Core::getUser()->getUser();
		$this->data['user_id'] = $user['id'];
		$id = parent::add();
		
		$vehicle = $id;
		$media = array();
		$images = $this->getVehicleImages($vehicle);
		$img_count = count($images);
		if($img_count<$this->img_limit){
			if($_FILES['images']['tmp_name'][0]){
				foreach ($_FILES['images']['name'] as $key=>$val){
					$file = array();
					$file['tmp_name'] = $_FILES['images']['tmp_name'][$key];
					$file['name'] = $_FILES['images']['name'][$key];
					$file['type'] = $_FILES['images']['type'][$key];
					$file['size'] = $_FILES['images']['size'][$key];
					$file['error'] = $_FILES['images']['error'][$key];
					$path = 'vehicles' . DS . $vehicle;
					$media[] = Images::upload($file, $path);
					$img_count++;
					if($img_count>$img_limit){
						$this->setMessage(Localize::_('image_limit_exceded'), "warning");
						break 1;
					}
				}
			}
		}
		if($media){
			$this->setVehicleImages($vehicle,$media);
		}
		$this->setRedirect("index.php?com=vehicles&view=vehicle&task=edit&id={$vehicle}");

		$this->setMessage(Localize::_('vehicle_uploaded'), "info");

		return array(0=>$id, 1=>$img_count);
	}
	public function update(){
		$this->view="vehicles";	//used for redirect
		//unset($this->data['action']);
		$this->table="vehicles";
		$vehicle = $this->data['id'];
		
		//var_dump($_FILES['images']['tmp_name']);exit;
		//if editable
		if(isset($vehicle['visibility']) && $vehicle['visibility']<>4){
			if(!$this->data['title']){return false;}
			if(!$this->data['model']){$this->data['mileage']='';}
			if(!$this->data['interior_color']){$this->data['interior_color']='';}
			if(!$this->data['exterior_color']){$this->data['exterior_color']='';}
		}else{
			unset($this->data['title']);
			unset($this->data['model']);
			unset($this->data['interior_color']);
			unset($this->data['exterior_color']);
		}
		if(isset($this->data['finalize'])){
			unset($this->data['finalize']);
			$this->data['visibility'] = 3;
		}
		if(!$this->data['price']){return false;}
		if(!$this->data['mileage']){$this->data['mileage']=0;}
		if(!$this->data['fuel_economy']){$this->data['fuel_economy']=0;}

		
		$up = parent::update();
		if(isset($vehicle['visibility']) && $vehicle['visibility']<>4){
			return $up;
		}
		$media = array();
		$images = $this->getVehicleImages($vehicle);
		$img_count = count($images);
		if($img_count<$this->img_limit){
			if(isset($_FILES['images']['tmp_name'][0]) && $_FILES['images']['tmp_name'][0]){
				foreach ($_FILES['images']['name'] as $key=>$val){
					$file = array();
					$file['tmp_name'] = $_FILES['images']['tmp_name'][$key];
					$file['name'] = $_FILES['images']['name'][$key];
					$file['type'] = $_FILES['images']['type'][$key];
					$file['size'] = $_FILES['images']['size'][$key];
					$file['error'] = $_FILES['images']['error'][$key];
					$path = 'vehicles' . DS . $vehicle;
					$media[] = Images::upload($file, $path);
					$img_count++;
					if($img_count>$img_limit){
						$this->setMessage(Localize::_('image_limit_exceded'), "warning");
						break 1;
					}
				}
			}
		}
		if($media){
			$this->setVehicleImages($vehicle,$media);
		}
		$this->setRedirect("index.php?com=vehicles&view=vehicle&task=edit&id={$vehicle}");
		/*if($up){
			$this->setMessage("{$up} record updated. ", "info");
		}*/

		return array(0=>$up, 1=>$img_count);
		//vehicles_image_media
		
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

