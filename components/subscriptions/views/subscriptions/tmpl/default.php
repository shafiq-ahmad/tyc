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
//var_dump($this->rows);exit;

?>

<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="all" />
<div class="table-responsive">
<div class="com-head">
	<h3><?php echo Localize::_('subscriptions_getting_started_title'); ?></h3>
	
</div>
<div class="row sy-sm-3 my-2">
<div class="col-md-2"><img class="img-thumbnail" src="media/images/subscription.png" alt="Subscribe" style="max-width:150px;" /></div>
<div class="col-sm-6">
<p class="body"><?php echo Localize::_('subscriptions_getting_started_body'); ?></p>
<p class="body"><?php echo Localize::_('subscriptions_getting_started_example'); ?></p>
</div>
<div class="col-sm-4">

<div class="row">
	<div class="col-sm-12">
		<table id="data-table" class="table">
			<thead><tr><th><?php echo Localize::_('vehicles');?></th><th><?php echo Localize::_('cost');?> ($)</th></tr></thead>
			<tbody id="tblContentBody"><?php
				$min=999999;
				foreach ($this->rows as $row){
					for($x=1;$x<11;$x++){
					?><tr><?php
						echo '<td>' . $x . '</td>';
						echo '<td>' . $x * $row['sale_price'] . '</td>';
					?></tr><?php
					}
				}
			?></tbody>
		</table>
	</div>
</div>
	
</div>
</div>
<hr/>
<div class="row">
<p><?php echo Localize::_('do_u_want_2buy_title');?></p>
<p><?php echo Localize::_('do_u_want_2buy_message');?></p>
<form action="index.php?com=subscriptions&view=subscriptions&task=step_1" method="post">
<div class="form-group col-sm-2">
<input name="sale_price" type="hidden" value="20" required />
<label><?php echo Localize::_('vehicles');?> <input name="qty" type="number" step="any" class="form-control" min="1" value="" style="display:inline;max-width:80px;" required autofocus />
</label>
</div>
<div class="btn-group col-sm-4">
	<span><a href="index.php?com=users&view=profile" class="btn btn-flat btn-default" tabindex="-1" ><i class="fa fa-arrow-left"></i> <?php echo Localize::_('back'); ?></a></span>
	<span><button type="submit" class="btn btn-info btn-flat" tabindex="-1" ><?php echo Localize::_('continue'); ?> <i class="fa fa-arrow-right"></i></button></span>
</div>
</form>
</div>
</div>
<script>
</script>