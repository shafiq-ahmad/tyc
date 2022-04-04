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

$user = Core::getUser()->getUser(true);

$country_id = 0;
//var_dump($user);exit;
$action='add';
if($user){
$country_id = $user['country'];
$value=$user;
$action='update';


//$user_details=$user->user_details($db->insert_prep($_SESSION['id']));
//foreach($user_details as $value) : 
/*echo "<pre>";
print_r($value); */

?>
<style>
.site_contents{width:100%;float:none;}
</style>
<div class="table-responsive">
<div class="site_contents" style="overflow:hidden; border:1px solid silver; background:#ECECEC">
<div class="user_profile">
<h3 style="font-weight:bold; text-shadow:1px 1px 1px silver"><?php echo $value['full_name'];?>
<button style="float:right;" type="button" class="btn btn-primary btn-sm float-right clear " data-toggle="modal" data-target="#changepwd"><?php echo Localize::_('change_password'); ?></button>
</h3>

<form id="frm_user" action="?com=users&view=profile" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<div class="photo_details_wrapper">
<div class="user_photo">
<img src="<?php echo $user['file']; ?>" srcset="<?php echo $user['srcset']; ?>" alt="user" />
<input type="hidden" name="existing_photo" value="<?= $value['file']?>" />
<label class="btn btn-info" style="width:100%;"><input type="file" name="file" style="display:none; margin-top:1em;" /><?php echo Localize::_('label_change_photo'); ?></label></div>
<div class="profile_details">
<label><?php echo Localize::_('label_name'); ?>:</label>
<input type="text" name="full_name" class="form-control custom_control_box" placeholder="<?php echo Localize::_('name_'); ?>" value="<?php echo $value['full_name'];?>">
<input type="hidden" name="id" value="<?php echo $value['id']?>">
<label><?php echo Localize::_('label_login'); ?></label>
<input type="text" class="form-control custom_control_box" placeholder="<?php echo Localize::_('login_'); ?>" value="<?= $value['user_name']?>" disabled>
<label><?php echo Localize::_('label_country'); ?></label>
<?php /* ?><select name="country" class="form-control custom_control_box">
<?php //HTML::edit_item('countries', $value['country'],'id','title') ?>
</select><?php */ ?>
<?php
	echo HtmlForm::htmlSelect($this->countries, $country_id, 'country');
?>
<label><?php echo Localize::_('lebel_phont'); ?></label>
<input type="text" name="phone" class="form-control custom_control_box" placeholder="<?php echo Localize::_('phone'); ?>"
 value="<?php echo $value['phone']?>">
<label><?php echo Localize::_('label_email'); ?></label>
<input type="email" name="e_mail" class="form-control custom_control_box" placeholder="<?php echo Localize::_('email'); ?>"  value="<?= $value['e_mail']?>">
<label><?php echo Localize::_('label_address'); ?></label>
<input name="address" class="form-control custom_control_box" value="<?= $value['address']?>" >
<center>
<a class="btn btn-danger" href="<?php //echo previous()?>"><?php echo Localize::_('back'); ?></a>
<input type="submit" name="update_user" class="btn btn-success" value="<?php echo Localize::_('update_profile'); ?>">
</center>
</div>
</div>
</form>

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="changepwd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background:#ECECEC; border:8px solid grey">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo Localize::_('change_the_password'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<div class="form-group">
<label class="control-label" style="font-size:.9em; text-shadow:1px 1px 1px white"><?php echo Localize::_('enter_new_password'); ?></label>
<input type="hidden" value="<?php echo $value['id'] ?>" name="id">
<input type="password" name="new_password" class="form-control" id="pwd">
     </div>
<div class="form-group">
<label class="control-label" style="font-size:.9em; text-shadow:1px 1px 1px white"><?php echo Localize::_('confirm_new_password'); ?></label>
     <input type="password" name="confirm_password" class="form-control" id="pwd2">
      </div>
<div class="notify" style="background:green; line-height:35px; text-indent:2em; color:white"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo Localize::_('close'); ?></button>
        <button type="button" class="btn btn-primary" onClick="update()"><?php echo Localize::_('update_password'); ?></button>
      </div>
    </div>
  </div>
</div>
</div>



<script>
function update()
{
	var user_id=$('input[name="id"]').val();
	var password=$('#pwd').val();
	var password2=$('#pwd2').val();
	if(!(password === password2)){
		alert('Passwords missmatched. Try again');
		return false;
	}else if((password.length < 3) && (password2.length < 3)){
		alert('Password must be atleast 3 letters long');
		return false;
	}
	
	$.ajax({
			url: '?com=users&view=profile',
			data: {password: password, action: 'change_password', id:user_id, new_password:password,confirm_password:password2 },
			type:'POST',
			success: function(data){
				var msg='<h3>Password successfully changed.';
				$('.notify').html(msg).fadeOut(10000);
			}
			});
}

function clear(){
	$('input[type="password"]').val('');
	$('.notify').empty();
}
</script>
<script>
$(function(){
	$('.clear').click(function(){
		clear();
		})
	})
</script>
<?php //endforeach; 
}
?>
</div>
</div>