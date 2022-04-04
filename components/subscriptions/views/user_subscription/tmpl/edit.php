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
$duration=0;
$cost=0;
$details=0;
$action='add';
if(isset($this->row['id'])){
	$id=$this->row['id'];
	$action='update';
	$title=$this->row['title'];
	$published=$this->row['published'];
	$duration=$this->row['duration'];
	$cost=$this->row['cost'];
	$details=$this->row['details'];
}



?>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<?php /*?><?php */ ?>

<div class="table-responsive">
<div class="com-head">
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=shipping&view=port&task=edit&id=<?php echo $this->id;?>">
		<fieldset class="form">
			<div class="form grid">
			<input type="hidden" name="id" value="<?php if(isset($this->row['id'])){ echo $this->row['id'];}?>" />
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="source" value="ports" />
			<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />
			<div class="row">
				<div class="col-sm-1"><label class="control-label" for="country_id">Country - City:</label></div>
				<div class="col-sm-2"><?php
					echo HtmlForm::htmlSelect($this->cities, $city_id, 'city_id');
				?>
				</div>
				<div class="col-sm-1"><label class="control-label" for="title">Port:</label></div><div class="col-sm-6"><input name="title" pattern=".{3,}" class="inputbox form-control" value="<?php echo $title;?>" required autofocus autocomplete="off" /></div>
			</div>
			<div class="row">
				<div class="col-sm-2"><label class="control-label">Published: <input name="published" type="checkbox" class="checkbox" <?php if($published){echo 'checked';} ?> /></label></div>
			</div>
			<div class="btn-group">
				<span><button type="submit" id="save" class="btn btn-success btn-flat" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="index.php?com=shipping&view=ports" class="btn btn-info btn-flat" tabindex="-1" ><i class="fa fa-circle-o"></i> Ports</a></span>
			</div>
			</div>
			</div>
		</fieldset>
	</form>
</div>

<script>
</script>

