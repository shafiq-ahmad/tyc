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

//import('core.payment_methods');
var_dump($_POST);
//var_dump($this->payment_methods);exit;
$amount = $this->getVar('amount',0,'post');

?>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" media="all" />
<div class="table-responsive">
<div class="com-head">
	<h3><?php echo Localize::_('choose_payment_methods'); ?></h3>
</div>
<div class="row">
<form action="index.php?com=subscriptions&view=subscriptions&task=step_2" method="post">
	<div class="form-row">
		<div class="col-12"><label><?php echo Localize::_('amount_payable');?> ($) <input type="number" step="any" name="amount" class="form-control" value="<?php echo $amount;?>" style="max-width:100px;display:inline-block;" /></label></div>
	</div>
	<div class="form-row">
	<div class="col-sm-10 px-2"><div class="form-row"><?php
		foreach ($this->payment_methods as $pm){
			echo '<div class="row" style="margin:10px 0;">';
			echo '<div class="col-md-1"><input type="radio" name="payment_method" value="' . $pm['id'] . '"/></div>';
			echo '<div class="col-md-2" style="max-width:100px; overflow:hidden;"><img src="' . $pm['image'] . '" style="width:100px;" class="img-responsive" /></div>';
			echo '<div class="col-md-4"><p>' . $pm['title'] . '</p></div>';
			echo '</div><div class="row">';
			echo '<div class="col-md-1"></div><div class="col-sm-11"><p>' . $pm['info'] . '</p></div>';
			echo '</div><hr/>';
		}
		?></div>

	</div>
	</div>
</div>
	
<div class="btn-group">
	<span><a href="index.php?com=subscriptions&view=subscriptions" class="btn btn-flat btn-default" tabindex="-1" ><i class="fa fa-arrow-left"></i> <?php echo Localize::_('back'); ?></a></span>
	<span><button type="submit" href="" class="btn btn-info btn-flat" tabindex="-1" ><?php echo Localize::_('checkout'); ?> <i class="fa fa-arrow-right"></i></button></span>
</div>
</form>
</div>
<script>
//$(document).ready(function(){$('#data-table').DataTable();})
</script>