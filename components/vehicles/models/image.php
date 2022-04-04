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

	public function add(){
		parent::add();
	}
	public function update(){
		$this->view="vehicles";	//used for redirect
		//unset($this->data['action']);
		$this->table="vehicles";
		$img_limit = 20;
		//var_dump($_FILES['images']['tmp_name']);exit;
		
		
		$up = parent::update();
		$vehicle = $this->data['id'];
		$media = array();
		$images = $this->getVehicleImages($vehicle);
		$img_count = count($images);
		if($img_count<$img_limit){
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
						break;
					}
				}
			}
		}
		
		if($media){
			$this->setVehicleImages($vehicle,$media);
		}
		$this->setRedirect("index.php?com=vehicles&view=vehicle&task=edit&id={$vehicle}");
		if($ru){
			$c = count($ru);
			$this->setMessage("{$c} record updated. ", "info");
		}

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

	public function getVehicleImages($vehicle){
		$db = Core::getDBO();
		$user = Core::getUser()->getUser();
		$sql = "SELECT m.*, vim.vehicle_id FROM vehicles_image_media AS vim ";
		$sql .= "INNER JOIN media AS m ON (m.id=vim.media_id) ";
		$sql .= "WHERE vim.vehicle_id ={$vehicle} AND m.user_id = {$user['id']} ";
		return $db->get_by_sqlRows($sql);
	}
	
	public function remove(){
		$this->view="makes";	//used for redirect
		$this->table="makes";
		parent::remove();
	}

}

