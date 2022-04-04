<?php
defined('_MEXEC') or die ('Restricted Access');


import('core.env');
import('core.application.component.model');
//import('core.application.component.view');
class Controller extends Mobject {
	
	private $db;
	private static $instance;
	private $default_view;
	private $message;
	private static $redirect = null;
	private $messageType;
	public static $buffer;
	
	public function display(){
		ob_start();
		if(!isset($this->view) || !$this->view){
			$this->view = $this->getView();
		}
		try{
			if(!is_object($this->view)){
				raiseError('View is not defined in Controller.display()');
			}
			$this->view->display();
			self::$buffer = ob_get_clean();
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		return self::$buffer;
	}
	
	public function secure(){
		$app = Core::getApplication();
		$app->secure();
	}
	
	public function executeForm($action) {
		//setLog('controller.executeForm','Test');
		//$app = Core::getApplication();
		if(!$action){return false;}
		if(!class_exists('View')){
			import('core.application.component.view');
		}
		$form_response = '';
		try{
			$view = new View();
			//setLog('executeForm');
			$com = Application::$options->com;
			$v = Application::$options->view;
			$m_name = $com . '.' . $v;
			$model = $view->getModel($m_name);
			//echo $m_name;exit;
			//echo get_class($model);exit;
			//var_dump($_POST);exit;
			if(isset($_POST) && !$this->data){
				$model->data=$_POST;
			}
			$view->rows = $model->$action();
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		$url = $this->getRedirect();
		if($url){
			$this->redirect($url);
		}
	}

	/*public function getModelz($name){
		if(!$name){return false;}
		$app = Core::getApplication();
		$parts = explode('.',$name);
		$num = count($parts);
		if($num==2){
			$com_name = $parts[0];
			$model_name = $parts[1];
			$path = BASE_PATH . DS . 'components' . DS . $com_name . DS . 'models' . DS . $model_name . '.php';
		}elseif($num==1){
			$model_name = $name;
			$path = BASE_PATH . DS . 'components' . DS . Application::$options->com . DS . 'models' . DS . $name . '.php';
		}
		try{
			if(!$app->loadPHPFile($file)){
				raiseError('File not found: ' . $file);
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
	}*/
	
	public function execute($task='display'){
		if (strpos($task, '.') !== false){
			$ar = array();
			$ar = explode('.', $task);
			$task = array_pop($ar);
		}
		$task = strtolower($task);
		$this->$task();
	}

	public function getView($name = '') {
		
		
		$app = Core::getApplication();
		$options = $app->getOptions();
		if(!$name){
			$name = $options->view;
		}
		$parts = explode('.',$name);
		$num = count($parts);
		
		
		
		/*$task = Request::getVar('task', '');
		if(!$com){
			$com = $options->com;
		}*/
		//$this->_task=$task;
		try{
		if($num==2){
			$com_name = $parts[0];
			$view_name = $parts[1];
			$file = BASE_PATH . DS . 'components' . DS . $com_name . DS . 'views' . DS . $view_name . DS . 'view.php';
		}elseif($num==1){
			$com_name = Application::$options->com;
			$view_name = $name;
			//var_dump($parts);exit;
			$file = BASE_PATH . DS . 'components' . DS . $com_name . DS . 'views' . DS . $view_name . DS . 'view.php';
		}/**/
		
		$this->_com=$com_name;
		$this->_view=$view_name;
			if(!$app->loadPHPFile($file)){
				raiseError('File not found: controller ' . $file);
			}
			$class_name = ucfirst($name) . 'View' . ucfirst($options->com);
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

	/*public function getView_old($name = '', $com = '', $layout='default') {
		$task = Request::getVar('task', '');
		$app = Core::getApplication();
		$options = $app->getOptions();
		if(!$com){
			$com = $options->com;
		}
		if(!$name){
			$name = $options->view;
		}
		//$file = BASE_PATH . DS . 'components' . DS . $com  . DS . 'views' . DS . $name . DS . $options->task . '.php';
		$file = BASE_PATH . DS . 'components' . DS . $com . DS . 'views' . DS . $name . DS . 'view.php';

		try{
			if(!$app->loadPHPFile($file)){
				raiseError('File not found: ' . $file);
			}
			$class_name = ucfirst($name) . 'View' . ucfirst($options->com);
			//echo $class_name;exit;
			if(class_exists($class_name)){
				$obj = new $class_name();
				return $obj;
			}else{
				raiseError('No object: ' . $class_name);
				return false;
			}
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
	}*/
	
	
}

