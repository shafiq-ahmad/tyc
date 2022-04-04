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


class ModelShipping extends Model{

	public function getPorts($port=null, $country=null, $is_origin=null, $is_destination=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		try{
			$sql = "SELECT p.*, c.title as country ";
			$sql .= "FROM ports AS p ";
			$sql .= "LEFT JOIN countries AS c ON (c.id = p.country_id) ";
			$sql .= "WHERE p.published=1 ";
			if($country){
				$sql .= "AND c.id={$country} ";
			}
			/*if($city){
				$sql .= "AND ct.id={$city} ";
			}*/
			if($is_origin){
				$sql .= "AND c.is_origin=1 ";
			}
			if($is_destination){
				$sql .= "AND c.is_destination=1 ";
			}
			if($port){
				$sql .= "AND p.id={$port} ";
				$rows = $db->get_by_sqlRow($sql);
			}else{
				$rows = $db->get_by_sqlRows($sql);
			}
			//echo $sql;//exit;
			//return $rows;
			if(!$rows){
				$msg="No Record found.";
				//$this->setMessage($msg,'info');
				//throw new Exception($msg, 610);
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
			//var_dump($rows);
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
		}
	}

	public function getPortCityByID($id){
		$db=Core::getDBO();
		//echo $city . $port . $v_type;exit;
		try{
			if(!$id){
				$msg="City or Port or Vehicle type not supplied!!!";
				if(Application::$options->task!='json'){
					$this->setMessage($msg);
					return false;
				}
				throw new Exception($msg, 610);
			}
			//echo 'hi...';
			$sql = "SELECT pc.* ";
			$sql .= "FROM ports AS p ";
			$sql .= "LEFT JOIN port_cities AS pc ON (p.id = pc.port_id) ";
			$sql .= "LEFT JOIN cities AS ct ON (ct.id = pc.city_id) ";
			//$sql .= "WHERE pc.city_id = {$city} AND pc.port_id = {$port} AND pc.vehicle_type={$v_type} ";
			$sql .= "WHERE pc.id = {$id} ";
			//setLog($sql);
			$row = $db->get_by_sqlRow($sql);
			if(!$row){
				$msg="Port cities not found!!!";
				if(Application::$options->task!='json'){
					$this->setMessage($msg);
					return false;
				}
				throw new Exception($msg, 610);
			}
			if(Application::$options->task=='json'){
				$res = json_encode(
				array(
					'data' => $row,
				)
				);
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
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
		};
	}

	public function getPortCity($city, $port, $v_type){
		$db=Core::getDBO();
		//echo $city . $port . $v_type;exit;
		try{
			if(!$city || !$port || !$v_type){
				$msg="City or Port or Vehicle type not supplied!!!";
				throw new Exception($msg, 610);
			}
			//echo 'hi...';
			$sql = "SELECT pc.* ";
			$sql .= "FROM ports AS p ";
			$sql .= "LEFT JOIN port_cities AS pc ON (p.id = pc.port_id) ";
			$sql .= "LEFT JOIN cities AS ct ON (ct.id = pc.city_id) ";
			$sql .= "WHERE pc.city_id = {$city} AND pc.port_id = {$port} AND pc.vehicle_type={$v_type} ";
			$row = $db->get_by_sqlRow($sql);
			if(!$row){
				$msg="Port cities not found!!!";
				if(Application::$options->task!='json'){
					$this->setMessage($msg);
					return false;
				}
				throw new Exception($msg, 610);
			}
			if(Application::$options->task=='json'){
				$res = json_encode(
				array(
					'data' => $row,
				)
				);
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
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
		};
	}

	public function getPricesList($origin=null, $dest=null, $country=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		try{
			$sql = "SELECT po.title AS o_port, pd.title AS dest_title, spl.* ";
			$sql .= "FROM shipping_price_list AS spl ";
			//$sql .= "FROM ports AS p ";
			//$sql .= "LEFT JOIN port_cities AS pc ON (pc.port_id = spl.origin_port AND pc.city_id=spl.origin_city) ";
			$sql .= "LEFT JOIN ports AS po ON (po.id = spl.origin_port) ";
			//$sql .= "LEFT JOIN cities AS ct ON (ct.id = po.city_id) ";
			$sql .= "LEFT JOIN countries AS c ON (c.id = po.country_id) ";
			
			$sql .= "LEFT JOIN ports AS pd ON (pd.id = spl.destination_port) ";
			//$sql .= "LEFT JOIN cities AS ctd ON (ctd.id = pd.city_id) ";
			$sql .= "LEFT JOIN countries AS cd ON (cd.id = pd.country_id) ";
			//$sql .= "WHERE c.published=1 AND ct.published=1 ";
			//echo $sql;exit;
			$rows = $db->get_by_sqlRows($sql);
			//return $rows;
			if(!$rows){
				$msg="Prices are not set.";
				//throw new Exception($msg, 610);
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

	public function getPriceList($id){
		if(!$id){return  false;}
		$db=Core::getDBO();
		$user=Core::getUser();
		try{
			$sql = "SELECT po.title o_port, CONCAT(cd.title, ' - ', pd.title) dest_title, spl.* ";
			$sql .= "FROM shipping_price_list AS spl ";
			//$sql .= "FROM ports AS p ";
			$sql .= "LEFT JOIN ports AS po ON (po.id = spl.origin_port) ";
			//$sql .= "LEFT JOIN cities AS ct ON (ct.id = po.city_id) ";
			$sql .= "LEFT JOIN countries AS c ON (c.id = po.country_id) ";
			//$sql .= "LEFT JOIN port_cities AS pc ON (pc.city_id = spl.origin_city AND pc.port_id = spl.origin_port AND pc.vehicle_type = spl.vehicle_type) ";
			
			$sql .= "LEFT JOIN ports AS pd ON (pd.id = spl.destination_port) ";
			//$sql .= "LEFT JOIN cities AS ctd ON (ctd.id = pd.city_id) ";
			$sql .= "LEFT JOIN countries AS cd ON (cd.id = pd.country_id) ";
			$sql .= "WHERE spl.id={$id} ";
			//echo $sql;//exit;
			$rows = $db->get_by_sqlRow($sql);
			//return $rows;
			if(!$rows){
				$msg="Prices are not set.";
				if(Application::$options->task!='json'){
					$this->setMessage($msg);
					return false;
				}
				throw new Exception($msg, 610);
			}
			$action = $this->getVar('action', null, 'post');
			$edit=false;
			if($action='add' || $action='update' || $action='remove'){
				$edit = true;
			}
			if(Application::$options->task=='json' && !$edit){
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

	public function getPriceListByPort($port=null, $dest_port=null,$veh_type=null,$origin_city=null){
		$db=Core::getDBO();
		$user=Core::getUser();
		try{
			$sql = "SELECT po.title o_port, CONCAT(cd.title, ' - ', pd.title) dest_title, spl.* ";
			$sql .= "FROM shipping_price_list AS spl ";
			//$sql .= "FROM ports AS p ";
			$sql .= "LEFT JOIN ports AS po ON (po.id = spl.origin_port) ";
			//$sql .= "LEFT JOIN cities AS ct ON (ct.id = po.city_id) ";
			$sql .= "LEFT JOIN countries AS c ON (c.id = po.country_id) ";
			//$sql .= "LEFT JOIN port_cities AS pc ON (pc.city_id = spl.origin_city AND pc.port_id = spl.origin_port AND pc.vehicle_type = spl.vehicle_type) ";
			
			$sql .= "LEFT JOIN ports AS pd ON (pd.id = spl.destination_port) ";
			//$sql .= "LEFT JOIN cities AS ctd ON (ctd.id = pd.city_id) ";
			$sql .= "LEFT JOIN countries AS cd ON (cd.id = pd.country_id) ";
			$where = "WHERE ";
			$and = "";
			/*if($origin_city){
				$sql .= "{$where} {$and} origin_city={$origin_city} ";
				$where = "";
				$and = "AND ";
			}*/
			if($port){
				$sql .= "{$where} {$and} origin_port = {$port} ";
				$where="";
				$and="AND ";
			}
			if($dest_port){
				$sql .= "{$where} {$and} destination_port = {$dest_port} ";
				$where="";
				$and="AND ";
			}
			if($veh_type){
				$sql .= "{$where} {$and} spl.vehicle_type = {$veh_type} ";
			}
			//echo $sql;exit;
			if($port && $dest_port && $veh_type){
				$rows = $db->get_by_sqlRow($sql);
			}else{
				$rows = $db->get_by_sqlRows($sql);
			}
			if(!$rows){
				$msg="Prices are not set.";
				if(Application::$options->task!='json'){
					$this->setMessage($msg);
					return false;
				}
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
			//return $rows;
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

	public function addPortCity(){
		//$this->view="countries";	//used for redirect
		//unset($this->data['action']);
		$this->table="port_cities";
		parent::add();
		
	}
	public function updatePortCity(){
		$this->table="port_cities";
		parent::update();
	}
	public function removePortCity(){
		$this->table="port_cities";
		parent::remove();
	}
	
	public function add(){}
	public function update(){}
	public function remove(){}

}

