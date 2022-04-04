<?php
defined('_MEXEC') or die ('Restricted Access');
//Get time zone from user profile    ------   date('Y-m-d H:i:s');
date_default_timezone_set('Asia/Karachi');
// System Check

//if(!class_exists('Controller')){import('core.application.component.controller');}
//if(!class_exists('Model')){import('core.application.component.model');}
//if(!class_exists('View')){import('core.application.component.view');}

class Application extends Mobject{
	public static $instance_site;
	public static $instance_admin;
	public static $options, $template,$form_response;
	private static $php_file_list = array();
	private static $modules = array();
	public $user, $debug=false, $u, $_com, $_script=array(), $_style=array(), $_scripts = array(), $_styles = array(), $_title='', $_meta='';
	public $output='';
	
	public function __construct(){
		if(isset($_GET['logout']) && $_GET['logout']==1){
			$this->logout();
		}
		$this->loadOptions();
		if(!isset(self::$options->com)){
			self::$options->com = "home";
		}
		if(!isset(self::$options->view)){
			self::$options->view = self::$options->com;
		}
		if(!isset(self::$options->task)){
			self::$options->task = 'default';
		}
		if(!isset(self::$options->tmpl)){
			self::$options->tmpl = 'index';
		}
		if(!isset(self::$options->menu)){
			self::$options->menu = 0;
		}
		if(!isset(self::$options->lang)){
			self::$options->lang = 'en';
		}
		self::$options->action = '';	//For form or model actions
		if(isset($_POST['action']) && $_POST['action']){
			self::$options->action=$_POST['action'];
			
		}
		//$this->user=Core::getUser(false);
		$this->loadModules();
	}
	
	public function loadOptions() {
		self::$options = new stdClass(); /*Defining stdClass*/
		$get = $_GET;
		foreach ($get as $key=>$value){
			$this->setOption($key, $value);
		}
	}

	public function getOptions() {
		return self::$options;
	}

	public function getOption($name, $default=null) {
		if(isset(self::$options->$name)){
			return self::$options->$name;
		}
		return $default;
	}
	public function setOption($key, $value=null) {
		//$old = self::$options->$key;
		self::$options->$key = $value;
		//return ;
	}

	public function setMeta($txt) {
		$this->_meta= $this->_meta . "\n" . $txt;
	}

	public function getMeta() {
		return $this->_meta;
	}

	public function setScript($txt, $loc='footer') {
		if(!isset($this->_script[$loc])){
			$this->_script[$loc]='';
		}
		$this->_script[$loc]= $this->_script[$loc] . "\n" . $txt;
	}

	public function getScript($loc='footer') {
		if(isset($this->_script[$loc]) && $this->_script[$loc]){
			return '<script type="text/javascript">' . $this->_script[$loc] . '</script>';
		}
		return '';
	}
	
	public function setStyle($txt, $loc='header') {
		if(!isset($this->_style[$loc])){
			$this->_style[$loc]='';
		}
		$this->_style[$loc]= $this->_style[$loc] . "\n" . $txt;
	}

	public function getStyle($loc = 'header') {
		if(isset($this->_script[$loc]) && $this->_script[$loc]){
			return '<style type="text/css">' . $this->_script[$loc] . '</style>';
		}
		return '';
	}
	
	public function getHead() {
		$result='';
		$result .= $this->getMeta();
		$result .= $this->getScript('header');
		$result .= $this->getStyle('header');
		return $result;
	}

	public function getFoot() {
		$result='';
		$result .= $this->getScript('footer');
		$result .= $this->getStyle('footer');
		return $result;
	}


	public function setTitle($txt, $default=null) {
		$this->_title= $txt . '';
		return $this->_title;
	}

	public function getTitle() {
		if($this->_title){
			return $this->_title;
		}
		return 'webapplics.com';
	}


	public function logout(){
		$url = $this->getURI('last');
		/*session_unset();
		session_destroy();
		session_start();*/
		//unset($_SESSION[_CLIENT]);
		//echo _CLIENT . '<br>';
		if(isset($_SESSION[_CLIENT])){
			unset($_SESSION[_CLIENT]);
		}
		if(isset($_COOKIE["remember_me"])){
			setcookie ("remember_me","",0,'/');
		}
		if(isset($_COOKIE["username"])){
			setcookie ("username","",0,'/');
		}
		if(isset($_COOKIE["password"])){
			setcookie ("password","",0,'/');
		}
		$this->saveURI($url);
		$url_usr = "index.php";
		$this->redirect($url_usr);
	}

	public static function getInstance(){
		if (_CLIENT=='admin'){
			if (isset(self::$instance_admin)){
				return self::$instance_admin;
			}else{
				self::$instance_admin = new Application();
			}
			return self::$instance_admin;
		}else{
			if (isset(self::$instance_site)){
				return self::$instance_site;
			}else{
				self::$instance_site = new Application();
			}
			return self::$instance_site;
		}
	}

	public function secure(){
		$com = self::$options->com;
		$view = self::$options->view;
		$com_view = $com . '.' . $view;
		//if($com != 'user' && $view != 'login'){
		if($com_view != 'users.login'){
			$this->u = Core::getUser()->getUser();
		}
		$this->full_name = '';
		$this->branch_title = '';
		$this->branch_address = '';
		if(isset($this->u['full_name']) && $this->u['full_name']){
			$this->full_name = $this->u['full_name'];
		}
		if(!$this->u){
			if($com_view != 'users.login'){
				$url = '?com=users&view=login';
				$this->redirect($url);
			}
		}
		
	}
	
