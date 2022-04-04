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

//print_r($_POST);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Category</h3><?php */ ?>
</div><div class="form-group"><?php /*?>
  <!-- Select2 -->
  <link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<!-- Select2 -->
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script><?php */ ?>
	<form class="form-inline" method="post" name="frm" action="?com=categories&view=category&task=new">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div><div class="col-sm-5"><input pattern=".{3,}" autocomplete="off" name="title" class="inputbox form-control" value="" autofocus required /></div>
				<?php /* ?><div class="col-sm-2"><label class="control-label col-sm-1" for="category">Category:</label> </div><div class="col-sm-3"><?php 
			
			echo '<SELECT name="category" id="category" class="category form-control dropdown-header">';
			echo '<OPTION value="">This is Main Category</OPTION>';
			foreach ($this->cats as $cat){
				//echo '<optgroup label="' . $cat['name'] . '">';
				echo '<OPTION VALUE="' . $cat['id'] . '">' . $cat['title'] . '</OPTION>';
				//echo '</optgroup>';
			}
			echo '</SELECT>';
			
			
			?></div><?php */ ?>
			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back()" tabindex="-1" ><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><button class="btn btn-warning" type="reset" name="reset" tabindex="-1" ><i class="glyphicon glyphicon-remove"></i> Reset</button></span>
				<span><button type="submit" name="save" id="save" class="btn btn-success" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php

?>
