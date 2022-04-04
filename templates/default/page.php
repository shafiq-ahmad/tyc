<?php
defined('_MEXEC') or die ('Restricted Access');

require_once "inc/_header_site.php";
?>
<div id="messages"><?php 
foreach($messages as $m){
	echo '<div>' . $m . '</div>';
}
?></div>
<section class="contents"> <!--main_content_start-->
<aside class="search_params left_sidebar"><?php
	echo $this->showModule('sidebar');
	//echo $this->showModule('newsletter');
?></aside>
<?php

echo $this->_com;

?>

</section><!--end of contents--><?php


require_once "inc/_footer_site.php";