<?php
defined('_MEXEC') or die ('Restricted Access');


class Model extends Mobject{
	private $db;
	public $data=array();
	protected $table,$view;	//default view might be use for redirects etc...
	protected $where;
	
	function __construct() {
		$this->db = Core::getDBO();
	}

	public function publishedList() {
		$arr=array();
		$arr[0]='No';
		$arr[1]='Yes';
		return $arr;
	}
	public function getGroups(){
		$user=Core::getUser();
		$u=$user->getUser();
		$db=Core::getDBO();
		$sql = "SELECT ug.* FROM user_groups AS ug ";
		$sql .= "WHERE group_id <= {$u['group_id']} ";
		//echo $sql;exit;
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public function getPrivileges(){
		$user=Core::getUser();
		$u=$user->getUser();
		$db=Core::getDBO();
		$sql = "SELECT up.* FROM user_privileges AS up ";
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public function add(){
		$msg_pre='ID ';
		$msg_post='created. ';
		try{
			if(isset($this->msg_pre)){
				$msg_pre=$this->msg_pre;
			}
			if(isset($this->msg_post)){
				$msg_post=$this->msg_post;
			}
			if(!isset($this->ignore_redirect)){
				$this->ignore_redirect=false;
			}
			//echo $this->getRedirect();exit;
			$redirect = $this->getRedirect();
			if(!$redirect && $this->ignore_redirect){
				if($this->view){
					$url = "index.php?com=" . Application::$options->com . "&view=" . $this->view;
				}else{
					$url = "index.php?com=" . Application::$options->com . "&view=" . Application::$options->view . "&task=" . Application::$options->task;
					if(isset(Application::$options->id) && Application::$options->id){
						$url .= '&id=' . Application::$options->id;
					}
					if(Application::$options->menu){
						$url .= '&menu=' . Application::$options->menu;
					}
				}
				$this->setRedirect($url);
				$redirect = $this->getRedirect();
			}
			//$this->data=$_POST;
			if(isset($this->data['id']) && !$this->data['id']){
				unset($this->data['id']);
			}
			if(isset($this->data['action'])){
				unset($this->data['action']);
			}
			if(isset($this->data['token'])){
				if($_SESSION['token'] != $this->data['token']){return false;}
				unset($this->data['token']);
			}
			if(isset($this->data['source']) && !$this->table){
				$this->table = $this->data['source'];
				unset($this->data['source']);
			}
			if(!$this->table){
				setLog('Table is not set for update action','Error');
				return false;
			}
			$sql = DBHelper::array_insert_sql($this->data, $this->table);
			//setLog("{$sql}",'Log');
			$db=Core::getDBO();
			$res = $db->insert_by_sql($sql);
			$c = $db->insert_id();
			
			
			if(!$c){
				$msg="No Record inserted";
				throw new Exception($msg, 610);
			}
			//setLog("{$c}",'Log');
			
			$message = $msg_pre . " {$c} " . $msg_post;
			$this->setMessage($message, "info");
			if($redirect){
				$this->redirect($redirect);
			}
			if(Application::$options->task=='json'){
				$res = json_encode(array(
					'data' => array(
					'inserted' => $c,
					'message' => $message,
					),
					));
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			return $c;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			setLog($res,'error');
			echo $res;exit;
		}
	}
	
	public function update(){
		//setLog('updating model.php','Test');
		$msg_pre='';
		$msg_post='record updated. ';
		if(isset($this->msg_pre)){
			$msg_pre=$this->msg_pre;
		}
		if(isset($this->msg_post)){
			$msg_post=$this->msg_post;
		}
		try{
			if(!$this->getRedirect()){
				if($this->view){
					$url = "index.php?com=" . Application::$options->com . "&view=" . $this->view;
				}else{
					$url = "index.php?com=" . Application::$options->com . "&view=" . Application::$options->view . "&task=" . Application::$options->task;
					if(Application::$options->id){
						$url .= '&id=' . Application::$options->id;
					}
					if(Application::$options->menu){
						$url .= '&menu=' . Application::$options->menu;
					}
				}
				$this->setRedirect($url);
			}
			//$this->data=$_POST;
			if(!isset($this->data['id'])){
				setLog('ID not set','Error');
				return false;
			}elseif(!$this->where){
				$this->where = "id={$this->data['id']}";
			}
			if(isset($this->data['action'])){
				unset($this->data['action']);
			}
			if(isset($this->data['source'])){
				if(!$this->table){
					$this->table = $this->data['source'];
				}
				unset($this->data['source']);
			}
			if(isset($this->data['token'])){
				/*if($_SESSION['token'] != $this->data['token']){
					setLog('Token doesn\'t set','Error');
					return false;
				}*/
				unset($this->data['token']);
			}
			if(!$this->table){
				setLog('Table is not set for update action','Error');
				return false;
			}
			if(!$this->where){
				setLog('Where condition not set','Error');
				return false;
			}
			//print_r($this->data);exit;
			$sql = DBHelper::array_update_sql($this->data, $this->table,$this->where);
			//setLog("{$sql}",'Log');
			$db=Core::getDBO();
			$res = $db->update_by_sql($sql);
			if(!$res){
				$msg="No data updated";
				throw new Exception($msg, 610);
			}
			
			$message = $msg_pre . " {$res} " . $msg_post;
			$res = json_encode(array(
				'data' => array(
				'updated' => $res,
				'message' => $message,
				),
				));
			if(Application::$options->task=='json'){
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			$this->setMessage($message, "info");
			return $res;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			echo $res;exit;
		}
	}
	
	public function publish(){
		//setLog('updating model.php','Test');
		$msg_pre='';
		$msg_post='record published. ';
		if(isset($this->msg_pre)){
			$msg_pre=$this->msg_pre;
		}
		if(isset($this->msg_post)){
			$msg_post=$this->msg_post;
		}
		try{
			if(!$this->getRedirect()){
				if($this->view){
					$url = "index.php?com=" . Application::$options->com . "&view=" . $this->view;
				}else{
					$url = "index.php?com=" . Application::$options->com . "&view=" . Application::$options->view . "&task=" . Application::$options->task;
					if(Application::$options->id){
						$url .= '&id=' . Application::$options->id;
					}
					if(Application::$options->menu){
						$url .= '&menu=' . Application::$options->menu;
					}
				}
				$this->setRedirect($url);
			}
			//$this->data=$_POST;
			if(!isset($this->data['id'])){
				$msg="ID not set";
				throw new Exception($msg, 610);
			}elseif(!$this->where){
				$this->where = "id={$this->data['id']}";
			}
			if(isset($this->data['source'])){
				if(!$this->table){
					$this->table = $this->data['source'];
				}
				unset($this->data['source']);
			}
			if(!$this->table){
				$msg="Table is not set for update action";
				throw new Exception($msg, 610);
			}
			if(!$this->where){
				$msg="Where condition not set";
				throw new Exception($msg, 610);
			}
			//print_r($this->data);exit;
			$data=array();
			$data['id']=$this->data['id'];
			$data['published']=$this->data['published'];
			$sql = DBHelper::array_update_sql($data, $this->table,$this->where);
			//setLog("{$sql}",'Log');
			$db=Core::getDBO();
			$res = $db->update_by_sql($sql);
			if(!$res){
				$msg="No data updated";
				throw new Exception($msg, 610);
			}
			
			$message = $msg_pre . " {$res} " . $msg_post;
			$res = json_encode(array(
				'data' => array(
				'updated' => $res,
				'message' => $message,
				),
				));
			if(Application::$options->task=='json'){
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			$this->setMessage($message, "info");
			return $res;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			setLog($e->getMessage(),'Error');
			echo $res;exit;
		}
	}
	
	public function remove(){
		$msg_pre='';
		$msg_post=' record(s) deleted.';
		if(isset($this->msg_pre)){
			$msg_pre=$this->msg_pre;
		}
		if(isset($this->msg_post)){
			$msg_post=$this->msg_post;
		}
		try{
			if(!$this->getRedirect()){
				if($this->view){
					$url = "index.php?com=" . Application::$options->com . "&view=" . $this->view;
				}else{
					$url = "index.php?com=" . Application::$options->com . "&view=" . Application::$options->view . "&task=" . Application::$options->task;
					if(Application::$options->id){
						$url .= '&id=' . Application::$options->id;
					}
					if(Application::$options->menu){
						$url .= '&menu=' . Application::$options->menu;
					}
				}
				$this->setRedirect($url);
			}
			if(!isset($this->data['id'])){
				return false;
			}elseif(!$this->where){
				$this->where = "id={$this->data['id']}";
			}
			if(isset($this->data['source']) && !$this->table){
				$this->table = $this->data['source'];
				unset($this->data['source']);
			}
			if(isset($this->data['token'])){
				if($_SESSION['token'] != $this->data['token']){return false;}
				unset($this->data['token']);
			}
			if(!$this->table){
				setLog('Table is not set for update action','Error');
				return false;
			}
			if(!$this->where){
				setLog('Where condition not set','Error');
				return false;
			}
			$sql = "DELETE FROM {$this->table} WHERE {$this->where}";
			//setLog("{$sql}",'Log');
			$db=Core::getDBO();
			$res = $db->delete_by_sql($sql);
			if(!$res){
				$msg="No Record deleted";
				throw new Exception($msg, 610);
			}
			$message = $msg_pre . " {$res} " . $msg_post;
			if(Application::$options->task=='json'){
				$res = json_encode(array(
					'data' => array(
					'deleted' => $res,
					'message' => $message,
					),
					));
				header("Content-Type: application/json; charset=UTF-8");
				echo $res;exit;
			}
			
			
			$this->setMessage($message, "info");
			return $res;
		}catch (Exception $e) {
			header("Content-Type: application/json; charset=UTF-8");
			$res = json_encode(array(
				'error' => array(
				'message' => $e->getMessage(),
				'code' => $e->getCode(),
				),
			));
			echo $res;exit;
		}
		
	}

	public function getUserPrivileges($u=null){
		if(!$u){
			$u = Core::getUser()->getUser();
		}
		$db=Core::getDBO();
		$sql = "SELECT up.*, CONCAT(up.com, '.', up.privilege_name) AS privilege_alias FROM user_privileges AS up ";
		$sql .= "WHERE id IN ({$u['privileges']})";
		$usr = $db->get_by_sqlRows($sql);
		return $usr;
	}
	
	public static function getModel($name){
		if(!$name){return false;}
		$app = Core::getApplication();
		$parts = explode('.',$name);
		$num = count($parts);
		if($num==2){
			$com_name = $parts[0];
			$model_name = $parts[1];
			$path = ROOT_PATH . DS . 'components' . DS . $com_name . DS . 'models' . DS . $model_name . '.php';
		}elseif($num==1){
			$model_name = $name;
			$path = ROOT_PATH . DS . 'components' . DS . Application::$options->com . DS . 'models' . DS . $name . '.php';
		}
		try{
			if(!$app->loadPHPFile($path)){
				raiseError('File not found: ' . $path);
			}
			//load class
			$m_name = 'Model' . $model_name;
			if(class_exists($m_name)){
				$model = new $m_name();
				return $model;
			}else{
				raiseError('No object: ' . $m_name);
				return false;
			}
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
	}
	


		
}

