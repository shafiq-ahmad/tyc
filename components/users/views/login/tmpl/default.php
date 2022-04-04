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

?>

<div class="table-responsive">
<div class="signup_wrapper">
<form id="signin_form" action="?com=users&view=login" method="post">
<legend>
<?php echo Localize::_('sign_in'); ?>
</legend>

<div class="form-group">
<input type="text" class="form-control" name="login_name" placeholder="<?php echo Localize::_('login_'); ?>" autofocus <?php
		if(isset($_COOKIE['user_name'])) {
			echo 'value="' . $_COOKIE['user_name'] . '"';
		}
	?> />
</div>
<div class="form-group">
<input type="password" class="form-control" name="password" placeholder="<?php echo Localize::_('password_'); ?>">
</div>
<p><?php //echo $message; ?></p>
<div class="form-group forgot">
<a href="#"><?php echo Localize::_('forgot_your_password'); ?></a>
<a href="#"><?php echo Localize::_('forgot_your_sign_in'); ?></a>
</div>
	<div class="col-xs-8">
		<div class="checkbox icheck">
		<label>
		<input name="remember_me" type="checkbox" <?php 
		if(isset($_COOKIE['remember_me'])) {
			echo 'checked';
		}
	?>> <?php echo Localize::_('remember_me'); ?>
		</label>
		</div>
	</div>
<div class="form-group btn-group">
<input type="submit" class="btn btn-block btn-primary" value="Sign In" />
</div>
</form>
<form id="signup_form" enctype="multipart/form-data" method="POST" action="index.php?com=users&view=user">
<legend><?php
echo Localize::_('register_or_signup');
?></legend>
<input type="hidden" name="action" value="add">
<div class="form-group hide"><?php
echo Localize::_('i_am_a');
?><label style="margin-right:20px;"><?php
echo Localize::_('buyer');
?><input type="checkbox" style="float:left;margin:3px 10px 0px 20px;" checked class="" name="is_buyer"></label>
 | 
<label><?php
echo Localize::_('seller');
?><input type="checkbox" style="float:left;margin:3px 10px 0px 20px" class="" name="is_seller"></label>
</div>
<div class="form-group">
<input type="text" class="form-control" name="full_name" placeholder="<?php echo Localize::_('full_name_'); ?>" required>
</div>
<div class="form-group">
<input type="email" class="form-control" name="e_mail" placeholder="<?php echo Localize::_('email_'); ?>" required>
</div>
<div class="form-group">
<?php
	echo HtmlForm::htmlSelect($this->countries, 0, 'country');
?>
</div>
<div class="form-group">
<input type="text" class="form-control" name="phone" placeholder="<?php echo Localize::_('phone'); ?>" required>
</div>
<div class="form-group">
<input type="text" class="form-control" name="user_name" placeholder="<?php echo Localize::_('login_'); ?>" required>
</div>
<div class="form-group">
<input type="password" class="form-control conf_pwd" name="user_pass" placeholder="<?php echo Localize::_('password_'); ?>" required>
</div>
<div class="form-group">
<input type="password" class="form-control conf_pwd" name="confirm_password" placeholder="<?php echo Localize::_('confirm_password'); ?>" required>

</div>
<div class="form-inline custom_gender_upload">
<div class="radio custom_radio">
<label><input type="radio" name="gender" checked value="1"><?php echo Localize::_('male'); ?></label>
<label><input type="radio" name="gender" value="2"><?php echo Localize::_('female'); ?></label>
</div>
<div style="float:right; display:block; width:50%;">
<label class="btn btn-md btn-info">
<input name="photo" style="display:none" type="file">
<?php echo Localize::_('upload_photo'); ?></label>
</div>
</div>
<div class="form-group">

</div>
<div class="form-group btn-group">
<input type="submit" value="<?php echo Localize::_('register_signup'); ?>" class="btn btn-block btn-primary">
</div>
</form>
</div>
</div>