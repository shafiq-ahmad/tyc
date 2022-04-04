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

?>
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

<div class="form-row">
<input type="submit" class="btn btn-block btn-primary" value="<?php echo Localize::_('save_vehicle'); ?>">
</div>
</div>
</div>
</form>
<?php 
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