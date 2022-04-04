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


$app=core::getApplication();
//var_dump($this->row);exit;
$id=0;
$title='';
$published=1;
$city_id=0;
$action='add';
if(isset($this->row['id'])){
	$id=$this->row['id'];
	$action='update';
	$title=$this->row['title'];
}



?>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<?php /*?><?php */ ?>

<div class="table-responsive">
<div class="com-head">
<h3>Manufacturer</h3>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=vehicles&view=make&task=edit&id=<?php echo $this->id;?>">
		<fieldset class="form">
			<div class="form grid">
			<input type="hidden" name="id" value="<?php if(isset($this->row['id'])){ echo $this->row['id'];}?>" />
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="source" value="makes" />
			<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />
			<div class="form-row py-sm-3 mb-0">
				<div class="form-group col-sm-3">
				<div class="input-group">
				<div class="input-group-prepend">
				<span class="input-group-text">Make: </span>
				</div>
				<input name="title" pattern=".{2,}" class="form-control" value="<?php echo $title;?>" required autofocus autocomplete="off" />
				</div>
				</div>
			</div>
			
			
			<div class="btn-group">
				<span><button type="submit" id="save" class="btn btn-success btn-flat btn-sm" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="index.php?com=vehicles&view=makes" class="btn btn-info btn-flat btn-sm" tabindex="-1" ><i class="fa fa-list-ol"></i> Makes</a></span>
			</div>
			</div>
			</div>
		</fieldset>
	</form>
</div>

<script>
/*$("select.select2" ).select2({
	theme: "bootstrap"
});*/
</script>

