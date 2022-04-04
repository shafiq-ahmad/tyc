<?php
defined('_MEXEC') or die ('Restricted Access');

class DBHelper extends Mobject{

	public static $db_type='sql'; //or nosql
	public static $crud_type='insert'; //insert,update,delete
	
	function __construct() {}
	
	public static function data_field_remove(&$data, $field) {
		//remove field
		//$key = array_search('str in value', $data);
		if(isset($data[$field])){
			unset($data[$field]);
			return true;
		}
		return false;
	}
	
	public static function data_field(&$data, $field, $default=null, $required=false) {
		if(self::$db_type == 'sql' && self::$crud_type=='insert'){
			return self::data_field_sql_insert($data, $field, $default, $required);
		}elseif(self::$db_type == 'sql' && self::$crud_type=='update'){
			return self::data_field_sql_update($data, $field, $default, $required);
		}
	}
	
	public static function data_field_sql_update(&$data, $field, $default, $required) {
		//mysqli_real_escape_string($con, $text)
		if(isset($data[$field])){
			if($data[$field]){
				//escape quotes
				$data[$field] = addslashes($data[$field]);
				$data[$field] = "{$field} = '{$data[$field]}'";
				return true;
			}
			if($required){
				//raise error
				return false;
			}
			if($default){
				$default = addslashes($default);
				$data[$field] = "{$field} = '{$default}'";
				return true;
			}elseif($default===null){
				$data[$field] = "{$field} = NULL";
				return true;
			}elseif($default===0){
				$data[$field] = "{$field} = 0";
				return true;
			}else{
				$data[$field] = "{$field} = ''";
				return true;
			}
		}else{
			if($required){
				//raise error
				return false;
			}
			if($default){
				$default = addslashes($default);
				$data[$field] = "{$field} = '{$default}'";
				return true;
			}elseif($default===null){
				$data[$field] = "{$field} = NULL";
				return true;
			}elseif($default===0){
				$data[$field] = "{$field} = 0";
				return true;
			}else{
				$data[$field] = "{$field} = ''";
				return true;
			}
		}
		//return or raise error
		return false;
	}
	
	public static function data_field_sql_insert(&$data, $field, $default, $required) {
		if(isset($data[$field])){
			if($data[$field]){
				//escape quotes
				$data[$field] = addslashes($data[$field]);
				$data[$field] = "'{$data[$field]}'";
				return true;
			}
			if($required){
				//raise error
				return false;
			}
			if($default){
				$default = addslashes($default);
				$data[$field] = "'{$default}'";
				return true;
			}elseif($default===null){
				$data[$field] = "NULL";
				return true;
			}elseif($default===0){
				$data[$field] = "0";
				return true;
			}else{
				$data[$field] = "''";
				return true;
			}
		}else{
			if($required){
				//raise error
				return false;
			}
			if($default){
				$default = addslashes($default);
				$data[$field] = "'{$default}'";
				return true;
			}elseif($default===null){
				$data[$field] = "NULL";
				return true;
			}elseif($default===0){
				$data[$field] = "0";
				return true;
			}else{
				$data[$field] = "''";
				return true;
			}
		}
		//return or raise error
		return false;
	}

	public static function data_field_nosql(&$data, $field, $default=null, $required=false) {
		
		if(isset($data[$field])){
			if($data[$field]){
				return true;
			}
			if($required){
				//raise error
				return false;
			}
			if($default){
				$data[$field] = $default;
				return true;
			}
			//remove field from array
		}else{
			if($required){
				//raise error
				return false;
			}
			if($default){
				$data[$field] = $default;
				return true;
			}
			//remove field from array
		}
		//return or raise error or remove field from array
		return false;
		
	}

	public static function array_insert($data, $db_type='mysql') {}
	
	public static function sql_inj_safe($values) {
		$arr = array();
		foreach ($values as $key =>$val){
			if($val=='on'){
				$val=1;
			}elseif($val=='off'){
				$val = 0;
			}
			//if($val){
				$arr[$key] = "'" . addslashes($val) . "'";
			//}else{//unset($arr[$key]);}
		}
		return $arr;
	}

	public static function sql_inj_safe_update($data) {
		$arr = array();
		foreach ($data as $key =>$val){
			if($val=='on'){
				$val=1;
			}elseif($val=='off'){
				$val = 0;
			}
			$arr[] = "{$key} = '" . addslashes($val) . "'";
		}
		return $arr;
	}

	public static function array_insert_sql($data, $table) {
		$keys = array_keys($data);
		$values = array_values($data);
		$values = self::sql_inj_safe($values);
		$keys = implode($keys, ',');
		$values = implode($values, ',');
		$sql = "INSERT INTO {$table} ({$keys}) VALUES ({$values});";
		return $sql;
	}
	
	public static function array_update_sql($data, $table, $where=0) {
		//make seperate method DBHelper::data_field,  which will handle 
		
		$values = self::sql_inj_safe_update($data);
		//$values = array_values($data);
		$values = implode($values, ',');
		$sql = "UPDATE {$table} SET {$values} WHERE {$where};";
		return $sql;
	}
	
	public static function array_insert_json($data, $table) {
		
		
	}

}

$dbhelper = new DBHelper();
$dbh =& $dbhelper;


