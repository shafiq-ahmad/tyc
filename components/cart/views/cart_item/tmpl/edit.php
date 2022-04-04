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


$app=Core::getApplication();
$db = Core::getDBO();
$user = Core::getUser()->getUser();	// prompt if user is not login
//var_dump($this->row);exit;
$id=0;
$title='';
$model=null;
$price=null;
$make_id=null;
$transmission=null;
$drive=null;
$vehicle_condition=null;
$year=null;
$fuel_type=null;
$engine=null;
$fuel_economy=null;
$mileage=null;
$fuel_type=null;
$interior_color=null;
$exterior_color=null;
$visibility=null;
$image_id=null;
$admin_remarks=null;
$action='add';
$alert_class='';
$readonly='';
$disabled='';


if(isset($this->row['id'])){
	$id=$this->row['id'];
	$action='update';
	$title=$this->row['title'];
	$model=$this->row['model'];
	$price=$this->row['price'];
	$make_id=$this->row['make_id'];
	$transmission=$this->row['transmission'];
	$drive=$this->row['drive'];
	$vehicle_condition=$this->row['vehicle_condition'];
	$year=$this->row['year'];
	$fuel_type=$this->row['fuel_type'];
	$engine=$this->row['engine'];
	$fuel_economy=$this->row['fuel_economy'];
	$mileage=$this->row['mileage'];
	$fuel_type=$this->row['fuel_type'];
	$interior_color=$this->row['interior_color'];
	$exterior_color=$this->row['exterior_color'];
	$visibility=$this->row['visibility'];
	$image_id=$this->row['image_id'];
	$admin_remarks=$this->row['admin_remarks'];
}

if($visibility==1 || $visibility==2 || $visibility==3){
	$readonly='readonly';
	$disabled='disabled';
}

if($visibility==1){
	$alert_class='alert-success';
}
if($visibility==2){
	$alert_class='alert-danger';
}
if($visibility==3){
	$alert_class='alert-info';
}
if($visibility==4){
	$alert_class='alert-warning';
}


?>
<!-- Select2 
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>-->

<div class="site_contents">
<div class="upload_wrapper" style="width:100%; overflow:hidden; background:#F0F2F5; border:1px solid silver; padding:2em;">
<?php 
//foreach($this->row as $value) { ?>
<form id="signup_form" method="POST" action="?com=vehicles&view=vehicle&task=edit<?php if($id) echo '&id=' . $id; ?>" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="source" value="vehicles" />
<style>
input,textarea option { font-size:.7em;}
</style>
<legend>
<?php echo Localize::_('update_vehicle_details'); ?>
</legend>
<div class="status alert <?php echo $alert_class;?>"><?php
	echo Localize::_('status_') . ' ';
	echo Localize::_('vehicle_visible_' . $visibility) . ' ';
	echo '<a href="javascript:void(0);" data-toggle="popover" data-trigger="hover" title="Message" data-content=" ' . Localize::_('vehicle_visible_notes_' . $visibility) . '">' . Localize::_('read_more') . '</a>';
	
?></div>
<div><?php
	if($visibility==4 && $admin_remarks){
		echo '<p class="alert alert-danger">' . $admin_remarks . '</p>';
	}
