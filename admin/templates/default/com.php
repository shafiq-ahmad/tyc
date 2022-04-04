<?php
//$pa =  $user->pageAccess(12);
$u=array();
if(self::$options->com != 'user' && self::$options->view != 'login'){
	$u=$this->user->getUser();
}
echo $this->loadCom()->display();