	public function render($secure = false){
		if($secure || _CLIENT=='admin'){
			$this->secure();
		}
		ob_start();
		$com =$this->loadCom();
		//var_dump($com);exit;
		if($com){
			$this->_com = Controller::$buffer;
			
			//if(self::$options->action){
				//$this->_com=$com->executeForm(self::$options->action);
				$com->executeForm(self::$options->action);
			//}
			$this->display(self::$options->tmpl);
			$this->output = ob_get_clean();
			//setLog('app.render','Test');
		}else{
			setLog("Couldn't load component, or Controller class", "Error");
			return false;
		}
	}

	public function getActiveMenu(){
		//in route first value must be a menu
		//is set menu then return it.
		return 0;
	}

/**
	Load all module in modules array when app loading
	In template use another function just to show that loaded modules. and more controll that a module can be unset programatically
*/
	public function loadModules(){
		$opt = $this->getOptions();
		$db=Core::getDBO();
		$sql="SELECT * FROM module_views AS mv ";
		$sql.="INNER JOIN modules AS m ON (m.name=mv.module) ";
		$sql.="WHERE ";
		$sql.="m.published =1 AND ";
		$sql.="(mv.menu=0 OR mv.menu ={$opt->menu}) AND ";
		$sql.="(mv.com='*' OR mv.com ='{$opt->com}') AND ";
		$sql.="(mv.view='*' OR mv.view ='{$opt->view}') AND ";
		$sql.="(mv.task='*' OR mv.task ='{$opt->task}') ";
		//$sql.="position='*' OR position ='{$position}' "; //need to load all position and show only those which required
		//$sql.="options='' OR options ='{$options}' ";
		
		$modules=$db->get_by_sqlRows($sql); 
		foreach($modules as $m){
			$this->loadModule($m['name'], $m['position']);
		}
		//var_dump($modules);exit;
	}

	public function loadModule($module,$pos='all'){
		if(!$module){return false;}
		if(isset(self::$modules[$pos][$module])){
			return self::$modules[$pos][$module];
		}
		$file = ROOT_PATH . DS . 'modules' . DS . $module . DS . $module . '.php';
		//if(file_exists($file) || $this->debug){
			ob_start();
		try{
			if(!$this->loadPHPFile($file)){
				raiseError('File not found: ' . $file);
			}
			self::$modules[$pos][$module] = ob_get_clean();
			return self::$modules[$pos][$module];
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		//}
		return false;
	}

	public function showModule($module,$pos='all'){
		//return false;
		if(!$module){return false;}
		if(isset(self::$modules[$pos][$module]) || isset(self::$modules['all'][$module])){
			return self::$modules[$pos][$module];
		}
		return false;
	}

	public function getURI($type="current"){
		if(isset($_SESSION[_CLIENT]['url'][$type])){
			return $_SESSION[_CLIENT]['url'][$type];
		}
		return false;
	}
	
	public function saveURI($url=''){
		$last='';
		//print_r($_SESSION['url']);
		if(isset($_SESSION[_CLIENT]['url']['last'])){
			$last = $_SESSION[_CLIENT]['url']['last'];
		}
		$current='';
		if(isset($_SESSION[_CLIENT]['url']['current'])){
			$current = $_SESSION[_CLIENT]['url']['current'];
		}
		if(!$url){
			$uri = explode('?',$_SERVER['REQUEST_URI']);
			$url = '?' . array_pop($uri);
			if($url=='?com=users&view=login'){
				return false;
			}
			if($current){
				if($url != $last){
					$_SESSION[_CLIENT]['url']['last'] = $_SESSION[_CLIENT]['url']['current'];
				}
			}
		}
		if($url=='?com=users&view=login'){
			return false;
		}
		$_SESSION[_CLIENT]['url']['current'] = $url;
		//print_r($_SESSION[_CLIENT]['url']);
		return $url;
	}

	public function loadCom(){
		$file = ROOT_PATH . DS . 'components' . DS . self::$options->com . DS . self::$options->com . '.php';
		try{
			if(!$this->loadPHPFile($file)){
				raiseError('File not found: ' . $file);
			}
			//setLog('app.loadCom: ' . $file,'Test');
			$c_name = 'Controller' . ucfirst(self::$options->com);
			if(class_exists($c_name)){
				$controller = new $c_name();
				return $controller;
			}else{
				raiseError('No object: ' . $c_name);
				return false;
			}
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
	}
	
	public function getTemplate(){
		if(!self::$template){
			if(isset($this->u['default_template'])){
				self::$template = $this->u['default_template'];
			}else{
				self::$template = 'default';
			}
		}
		//load class
		return self::$template;
	}

	public function setTmpl($tmpl){
		self::$options->tmpl = $tmpl;
	}

	public function getTmpl(){
		if(isset(self::$options->tmpl) && self::$options->tmpl){
			return self::$options->tmpl;
		}
		return 'index';
	}

	public function display($tmpl){
		//setLog('app.display','Test');
		$_template = $this->getTemplate();
		$file = ROOT_PATH . DS . 'templates' . DS . $_template . DS . $tmpl . '.php';
		try{
			if(!$this->loadPHPFile($file)){
				raiseError('File not found: ' . $file);
			}
		}catch (Exception $e){
			setLog($e->getMessage(),'Error');
		}
		//load class
	}

	
	
}

