<?php
defined('_MEXEC') or die ('Restricted Access');


require_once "inc/_header_site.php";
?>
<div class="slider_search"><?php
echo $this->showModule('slider');
echo $this->showModule('shipping_calculator');
$m = new View();
$model = $m->getModel('vehicles.vehicles');
$makes=$model->getMakes();
$transmissions=$model->getTransmissions();
$drives=$model->getDriveTypes();
$years=$model->getYears();
$conditions=$model->getConditionTypes();


?></div><?php  ?>
<section class="contents">
<aside class="search_params left_sidebar">
<form action="index.php?com=vehicles&view=vehicles" method="GET">
<input type="hidden" name="com" value="vehicles" />
<input type="hidden" name="view" value="vehicles" />

<div class="btn-group btn-group-justified">
<i class="fa fa-search"> </i><input type="submit" class="btn btn-primary btn-block" value="Search..."/>
</div>
<div class="main_left_search">
<div class="used_new">
<h4><?php echo Localize::_('condition');?></h4>
<?php
foreach($conditions as $v):?>
<div class="checkbox">
<label><input type="checkbox" name="<?php echo $v['title'];?>" value="<?php echo $v['id']?>">
<?php echo Localize::_($v['title']);?></label>
</div><?php
endforeach;
?>

</div>
<div class="makes">
<h4><?php echo Localize::_('manufacturers');?></h4><?php
$sel_make=null;
if(isset($_GET['make_id'])){
	$sel_make = $_GET['make_id'];
}
echo HtmlForm::htmlSelect($makes, $sel_make, 'make_id', 'form-control', true);


?></div>
<div class="year used_new">
<h4><?php echo Localize::_('year');?></h4><?php
$sel_year=null;
if(isset($_GET['year'])){
	$sel_year = $_GET['year'];
}
echo HtmlForm::htmlSelect($years, $sel_year, 'make_id', 'form-control', true);


?></div>
<div class="price_range_div">
  <h4><?php echo Localize::_('price_range');?></h4>
    <input type="range" min="550" max="75000" id="min_range" class="price_range" name="min_price" value="550" >
    <input type="range" min="550" max="75000" id="max_range" class="price_range" name="max_price" value="75000" >
    <label class="min_price" id="min_price">0</label>
    <label class="max_price" id="max_price">0</label>
    </div>
	
	<script>
var slider1 = document.getElementById("min_range");
var output = document.getElementById("min_price");
output.innerHTML = slider1.value;

slider1.oninput = function() {
  output.innerHTML = this.value;
}
var slider2 = document.getElementById("max_range");
var output2 = document.getElementById("max_price");
output2.innerHTML = slider2.value;

slider2.oninput = function() {
  output2.innerHTML = this.value;
}
</script>
<div class="clearfix"></div>
<div class="transmission_div used_new">
<h4><?php echo Localize::_('transmission');?></h4><?php
if($transmissions){
foreach($transmissions as $v){?>
<div class="checkbox">
<label><input type="checkbox" name="<?php echo $v['title']?>" value="<?php echo $v['id']?>"><?php echo Localize::_($v['title']);?></label>
</div>
<?php
}
}
?>

 </div>
<div class="drive_type used_new">
<h4><?php echo Localize::_('drive');?></h4><?php
foreach($drives as $v):?>
<div class="checkbox">
<label><input type="checkbox" name="<?php echo $v['title'];?>" value="<?php echo $v['id']?>">
<?php echo Localize::_($v['title']);?></label>
</div><?php
endforeach;
?></div>
</div>
<div class="btn-group btn-group-justified">
<input type="submit" class="btn btn-primary btn-block" value="Search..."/>
</div>
</form>
</aside>

<div class="site_contents">
<div id="messages"><?php 
foreach($messages as $m){
	echo '<div>' . $m . '</div>';
}
?></div><?php
echo $this->showModule('new_vehicles'); 
echo $this->showModule('used_vehicles');
echo $this->showModule('spare_parts');
echo $this->_com;
?><div class="small_menu">
<?php /*?><center>
<ul>
<li><a href="#"><img src="templates/<?php echo $this->getTemplate();?>/assets/images/me1.jpg"></a></li>
<li><a href="#"><img src="templates/<?php echo $this->getTemplate();?>/assets/images/me2.jpg"></a></li>
</ul>
</center><?php */?>
</div><!-- end of two small menus-->
<?php
echo $this->showModule('manufacturers');
?>


</div>
</section><!--end of contents-->
<section class="wrapper">
<?php


?></section><?php

//echo $this->_com;

?><?php


require_once "inc/_footer_site.php";