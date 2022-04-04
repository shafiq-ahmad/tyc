<?php
defined('_MEXEC') or die ('Restricted Access');

$row=$this->row;
//print_r($row);

//$up = json_decode($row['privileges']);
$up = explode(',', $row['privileges']);
//var_dump($up);
/* $user=core::getUser();
$prr=$user->hasPriv('sales.discount');
var_dump($prr);exit;
 */
//if($this->id && isset($this->row)){
?>
<div class="com-head">
	<h3>Add/Edit User</h3>
</div>
<style>
.form-user-privs .grid {float:left;width:70%;}
</style>
<div class="form-user-privs">
	<form class="form-inline" method="post" name="frm-user" action="?com=users&view=user&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="<?php echo $row['user_id']; ?>" />
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="user_name">Login:</label></div><div class="col-sm-4"><input id="user_name" name="user_name" class="inputbox form-control" value="<?php echo $this->row['user_name'];?>" readonly /></div>
				<div class="col-sm-2"><label class="control-label" for="full_name">Full Name:</label> </div><div class="col-sm-4"><input id="full_name" name="full_name" class="inputbox form-control" value="<?php echo $this->row['full_name'];?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="reset_password">Reset PWD:</label> </div><div class="col-sm-4"><input id="reset_password" name="reset_password" class="inputbox form-control" value="" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="e_mail">E-mail:</label></div><div class="col-sm-4"><input id="e_mail" name="e_mail" class="inputbox form-control" value="<?php echo $this->row['e_mail'];?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="phone">Phone:</label> </div><div class="col-sm-4"><input id="phone" name="phone" class="inputbox form-control" value="<?php echo $this->row['phone'];?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="cnic">CNIC:</label> </div><div class="col-sm-4"><input id="cnic" name="cnic" class="inputbox form-control" value="<?php echo $this->row['cnic'];?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="zip_code">Post code:</label></div><div class="col-sm-4"><input id="zip_code" name="zip_code" class="inputbox form-control" value="<?php echo $this->row['zip_code'];?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="city">City:</label> </div><div class="col-sm-4"><input id="city" name="city" class="inputbox form-control" value="<?php echo $this->row['city'];?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="address">Address:</label> </div><div class="col-sm-4"><input id="address" name="address" class="inputbox form-control" value="<?php echo $this->row['address'];?>" /></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="notes">Notes:</label></div><div class="col-sm-10"><input id="notes" name="notes" class="inputbox form-control" value="<?php echo $this->row['notes'];?>" /></div>
			</div>
			
			
			<div class="row well-sm">
				<div class="col-sm-2"><label class="control-label" for="published">Active:</label></div><div class="col-sm-4"><?php 
				echo '<SELECT name="published" id="published" class="published form-control dropdown-header">';
				foreach ($this->pl as $key => $value){
					$sel='';
					if($row['published']== $key){
						$sel=' selected';
					}
					echo '<OPTION value="' . $key . '" ' . $sel . ' >' . $value . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				<?php /* ?><div class="col-sm-2"><label class="control-label" for="group_id">Group:</label></div><div class="col-sm-4"><?php 
				echo '<SELECT name="group_id" id="group_id" class="group_id form-control dropdown-header">';
				if(!$row['group_id']){
					echo '<OPTION value=""></OPTION>';
				}
				foreach ($this->groups as $g){
					$sel='';
					if($row['group_id']== $g['group_id']){
						$sel=' selected';
					}
					echo '<OPTION value="' . $g['group_id'] . '" ' . $sel . ' >' . $g['group_name'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
			<div class="row well-sm"><?php */ ?>
				<div class="col-sm-2"><label class="control-label" for="branch_id">Branch:</label></div><div class="col-sm-4"><?php 
			
				echo '<SELECT name="branch_id" id="branch_id" class="branch_id form-control dropdown-header">';
				if(!$row['branch_id']){
					echo '<OPTION value=""></OPTION>';
				}
				foreach ($this->branches as $b){
					$sel='';
					if($row['branch_id']== $b['id']){
						$sel=' selected';
					}
					echo '<OPTION value="' . $b['id'] . '" ' . $sel . ' >' . $b['title'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div><div class="clear"></div>
			
			
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()" tabindex="-1" /></span>
				<?php /* ?><span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span><?php */ ?>
				<span><input class="btn btn-default" type="reset" name="reset" value="Reset" tabindex="-1" /></span>
				<span><input type="submit" name="save-article" id="save" class="btn btn-success" value="Save" tabindex="-1" /></span>
			</li>
			<li></li>
		</ul>
		</div></div>
			
			
			<div class="right">
				<div class=""><label class="control-label" for="privileges">Privileges:</label></div><div class=""><?php 
			
				echo '<SELECT name="privileges[]" id="privileges" class="form-control" size="35" multiple>';
				/*if(!$up){
					echo '<OPTION value=""></OPTION>';
				}*/
				foreach ($this->privileges as $pr){
					$sel='';
					$as = array_search($pr['id'], $up);
					if($as>=1 || $as === 0){
						$sel=' selected';
						//exit;
					}
					echo '<OPTION value="' . $pr['id'] . '" ' . $sel . ' >' . ucfirst($pr['com']) . '.' . $pr['title'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
			
			
			
		</fieldset>
	</form></div>
<?php
//} ?>