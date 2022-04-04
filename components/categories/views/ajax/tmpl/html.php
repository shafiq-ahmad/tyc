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

global $com,$view,$task;
if($_POST && $task=="new"){
	createData($_POST);
}
//echo $id;exit;
if(isset($id)){
//print_r($_POST);exit;
if($_POST){
	setData($_POST);
}
$row = getDataByID($id);

//print_r($row);exit;

?><div class="com-head">
	<?php /* ?><h3>Add/Edit Category</h3><?php */ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=categories&view=categories&id=<?php echo $id;?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="id">ID#:</label></div><div class="col-sm-2"><input name="id" class="inputbox form-control" value="<?php echo $row['id'];?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="title">Sub Cagegory:</label></div><div class="col-sm-2"><input name="title" class="inputbox form-control" value="<?php echo $row['title'];?>" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-1" for="category">Main Category:</label> </div><div class="col-sm-3"><?php 
			
			$cats = getParents();
			echo '<SELECT name="category" id="category" class="category form-control dropdown-header">';
			echo '<OPTION value="">This is Main Category</OPTION>';
			foreach ($cats as $cat){
				//echo '<optgroup label="' . $cat['name'] . '">';
				echo '<OPTION ';
				if($cat['id']==$row['parent_cat']){echo 'selected="selected" ';}
				echo 'VALUE="' . $cat['id'] . '">' . $cat['title'] . '</OPTION>';
				//echo '</optgroup>';
			}
			echo '</SELECT>';
			
			
			?></div></div>
			<div class="row well-sm"><div class="col-sm-1"><label class="control-label" for="discount_per">Discount%:</label> </div><div class="col-sm-2"><input name="discount_per" class="inputbox form-control" value="<?php echo $row['discount_per'];?>" /></div>
				<div class="col-sm-2"><label class="control-label col-sm-2" for="gst_per">GST%:</label> </div><div class="col-sm-2"><input name="gst_per" class="inputbox form-control" value="<?php echo $row['gst_per'];?>" /></div></div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()"  /></span>
				<?php /* ?><span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span><?php */ ?>
				<span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span>
				<span><input type="submit" name="save" id="save" class="btn btn-success" value="Save" /></span>
				<span><a href="?com=categories&view=category&task=new" title="New Category" class="btn btn-info">New</a></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div><?php
} 
?>



