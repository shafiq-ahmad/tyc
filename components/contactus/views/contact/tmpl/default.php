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
//$user = Core::getUser()->getUser();	// prompt if user is not login
//var_dump($this->row);exit;




?>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>



<div class="site_contents">
<div class="signup_wrapper" style="width:100%;">
<form id="signup_form" method="POST" action="index.php?com=contactus&view=contact">
<input type="hidden" name="action" value="add" />
<legend><?php echo Localize::_('send_us_message'); ?></legend>
<div class="form-group">
<input type="text" class="form-control" name="full_name" placeholder="<?php echo Localize::_('full_name'); ?>">
</div>
<div class="form-group">
<input type="email" class="form-control" name="e_mail" placeholder="email@domain.com">
</div>
<div class="form-group">
<input type="phone" class="form-control" name="phone" placeholder="<?php echo Localize::_('phone'); ?>">
</div>
<div class="form-group custom_state_control">
<?php echo HtmlForm::htmlSelect($this->cities, 0, 'city_id');?>
</div>
<div class="form-group">
<input type="subject" class="form-control" name="subject" placeholder="<?php echo Localize::_('subject'); ?>" required>
</div>

<div class="form-group">
<textarea class="form-control" name="message" placeholder="<?php echo Localize::_('message'); ?>" rows="6"></textarea>
</div>
<div class="form-group">
<input type="submit" value="<?php echo Localize::_('send_message'); ?>" class="btn btn-md btn-primary float-right">
</div>
</form>
</div>
</div>






<script>
$(".cover_img").click(function(e){
	//e.preventDefault();
	var id = $(this).data('id');
	var media = $(this).data('media_id');
	//console.log(id + ' ' + media);
	$.post("index.php?com=contactus&view=contact",
		{action: "setCover",	id: id, media_id: media},
	function(data, status){
	console.log(status);
	alert('Cover Picture changed successfully');
	
	});
});




</script>