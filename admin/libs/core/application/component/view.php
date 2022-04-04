<?php
defined('_MEXEC') or die ('Restricted Access');


class View extends Mobject{
	
	private $db;
	private $model;
	private $_com,$_view,$_task;
	private $layout = 'default';
	
	function __construct() {}

	public function loadLayout($name = 'default'){
		global $db;
		$this->$db = $db;
		$file = 'tmpl' . DS . $name . '.php';
		if(is_file($file)){
			include $file;
		}
	}
	
	public function getLayout(){
		if($this->layout){return $this->layout;}
	}

	public function getView($name = '') {
		
		
		$app = Core::getApplication();
		$options = $app->getOptions();
		if(!$name){
			$name = $options->view;
		}
		$parts = explode('.',$name);
		$num = count($parts);
		
		try{
		if($num==2){
			$com_name = $parts[0];
			$view_name = $parts[1];
			//var_dump($parts);exit;
			$file = BASE_PATH . DS . 'components' . DS . $com_name . DS . 'views' . DS . $view_name . DS . 'view.php';
		}elseif($num==1){
			$com_name = Application::$options->com;
			$view_name = $name;
			$file = BASE_PATH . DS . 'components' . DS . $com_name . DS . 'views' . DS . $view_name . DS . 'view.php';
		}/**/
		
		$this->_com=$com_name;
		$this->_view=$view_name;
			if(!$app->loadPHPFile($file)){
				raiseError('File not found: View' . $file);
			}
			$class_name = ucfirst($view_name) . 'View' . ucfirst($com_name);
			if(class_exists($class_name)){
				$obj = new $class_name();
				return $obj;
			}else{
				raiseError('No object: ' . $class_name);
			}
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		return false;
	}

	public function loadTemplate($params){
		//if(!$params){return false;}
		$app = Core::getApplication();
		//echo $name . ': ' . count($parts) .  '<br/>';
		//print_r($parts);exit;
		if(isset($this->_com) && $this->_com){
			$com=$this->_com;
		}else{
			$com = Application::$options->com;
		}
		if(isset($this->_view) && $this->_view){
			$view=$this->_view;
		}else{
			$view = Application::$options->view;
		}
		$task = Application::$options->task;
		if(is_array($params)){
			if(isset($params['com'])){
				$com = $params['com'];
			}
			if(isset($params['view'])){
				$view = $params['view'];
			}
			if(isset($params['task'])){
				$task = $params['task'];
			}
			$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
		}elseif($params){
			$task = $params;
			$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
		}else{
			if(isset($this->_com)){
				$com=$this->_com;
			}
			if(isset($this->_view)){
				$view=$this->_view;
			}
			if(isset($this->_task)){
				$task=$this->_task;
			}
			$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
			//echo $path;
		}
		$path .= $task . '.php';
		//echo $path.'<br/>';
		$buffer='';
		try{
			ob_start();
			//if(!$app->loadPHPFile($path)){
			if(!$this->loadPHPFile($path)){
				raiseError('File not found: ' . $path);
			}
			$buffer = ob_get_clean();
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		return $buffer;
	}
	
	public function _loadTemplate($name){
		if(!$name){return false;}
		$name = '_' . $name;
		$app = Core::getApplication();
		$com = Application::$options->com;
		$view = Application::$options->view;
		$task = Application::$options->task;
		$path = ROOT_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $view . DS . 'tmpl' . DS;
		//echo $path;
		$path .= $name . '.php';
		try{
			ob_start();
			if(!$app->loadPHPFile($path)){
				raiseError('File not found: ' . $path);
			}
			$buffer = ob_get_clean();
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		return $buffer;
	}
	
	public function assignRef($key, &$val){
		if (is_string($key) && substr($key, 0, 1) != '_'){
			$this->$key = &$val;
			return true;
		}

		return false;
	}
	public function display($tpl = null){
		$result = $this->loadTemplate($tpl);
		/*if ($result instanceof Exception){
			return $result;
		}*/

		echo $result;
	}
	
	public function get($property, $default = null)	{
		$method = 'get' . ucfirst($property);
		$model = $this->getModel($default);
		//if (method_exists($model, $method))
		$result = $model->$method();
		return $result;
	}

	public function secure(){
		$app = Core::getApplication();
		$app->secure();
	}
	
	public function getModel($name){
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
	
	public static function getHelper($name = '') {
		$helperClass = ucfirst($name) . 'Helper';
		//$helperClass = $classPrefix . ucfirst($name);
		$path = BASE_PATH . DS . 'components' . DS . Controller::$options['component'] . DS . 'helpers' ;
		if ($name!=""){
			$path = $path . DS . $name . '.php';
		}else{
			$path = $path . '.php';
		}
		//echo $helperClass . '<br />' . $path;
		if (!class_exists($helperClass)) {
			if (is_file($path)) {
				$app=Core::getApplication();
				$app->loadPHPFile($path);
			}
		}
		if(class_exists($helperClass)){
			$helper = new $helperClass();
			return $helper;
		}
		return false;
		
	}


	public function getPaginationList() {
		//$db = Core::getDBO();
		$list = Database::$pagination_list;
		if($list){
			return $list;
		}
		return false;
		
	}

}


?>