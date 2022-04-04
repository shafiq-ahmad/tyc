<?php
defined('_MEXEC') or die ('Restricted Access');


require_once "inc/_header_site.php";
?>
<div id="messages"><?php 
foreach($messages as $m){
	echo '<div>' . $m . '</div>';
}
?></div>
<section class="wrapper"> <!--main_wrapper_start-->
<section class="contents"> <!--main_content_start-->
<?php

echo $this->_com;

?>

</section><!--end of contents-->
</section><!--end of wrapper--><?php


require_once "inc/_footer_site.php";