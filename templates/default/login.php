<?php
defined('_MEXEC') or die ('Restricted Access');
$this->setMeta('<meta name="robots" content="nofollow" />');
require_once "inc/_header_site.php";

?>
<section class="wrapper">

<div id="messages"><?php 
if($messages){
	//var_dump($messages); 
	foreach($messages as $m){
		//echo '<div>' . $m . '</div>';
		//var_dump($m);
		echo $m;
	}
}

?></div>
</section><?php

echo $this->_com;



require_once "inc/_footer_site.php";