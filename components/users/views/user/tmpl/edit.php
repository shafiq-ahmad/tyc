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

$user = User::isLogin();

$country_id = 0;
//var_dump($user);exit;
$action='add';
$value=array();
$value['id']=0;
$value['file']='';
$value['srcset']='';
$value['full_name']='';
$value['user_name']='';
$value['e_mail']='';
$value['phone']='';
$value['address']='';

if($this->row){
	//var_dump($this->row);exit;
	$value=$this->row;
	//$country_id = $value['country'];
	$action='update';
}

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

<form id="frm_user" action="?com=users&view=profile" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="source" value="users" />
<div class="photo_details_wrapper row ">
<div class="user_photo col-sm-3">
<div class="cell col">
<img style="height:200px;width:100%;" src="<?php echo $value['file']; ?>" srcset="<?php echo $value['srcset']; ?>" alt="user" />
<label class="btn btn-info btn-flat hide" style="width:100%;"><input type="file" name="file" style="display:none; margin-top:1em;">Change your photo:</label></div>
</div>
<div class="profile_details col cell col-sm-9">
<label>Name:</label>
<input type="text" name="full_name" class="form-control custom_control_box" placeholder="Name.." value="<?php echo $value['full_name'];?>" autocomplete="off">
<input type="hidden" name="id" value="<?php echo $value['id']?>">
<label>Login:</label>
<input type="text" name="user_name" class="form-control custom_control_box" placeholder="Login.." value="<?= $value['user_name']?>"  autocomplete="off">
<label>Password:</label>
<input name="user_pass" type="password" class="form-control custom_control_box" placeholder="Change password" value="" >
<label>Country:</label>
<?php /* ?><select name="country" class="form-control custom_control_box">
<?php //HTML::edit_item('countries', $value['country'],'id','title') ?>
</select><?php */ ?>
<?php
	echo HtmlForm::htmlSelect($this->countries, $country_id, 'country');
?>
<label>Phone:</label>
<input type="text" name="phone" class="form-control custom_control_box" placeholder="Phone.."
 value="<?php echo $value['phone']?>">
<label>Email:</label>
<input type="email" name="e_mail" class="form-control custom_control_box" placeholder="Email.."  value="<?= $value['e_mail']?>">
<label>Address:</label>
<input name="address" class="form-control custom_control_box" value="<?= $value['address']?>" >
<center>
<a class="btn btn-danger btn-flat btn-sm" href="javascript::void();" onClick="window.history.go(-1)">Back</a>
<input type="submit" class="btn btn-success btn-flat btn-sm hide" value="Update Profile">
</center>
</div>
</div>
</form>

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

</div>
</div>