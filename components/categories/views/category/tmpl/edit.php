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
//print_r($row);exit;

?>
  <!-- Select2 -->
  <link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<!-- Select2 -->
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
  
  <div class="com-head">
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=categories&view=categories&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
		<div class="row">
			<input type="hidden" name="id" value="<?php if(isset($this->row['id'])){ echo $this->row['id'];}?>" />
			<div class="col-sm-1"><label class="control-label" for="title">Cagegory:</label></div><div class="col-sm-6"><input name="title" pattern=".{3,}" class="inputbox form-control" value="<?php echo $this->row['title'];?>" required autofocus autocomplete="off" /></div>

				<span> <button type="submit" name="save" id="save" class="btn btn-success btn-flat" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="?com=categories&view=categories" title="New Category" class="btn btn-info btn-flat"><i class="fa fa-file"></i> New</a></span>

		</div>
		</div>
		</div>
		</fieldset>
	</form>
</div>

<script>
</script>

