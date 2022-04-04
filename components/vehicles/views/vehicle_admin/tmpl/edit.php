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


?>
<!-- Select2 
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>-->

<div class="site_contents">
<div class="upload_wrapper" style="width:100%; overflow:hidden; background:#F0F2F5; border:1px solid silver; padding:2em;">
<?php 
//foreach($this->row as $value) { ?>
<form id="signup_form" method="POST" action="?com=vehicles&view=vehicle_admin&task=edit<?php if($id) echo '&id=' . $id; ?>" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="source" value="vehicles" />
<style>
input,textarea option { font-size:.7em;}
</style>
<legend>
<?php echo Localize::_('vehicle'); ?>
</legend>
<div class="status alert <?php echo $alert_class;?>"><?php
	echo Localize::_('status_') . ' ';
	echo Localize::_('vehicle_visible_' . $visibility);
	
?></div>
<div><?php
	if($visibility==4 && $admin_remarks){
		echo '<p class="alert alert-danger">' . $admin_remarks . '</p>';
	}
?></div>
<div class="row">
<div class="col-md-4">
<div class="form-group">
<input type="text" class="form-control" required name="title" placeholder="<?php echo Localize::_('title'); ?>" value="<?php echo $title?>" autocomplete="off">
</div>
<div class="form-group">
<input type="text" class="form-control" name="model" placeholder="<?php echo Localize::_('model'); ?>" value="<?php echo $model?>" autocomplete="off">
</div>
<div class="form-group">
<input type="number" class="form-control" required name="price" placeholder="<?php echo Localize::_('price'); ?>" value="<?php echo $price; ?>" autocomplete="off">
</div>
<div class="form-group"><select id="make_id" name="make_id" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->makes, $make_id);
?></select></div>
<div class="form-group"><select id="transmission" name="transmission" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->transmissions, $transmission);
?></select>
</div>
<div class="form-group"><select id="drive" name="drive" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->drives, $drive);
?></select>
</div>
</div>
<div class="col-md-4">
<div class="form-group"><select id="year" name="year" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->years, $year, true);
?></select>
</div>
<div class="form-group"><select id="vehicle_condition" name="vehicle_condition" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->conditions, $vehicle_condition, true);
?></select>
</div>
<div class="form-group">
<input type="number" class="form-control" required name="mileage" placeholder="<?php echo Localize::_('mileage'); ?>" value="<?php echo $mileage?>" autocomplete="off">
</div>
<div class="form-group"><select id="fuel_type" name="fuel_type" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->fuels, $fuel_type, true);
?></select>
</div>
<div class="form-group"><select id="engine" name="engine" class="form-control"><option value=""><?php echo Localize::_('select_'); ?></option><?php
echo HtmlForm::htmlSelectOptions($this->engines, $engine, true);
?></select>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<input type="number" class="form-control" required name="fuel_economy" placeholder="<?php echo Localize::_('fuel_economy'); ?>" value="<?php echo $fuel_economy ?>" autocomplete="off">
</div>
<div class="form-group">
<input type="text" class="form-control" name="interior_color" placeholder="<?php echo Localize::_('interior_color'); ?>" value="<?php echo $interior_color?>" autocomplete="off">

</div>
<div class="form-group">
<input type="text" class="form-control" name="exterior_color" placeholder="<?php echo Localize::_('exterior_color'); ?>" value="<?php echo $exterior_color?>" autocomplete="off">
</div>
</div>
</div>
<div class="row"><div class="col-sm-8"><div class="form-group">
<textarea name="admin_remarks" cols="15" rows="5"><?php
echo $admin_remarks;
?></textarea>
</div></div></div><hr/>
<div class="row">
<div class="col-sm-3">
<select name="visibility" class="form-control" required>
<option value="">Choose action..</option>
<option value="2">Approve</option>
<option value="4">Reject</option>

</select>
</div>
<div class="col-sm-3">
<input type="submit" class="btn btn-block btn-primary" value="<?php echo Localize::_('save_vehicle'); ?>">
</div>
<div class="col-sm-3">
<a href="?com=vehicles&view=vehicles_admin" class="btn btn-warning"><?php echo Localize::_('back'); ?></a>
</div>
</div>
</form>

<h3><?php echo Localize::_('images') . ' ' . count($this->images);?> / 20 </h3>
<div class="media-images"><div class="row"><?php
	foreach($this->images as $i){
		?><div class="img col-sm-3">
		<img src="<?php
			echo $i['img_pc'];
		?>" /></div><?php
	}
	

?></div></div><?php 
//}
	

?>
</div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<style>
textarea{padding:20px;width:100%;}
img{max-width:100%;}
.media-images img {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.media-images img:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img;
$('.media-images img').click(function(e){
	//img=this;
	modal.style.display = "block";
	modalImg.src = this.src;
	//var captionText = document.getElementById("caption");
	//captionText.innerHTML = this.alt;
})
var modalImg = document.getElementById("img01");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>