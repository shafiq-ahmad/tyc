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

//print_r($this->c);exit;
if($this->u){
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" id="frm_user" name="frm_user" action="?com=users&view=profile">
		<input type="hidden" name="form_type" value="user_info" />
		<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />
		<fieldset class="form">
		<legend>User</legend>
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="group_name">Group:</label></div><div class="col-sm-2"><input id="group_name" class="inputbox form-control" value="<?php echo $this->u['group_name'];?>" readonly /></div>
				<div class="col-sm-1"><label class="control-label" for="full_name">Name:</label></div><div class="col-sm-2"><input id="full_name" name="full_name" class="inputbox form-control" value="<?php echo $this->u['full_name'];?>" readonly /></div>
				<div class="col-sm-1"><label class="control-label" for="e_mail">E-mail:</label> </div><div class="col-sm-2"><input id="e_mail" type="email" name="e_mail" class="inputbox form-control" value="<?php echo $this->u['e_mail'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="phone">Phone:</label> </div><div class="col-sm-2"><input id="phone" name="phone" class="inputbox form-control" value="<?php echo $this->u['phone'];?>" required autocomplete="off" /></div>
			</div>
			<div class="col-sm-1"><label class="control-label" for="city">City:</label></div><div class="col-sm-2"><input id="city" name="city" class="inputbox form-control" value="<?php echo $this->u['city'];?>" required autocomplete="off" /></div>
			<div class="col-sm-1"><label class="control-label" for="cnic">CNIC:</label></div><div class="col-sm-2"><input id="cnic" name="cnic" class="inputbox form-control input" value="<?php echo $this->u['cnic'];?>" /></div></div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="user_address">Address:</label> </div><div class="col-sm-2"><input id="user_address" name="address" class="inputbox form-control number" value="<?php echo $this->u['address'];?>" /></div>
				<div class="col-sm-1 hide"><label class="control-label" for="print_paper_size">Paper size:</label> </div><div class="col-sm-2 hide"><input id="print_paper_size" name="print_paper_size" class="inputbox form-control" value="<?php echo $this->u['print_paper_size'];?>" required autocomplete="off" /></div>
			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="submit" name="update_user" id="update_user" class="btn btn-success" tabindex="-1"><i class="fa fa-save"></i> Save</button></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php
} ?>