<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/
defined('_MEXEC') or die ('Restricted Access');
$app = Core::getApplication();
$db=Core::getDBO();

//$user = $this->user;
$id=null;
if(isset($_GET['id'])){
	$id=$_GET['id'];
}elseif(isset($_POST['id'])){
	$id = $_POST['id'];
}

?></script>
<script type="text/javascript">
$(function(){
$('span.row_view').click(function(){
	$('.grid_view_display').hide();
	$('.row_view_display').show(300);
	});
$('span.grid_view').click(function(){
	$('.row_view_display').hide();
	$('.grid_view_display').show(300);
	});
});
</script>
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/assets/css/nivo-slider.css" type="text/css"/>
<script src="templates/<?php echo $app->getTemplate();?>/assets/js/jquery_2.2.4_jquery.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/assets/js/jquery.nivo.slider.js"></script>
<section class="contents">
<div class="tab_nav_wrapper">
<?php if(isset($id) && $id) { ?>
<div class="slider-wrapper-vehicle theme-default">
<div id="vehilce_slider" class="nivoSlider">
<?php 

$sql_media="SELECT m.* FROM vehicles_image_media AS vim
INNER JOIN media AS m ON (vim.media_id=m.id)

WHERE vim.vehicle_id={$id}";
$media_details=$db->get_by_sqlRows($sql_media);
foreach($media_details as $detail): ?><img src="<?php

echo $detail['img_pc']?>"  data-thumb="<?php echo $detail['img_thumb']?>" alt="" />
<?php endforeach; ?>
</div>
</div>
<?php } ?>
<div class="tab_navigation">
<ul class="nav nav-tabs custom_nav_tabs">
<li class="nav-item">
<a href="#some1" class="nav-link active" role="tab" data-toggle="tab"><?php echo Localize::_('features_options');?></a>
</li>
<li class="nav-item">
<a href="#some2" class="nav-link" role="tab" data-toggle="tab"><?php echo Localize::_('location');?></a>
</li>
<li class="nav-item">
<a href="#some3" class="nav-link hide" role="tab" data-toggle="tab"><?php echo Localize::_('contact');?></a>
</li>
</ul>
</div>
<div class="tab-content tab_navigation_content">
<div role="tabpanel" class="tab-pane active" id="some1">
<?php //echo $vehicle['features']; ?>
</div>
<div role="tabpanel" class="tab-pane" id="some2">
<?php //echo $vehicle['location']; // a map ?>
</div>
<div role="tabpanel" class="tab-pane hide" id="some3">
<?php //echo $vehicle['contact']; ?>
</div>
</div>
</div><!--tab nav wrapper ends-->
<aside class="vehicle_short_details">
<div class="prices">
<center>
<?php
if($id){
$veh_sql="SELECT * FROM vehicles WHERE id={$id}";
$veh=$db->get_by_sqlRows($veh_sql);
foreach($veh as $veh_value) :?>
<span class="price_title"><?php echo Localize::_('our_prices');?></span>
<span class="inner_prices">AED 25,000</span>
</center>
</div>
<div class="prices">
<center>
<span class="price_title"><?php echo Localize::_('msrp');?></span> 
<span class="inner_prices">AED 17,000</span>
</center>
</div>
<div class="clearfix"></div>
<span class="instant_savings"><?php echo Localize::_('instant_savings');?>: AED 3000</span>
<aside class="single_vehicle_detail_params">
<h3><?php echo Localize::_('vehicle_details');?></h3>
<ul>
<li><span class="param"><?php echo Localize::_('seller');?></span><span class="span_detail"><a href="<?= 'index.php?com=users&view=public_profile&seller=' . $veh_value['user_id']?>"><?php echo Localize::_('profile');?></a></span></li>
<li><span class="param"><?php echo Localize::_('body');?></span><span class="span_detail"><?= $veh_value['title']?></span></li>
<li><span class="param"><?php echo Localize::_('mileage');?></span><span class="span_detail"><?= $veh_value['mileage']?></span></li>
<li><span class="param"><?php echo Localize::_('fuel_type');?></span><span class="span_detail">
<?php
echo HtmlForm::htmlSelect($this->fuels, $veh_value['fuel_type'], 'fuel','form-control',false,false,true); //return selected text only
?></span></li>
<li><span class="param"><?php echo Localize::_('engine');?></span><span class="span_detail"><?php
echo HtmlForm::htmlSelect($this->engines, $veh_value['engine'], 'engine','form-control',false,false,true); //return selected text only
?></span></li>
<li><span class="param"><?php echo Localize::_('year');?></span><span class="span_detail"><?php
echo HtmlForm::htmlSelect($this->years, $veh_value['year'], 'year','form-control',false,false,true); //return selected text only
?></span></li>
<li><span class="param"><?php echo Localize::_('transmission');?></span><span class="span_detail"><?php
echo HtmlForm::htmlSelect($this->transmissions, $veh_value['transmission'], 'transmission','form-control',false,false,true); //return selected text only
?></span></li>
<li><span class="param"><?php echo Localize::_('drive');?></span><span class="span_detail"><?php
echo HtmlForm::htmlSelect($this->drives, $veh_value['drive'], 'drive','form-control',false,false,true); //return selected text only
?></span></li>
<li><span class="param"><?php echo Localize::_('fuel_economy');?></span><span class="span_detail">
<?= $veh_value['mileage']?></span></li>
<li><span class="param"><?php echo Localize::_('exterior_color');?></span><span class="span_detail"><?= $veh_value['exterior_color']?></span></li>
<li><span class="param"><?php echo Localize::_('interior_color');?></span><span class="span_detail"><?= $veh_value['interior_color']?></span></li>
</ul>
<?php endforeach;
}
?>
</aside>
</aside></section>
<script type="text/javascript">
    $(window).load(function() {
    $('#vehilce_slider').nivoSlider({
    effect: 'fade',               // Specify sets like: 'fold,fade,sliceDown',
    slices: 15,                     // For slice animations
    boxCols: 14,                     // For box animations
    boxRows: 16,                     // For box animations
    animSpeed: 50,                 // Slide transition speed
    pauseTime: 4500,                // How long each slide will show
    startSlide: 0,                  // Set starting Slide (0 index)
    directionNav: true,             // Next & Prev navigation
    controlNav: true,               // 1,2,3... navigation
    controlNavThumbs:true,        // Use thumbnails for Control Nav
    pauseOnHover: true,             // Stop animation while hovering
    manualAdvance: true,           // Force manual transitions
    prevText: 'Prev',               // Prev directionNav text
    nextText: 'Next',               // Next directionNav text
    randomStart: false,             // Start on a random slide
    beforeChange: function(){},     // Triggers before a slide transition
    afterChange: function(){},      // Triggers after a slide transition
    slideshowEnd: function(){},     // Triggers after all slides have been shown
    lastSlide: function(){},        // Triggers when last slide is shown
    afterLoad: function(){}         // Triggers when slider has loaded
});
});
    </script>