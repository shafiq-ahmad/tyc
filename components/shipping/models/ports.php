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


class ModelPorts extends Model{

	public function add(){}
	public function update(){}
	public function remove(){}

	public function getCityPorts(){	//$city, $port, $v_type){
		$db=Core::getDBO();
		$city = $this->getVar('city',null,'post');
		//$port = $this->getVar('port',null);
		//$v_type = $this->getVar('v_type',null);
		//echo 'heee....';exit;
		try{
			/*if(!$city && !$port && !$v_type){
				$msg="City or Port or Vehicle type not supplied!!!";
				throw new Exception($msg, 610);
			}*/
			//echo 'hi...';
			$sql = "SELECT DISTINCT p.id, p.title ";
			$sql .= "FROM ports AS p ";
			$sql .= "LEFT JOIN port_cities AS pc ON (p.id = pc.port_id) ";
			$sql .= "LEFT JOIN cities AS ct ON (ct.id = pc.city_id) ";
			$sql .= "WHERE pc.city_id = {$city} "; 		//"AND pc.port_id = {$port} AND pc.vehicle_type={$v_type} ";
			$rows = $db->get_by_sqlRows($sql);
			if(!$rows){
				$msg="Port cities not found!!!";
				throw new Exception($msg, 610);
			}
			if(Application::$options->task=='json'){
				$res = json_encode(
				array(
					'data' => $rows,
				)
				);
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			return $rows;
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
		};
	}

}

