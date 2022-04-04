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
<style>
.form-inline .row > div {padding:0;}
.well-sm {padding:0 4px;}
.row {margin-left:0}
</style>
<div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
    <input type="hidden" id="return-value" value="" />
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose an item</h4>
        </div>
        <table class="modal-body nav-able"></table>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <?php

//		if ($sub){
	?><form class="form-inline no-print" method="post" id="frm_sale_art" name="frm_sale_art" action="?com=sales&view=pos<?php if($this->id){echo '&id='.$this->id;} ?>">
		<div class="form grid">
			<input type="hidden" name="form_type" value="sale_items" />
			<input type="hidden" id="sale_id" name="sale_id" value="<?php if($this->id){echo $this->inv['id'];}?>" />
			<input type="hidden" id="qty" name="qty" value="" />
			<div class="row well-sm">
				<div class="col-sm-2 item"><input data-toggle="tooltip" autocomplete="off" data-placement="top" id="id" title="Shortcut 'Home' key" name="id" class="inputbox form-control input-sm" value="" autofocus /></div>
				<div class="col-sm-4 title"><input id="title" name="title" class="inputbox form-control input-sm col-sm-2" value="" readonly tabindex="-1" /></div>
				<div class="col-sm-1 qty1"><input type="number" id="qty1" name="qty1" class="inputbox form-control input-sm col-sm-4" value="" tabindex="-1" /></div>
				<div class="col-sm-1 price"><input id="sale_price" name="sale_price" class="inputbox form-control input-sm col-sm-1" value="" readonly tabindex="-1" /></div>
				<div class="col-sm-1 disc"><input id="discount-item" name="discount-item" class="inputbox form-control input-sm col-sm-1" value="" readonly tabindex="-1" /></div>
				<div class="col-sm-1 disc-terms hide"><input id="sale_price_terms" name="sale_price_terms" class="inputbox form-control input-sm col-sm-1" value="" readonly tabindex="-1" /></div>
				<div class="col-sm-1 total"><input id="cost_total" name="cost_total" class="inputbox form-control input-sm col-sm-1" value="" readonly tabindex="-1" /></div>
				<div class="col-sm-1 stock"><input id="stock" name="stock" class="inputbox form-control input-sm col-sm-1" value="" readonly tabindex="-1" /></div>

			</div>
		</div><div class="clear"></div>
	</form><?php
//		}
?></div>

 
 