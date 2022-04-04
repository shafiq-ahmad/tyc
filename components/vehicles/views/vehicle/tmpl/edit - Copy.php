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
$published=1;
$city_id=0;
$action='add';
if(isset($this->row['id'])){
	$id=$this->row['id'];
	$action='update';
	$title=$this->row['title'];
}



?>
<!-- Select2 
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>-->

<div class="site_contents">
<div class="upload_wrapper" style="width:100%; overflow:hidden; background:#F0F2F5; border:1px solid silver; padding:2em;">
<?php if(isset($_GET['id'])) {
	$sql="SELECT * FROM vehicles WHERE id={$_GET['id']}";
	$vehicle_details=$db->get_by_sqlRows($sql);
	foreach($vehicle_details as $value) { ?>
<form id="signup_form" method="POST" action="?com=vehicles&view=vehicle&task=edit<?php if($id) echo '&id=' . $id; ?>" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="source" value="vehicles" />
<style>
input,textarea option { font-size:.7em;}
</style>
<legend>
Update Your Vehicle Details and Media
</legend>
<div style="overflow:hidden;padding:10px 0;width:100%;">
<a href="?com=vehicles&view=user_vehicles" class="btn btn-warning btn-sm" style="float:right;">Back to inventory</a>
</div>
<div class="row">
<div class="col-md-4">
<div class="form-group">
<input type="title" class="form-control" name="title" placeholder="Title" value="<?php echo $value['title']?>">
</div>
<div class="form-group">
<input type="model" class="form-control" name="model" placeholder="Model" value="<?php echo $value['model']?>">
</div>
<div class="form-group">
<input type="price" class="form-control" name="price" placeholder="Price" value="<?php echo $value['price']?>">
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->makes, $value['make_id'], 'make_id','form-control',true);
?></div>
<div class="form-group">
<?php
echo HtmlForm::htmlSelect($this->transmissions, $value['transmission'], 'transmission','form-control');
?>
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->drives, $value['drive'], 'drive','form-control');
?>
</div>
</div>
<div class="col-md-4">
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->years, $value['year'], 'year','form-control');
?>
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->conditions, $value['vehicle_condition'], 'vehicle_condition','form-control');
?></div>
<div class="form-group">
<input type="text" class="form-control" name="mileage" placeholder="Mileage" value="<?php echo $value['mileage']?>">
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->fuels, $value['fuel_type'], 'fuel_type','form-control');
?>
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->engines, $value['engine'], 'engine','form-control');
?></div>
</div>
<div class="col-md-4">
<div class="form-group">
<input type="text" class="form-control" name="fuel_economy" placeholder="Fuel Economy" value="<?php echo $value['fuel_economy']?>">
</div>
<div class="form-group">
<input type="text" class="form-control" name="interior_color" placeholder="Interior Color" value="<?php echo $value['interior_color']?>">

</div>
<div class="form-group">
<input type="text" class="form-control" name="exterior_color" placeholder="Exterior Color" value="<?php echo $value['exterior_color']?>">
</div>
<div class="form-group">
<label class="btn btn-sm btn-info">
<input type="file" name="images[]" style="display:none; margin-top:1em;" multiple>
Upload Vehicle Images ( <?php echo count($this->images);?> / 20 )</label>
</div>
<input type="submit" class="btn btn-block btn-primary" value="Save Vehicle">
</div>
</div>
</form>
<div class="media-images"><div class="row"><?php
	foreach($this->images as $i){
		?><div class="img col-sm-3"><label><input type="radio" name="cover_img" data-id="<?php echo $value['id'];?>" data-media_id="<?php echo $i['id'];?>" class="cover_img" <?php
		if($value['image_id'] == $i['id']){
			echo 'checked';
		}
		?>> Cover Image</label><a href="#" class="del" data-id="<?php echo $i['id'];?>">X</a>
		<a href="<?php echo $i['img_pc'];?>"><img src="<?php
			echo $i['img_thumb'];
		?>" /></a></div><?php
	}
	

?></div></div>

<?php }
	}else{ ?>
<form id="signup_form" method="POST" action="?com=vehicles&view=vehicle&task=edit" enctype="multipart/form-data">
<style>
input,textarea option { font-size:.7em;}
</style>
<legend>
Upload Your Vehicle Details and Media
</legend>
<div class="row">
<div class="col-md-4">
<div class="form-group">
<input type="hidden" name="user_id" value="" />
<input type="hidden" name="id" value="<?php echo $user['id'];?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="source" value="vehicles" />
<input type="title" class="form-control" name="title" placeholder="Title">
</div>
<div class="form-group">
<input type="model" class="form-control" name="model" placeholder="Model">
</div>
<div class="form-group">
<input type="price" class="form-control" name="price" placeholder="Price">
</div>
<div class="form-group">
<?php
echo HtmlForm::htmlSelect($this->makes, 0, 'make_id','form-control',true);
?>
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->transmissions, 0, 'transmission','form-control');
?></div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->drives, 0, 'drive','form-control');
?></div>
</div>
<div class="col-md-4">
<div class="form-group">
<?php
echo HtmlForm::htmlSelect($this->years, 0, 'year','form-control');
?>
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->conditions, 0, 'vehicle_condition','form-control');
?></div>
<div class="form-group">
<input type="text" class="form-control" name="mileage" placeholder="Mileage">
</div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->fuels, 0, 'fuel_type','form-control');
?></div>
<div class="form-group"><?php
echo HtmlForm::htmlSelect($this->engines, 0, 'engine','form-control');
?></div>
</div>
<div class="col-md-4">
<div class="form-group">
<input type="text" class="form-control" name="fuel_economy" placeholder="Fuel Economy">
</div>
<div class="form-group">
<input type="text" class="form-control" name="interior_color" placeholder="Interior Color">

</div>
<div class="form-group">
<input type="text" class="form-control" name="exterior_color" placeholder="Exterior Color">
</div>
<div class="form-group">
<label class="btn btn-sm btn-info">
<input type="file" name="images[]" style="display:none; margin-top:1em;" multiple>
Upload Vehicle Images ( <?php echo count($this->images);?> / 020 )</label>
</div>
<input type="submit" class="btn btn-block btn-primary" value="Save Vehicle">
</div>
</div>
</form><?php
	}
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