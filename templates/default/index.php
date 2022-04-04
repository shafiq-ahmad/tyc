<?php
defined('_MEXEC') or die ('Restricted Access');

require_once "inc/_header_site.php";
?>
<section class="wrapper">
<div id="messages"><?php 
foreach($messages as $m){
	echo '<div>' . $m . '</div>';
}
?></div><?php


?></section><?php

echo $this->_com;


require_once "inc/_footer_site.php";