?></div>
<div style="overflow:hidden;padding:10px 0;width:100%;">
<a href="?com=vehicles&view=user_vehicles" class="btn btn-warning btn-sm" style="float:right;"><?php echo Localize::_('back_to_inventory'); ?></a>
</div>
<div class="row">
<div class="col-md-4">
<div class="form-group">
<input type="text" class="form-control" required name="title" placeholder="<?php echo Localize::_('title'); ?>" value="<?php echo $title?>" autocomplete="off" <?php echo $disabled;?>>
</div>
<div class="form-group">
<input type="text" class="form-control" name="model" placeholder="<?php echo Localize::_('model'); ?>" value="<?php echo $model?>" autocomplete="off" <?php echo $disabled;?>>
</div>
<div class="form-group">
<input type="number" class="form-control" required name="price" placeholder="<?php echo Localize::_('price'); ?>" value="<?php echo $price; ?>" autocomplete="off">
</div>
<div class="form-group"><select id="make_id" name="make_id" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->makes, $make_id, true);
?></select></div>
<div class="form-group"><select id="transmission" name="transmission" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->transmissions, $transmission, true);
?></select>
</div>
<div class="form-group"><select id="drive" name="drive" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->drives, $drive, true);
?></select>
</div>
</div>
<div class="col-md-4">
<div class="form-group"><select id="year" name="year" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->years, $year, true);
?></select>
</div>
<div class="form-group"><select id="vehicle_condition" name="vehicle_condition" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->conditions, $vehicle_condition, true);
?></select>
</div>
<div class="form-group">
<input type="number" class="form-control" required name="mileage" placeholder="<?php echo Localize::_('mileage'); ?>" value="<?php echo $mileage?>" autocomplete="off">
</div>
<div class="form-group"><select id="fuel_type" name="fuel_type" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->fuels, $fuel_type, true);
?></select>
</div>
<div class="form-group"><select id="engine" name="engine" class="form-control" <?php echo $disabled;?>><?php if(!$disabled){?><option value=""><?php echo Localize::_('select_'); ?></option><?php } 
echo HtmlForm::htmlSelectOptions($this->engines, $engine, true);
?></select>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<input type="number" class="form-control" required name="fuel_economy" placeholder="<?php echo Localize::_('fuel_economy'); ?>" value="<?php echo $fuel_economy ?>" autocomplete="off">
</div>
<div class="form-group">
<input type="text" class="form-control" name="interior_color" <?php echo $disabled;?> placeholder="<?php echo Localize::_('interior_color'); ?>" value="<?php echo $interior_color?>" autocomplete="off">

</div>
<div class="form-group">
<input type="text" class="form-control" name="exterior_color" <?php echo $disabled;?> placeholder="<?php echo Localize::_('exterior_color'); ?>" value="<?php echo $exterior_color?>" autocomplete="off">
</div>
<div class="form-group"><?php
	if(!$disabled){
?><label class="checkbox-inline"><input name="finalize" type="checkbox" checked><?php echo Localize::_('vehicle_finalize'); ?></label>
<p style="font-size:80%;">
<?php echo Localize::_("vehicle_finalize_procede"); ?>
</p>
<?php } ?>
	
</div>
<div class="form-group">
<label class="btn btn-sm btn-block btn-info" <?php echo $disabled;?>>
<input type="file" name="images[]" style="display:none; margin-top:1em;" multiple <?php echo $disabled;?> >
<?php echo Localize::_('upload_vehicle_images') . ' ' . count($this->images);?> / 20 </label>
</div>
<div class="form-row">
<input type="submit" class="btn btn-block btn-primary" value="<?php echo Localize::_('save_vehicle'); ?>">
</div>
</div>
</div>
</form>
<div class="media-images"><div class="row"><?php
	foreach($this->images as $i){
		?><div class="img col-sm-3"><label><input type="radio" name="cover_img" data-id="<?php echo $id;?>" data-media_id="<?php echo $i['id'];?>" class="cover_img" <?php
		if($image_id == $i['id']){
			echo 'checked';
		}
		?>> <?php echo Localize::_('cover_image'); ?></label><?php if(!$disabled){ ?><a href="#" class="del" data-id="<?php echo $i['id'];?>">X</a><?php } ?>
		<a href="<?php echo $i['img_pc'];?>"><img src="<?php
			echo $i['img_thumb'];
		?>" /></a></div><?php
	}
	

?></div></div><?php 
//}
	

?>
</div>
</div>
<script>
$(".cover_img").click(function(e){
	//e.preventDefault();
	var id = $(this).data('id');
	var media = $(this).data('media_id');
	//console.log(id + ' ' + media);
	$.post("index.php?com=vehicles&view=vehicle&task=edit<?php echo '&id=' . $id ?>",
		{action: "setCover",	id: id, media_id: media},
	function(data, status){
	console.log(status);
	alert('Cover Picture changed successfully');
	
	});
});


$(".del").click(function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var img = $(this).closest('.img');
	var r = confirm("Please confirm deletion! this action might not be reverse.");
	if (r != true){
		return false;
	}
	$.post("index.php?com=vehicles&view=vehicle&task=edit<?php echo '&id=' . $id ?>",
		{action: "removeImage",	id: id},
	function(data, status){
	//console.log(data);
	console.log(status);
	$(img).remove();
	
	});
});


</script>