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
//print_r($this);
$this->app->setTitle('Add Item');
$edit_disable='';
$new_disable='';
//print_r($this->row);exit;
$this->article_id='';
$title='';
$description='';
$sale_price=0;
$purchase_price=0;
$brand=0;
$expiry_alert_days=0;
$min_stock=0;
$discount_value=0;
$tax_liable=0;
$dim_width=0;
$dim_height=0;
$dim_length=0;
$dim_unit=0;
if($this->article_id && isset($this->row) && $this->row){
	$edit_disable='disabled';
	$this->article_id=$this->row['id'];
	$title=$this->row['title'];
	$description=$this->row['description'];
	$sale_price=$this->row['sale_price'];
	$purchase_price=$this->row['purchase_price'];
	$brand=$this->row['brand'];
	$expiry_alert_days=$this->row['expiry_alert_days'];
	$min_stock=$this->row['min_stock'];
	$discount_value=$this->row['discount_value'];
	$tax_liable=$this->row['tax_liable'];
	$dim_width=$this->row['dim_width'];
	$dim_height=$this->row['dim_height'];
	$dim_length=$this->row['dim_length'];
	$dim_unit=$this->row['dim_unit'];
	
}else{
	$new_disable='disabled';
}

$this->app->setTitle('Edit Item');
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm-article" action="?com=articles&view=articles&id=<?php echo $this->article_id;?>">
		<fieldset class="form">
		
		<div class="form grid">
			<input type="hidden" name="id" value="<?php echo $this->article_id; ?>" />
			
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div><div class="col-sm-4"><input id="title" name="title" pattern=".{5,}" class="inputbox form-control" value="<?php echo $title; ?>" /></div>
				
				<div class="col-sm-2"><label class="control-label" for="category">Category:</label> </div><div class="col-sm-2"><?php 
			
				//$cats = getCategoriesHTML($this->row['category']);
				echo '<SELECT name="category" id="category" class="category form-control dropdown-header">';
				echo '<OPTION value="">...</OPTION>';
				foreach ($this->cats as $cat){
					print_r($cat);echo '<br/>';
				}
				echo '</SELECT>';
			
			
			?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="description">Description:</label> </div><div class="col-sm-4"><input id="description" name="description" class="inputbox form-control" value="<?php echo $description; ?>" /></div>
				<div class="col-sm-2"><label class="control-label" for="unit_group">Unit Group:</label> </div><div class="col-sm-2"><?php 
				echo '<SELECT name="unit_group" id="unit_group" class="unit_group form-control dropdown-header"' . $edit_disable . ' required >';
				echo '<OPTION value="">...</OPTION>';
				foreach ($this->unit_groups as $ug){
					print_r($ug);echo '';
				}
				echo '</SELECT>';
			
			
			?></div>
				<div class="col-sm-1 hide"><label class="control-label" for="brand">Brand:</label> </div><div class="col-sm-2 hide"><input id="brand" name="brand" class="inputbox form-control input" value="<?php echo $brand; ?>" /></div>
			</div>
		
			<div class="row well-sm"><br/></div>
		  <ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#general">General</a></li>
			<li><a data-toggle="tab" href="#sales">Sales</a></li>
			<li><a data-toggle="tab" href="#purchases">Purchases</a></li>
			<li><a data-toggle="tab" href="#stock">Stock</a></li>
			<li><a data-toggle="tab" href="#price-list">Price List</a></li>
			<li><a data-toggle="tab" href="#properties">Properties</a></li>
			<li><a data-toggle="tab" href="#expiry">Expiry</a></li>
			<li><a data-toggle="tab" href="#season">Seasons</a></li>
			<li><a data-toggle="tab" href="#dimensions">Dimensions</a></li>
		  </ul>	
		<div class="tab-content">
    <div id="general" class="tab-pane fade in active">
		<div class="row well-sm">
			<div class="col-sm-2"><a href="#" class="" id="adv_options">Advance Options</a></div>
		</div>
		<div class="row well-sm">
			<div class="col-sm-2"><label><input id="tax_liable" name="tax_liable" type="checkbox" <?php
				if(isset($this->row)){
					if($this->row['tax_liable']){
						echo 'checked';
					}
				}
			?> /> Tax Liable</label></div>
		</div>
		<div class="row well-sm">
		<div class="col-sm-2"><label class="control-label" for="procurement_method">Procurement method:</label> </div><div class="col-sm-2"><?php 
	
		echo '<SELECT name="procurement_method" id="procurement_method" class="form-control dropdown-header" >';
		echo '<OPTION value="1">Purchase</OPTION>';
		echo '<OPTION value="2">Produce</OPTION>';
		echo '</SELECT>';
	
	
	?></div>
		
		</div>

    </div>
    <div id="sales" class="tab-pane fade in">
      
		<div class="row well-sm">
		<div class="col-sm-1"><label class="control-label" for="sale_price">Price:</label> </div>
		<div class="col-sm-2"><input type="number" id="sale_price" step="any" name="sale_price" class="inputbox form-control" value="<?php echo $sale_price; ?>" <?php echo $new_disable;?> /></div>
		<div class="col-sm-1"><label class="control-label" for="sale_unit">Unit:</label> </div>
			<div class="col-sm-2"><?php 
			echo '<SELECT name="sale_unit" id="sale_unit" class="form-control dropdown-header">';
			echo '<OPTION value="">...</OPTION>';
			foreach ($this->art_units as $au){
				if(isset($this->row) && $this->row['unit_group'] == $au['unit_group']){
					echo '<OPTION value="' . $au['id'] . '" ';
					if(isset($this->row) && $this->row['sale_unit'] == $au['id']){
						echo 'selected';
					}
					echo ' >' . $au['title'] . '</OPTION>';
				}
			}
			echo '</SELECT>';
			?></div>
		<div class="col-sm-1"><label class="control-label" for="discount_value">Discount:</label> </div>
		<div class="col-sm-2"><input type="number" id="discount_value" step="any" name="discount_value" class="inputbox form-control" value="<?php echo $discount_value; ?>" /></div>
	
    </div>
    </div>
	
    <div id="purchases" class="tab-pane fade in">
      
		<div class="col-sm-1"><label class="control-label" for="sale_price">Price:</label> </div>
		<div class="col-sm-2"><input type="number" id="sale_price" step="any" name="sale_price" class="inputbox form-control" value="<?php echo $purchase_price; ?>" <?php echo $new_disable;?> /></div>
		<div class="row well-sm">
		<div class="col-sm-1"><label class="control-label" for="purchase_unit">Unit:</label> </div>
		<div class="col-sm-2"><?php 
		echo '<SELECT name="sale_unit" id="sale_unit" class="form-control dropdown-header">';
		echo '<OPTION value="">...</OPTION>';
		foreach ($this->art_units as $au){
			if(isset($this->row) && $this->row['unit_group'] == $au['unit_group']){
				echo '<OPTION value="' . $au['id'] . '" ';
				if(isset($this->row) && $this->row['purchase_unit'] == $au['id']){
					echo 'selected';
				}
				echo ' >' . $au['title'] . '</OPTION>';
			}
		}
		echo '</SELECT>';
		?></div>
	
    </div>
    </div>
	
    <div id="stock" class="tab-pane fade in">
		<div class="row well-sm">
			<div class="col-sm-2"><label class="control-label" for="min_stock">Reorder Level:</label> 
			<div><input type="number" id="min_stock" step="any" name="min_stock" class="inputbox form-control" value="<?php echo $min_stock; ?>" /></div>
</div>
		</div>
    </div>
	
    <div id="price-list" class="tab-pane fade in">
		<div class="row well-sm">
			<div class="col-sm-8">
			
		<form class="form-inline screen" method="post" id="frm_art_price_list" name="frm_pur_art" action="?com=purchases&view=purchase<?php if($this->article_id){echo '&id='.$this->article_id;} ?>">
		<fieldset class="form">
			<legend>Unit</legend>
			<div class="form grid">
				<input type="hidden" name="form_type" value="purchase_items" />
				<input type="hidden" name="article_id" value="<?php if($this->article_id){ echo $this->article_id;} ?>" />
				<div class="row well-sm">
					<div class="col-sm-2"><?php 
					echo '<SELECT name="unit_id" class="unit_id" class="form-control dropdown-header">';
					echo '<OPTION value="">...</OPTION>';
					foreach ($this->art_units as $au){
						if(isset($this->row) && $this->row['unit_group'] == $au['unit_group']){
							echo '<OPTION value="' . $au['id'] . '" ';
							echo ' >' . $au['title'] . '</OPTION>';
						}
					}
					echo '</SELECT>';
					?></div>
		
					<div class="col-sm-2"><input placeholder="Barcode" id="bar_code" name="bar_code" class="inputbox form-control input-sm" value="" tabindex="-1" /></div>

					<div class="col-sm-2"><input type="number" step="any" placeholder="Sale Price" id="sale_price" name="sale_price" class="inputbox form-control input-sm" value="" tabindex="-1" /></div>
					<div class="col-sm-2"><input type="number" step="any" placeholder="Purchase Price" id="purchase_price" name="purchase_price" class="inputbox form-control input-sm col-sm-1" value="" /></div>

					<div class="col-sm-1"><span><button id="save_art" name="save_art" id="save_art" class="btn btn-success btn-sm btn-flat" tabindex="-1" onclick="saveArticle();return false;"><i class="glyphicon glyphicon-plus"></i> Add</button></span></div>
				</div>
			</div><div class="clear"></div>
			<hr/>
		</fieldset>
	</form>
				</div>
		</div>
		<div class="row well-sm">
			
			
			
			
		<div class="col-sm-6">	
	<table  class="table table-bordered table-hover table-condenseds">
		<thead><tr><th>Unit</th><th>Barcode</th><th>Sale Price</th><th>Purchase Price</th><th>Actions</th></tr></thead><?php
		echo $this->_loadTemplate('art_price_list');
		
		
		?><tfoot></tfoot>
	</table>
	
	
		</div>
		</div>
    </div>
    <div id="expiry" class="tab-pane fade in">
		<div class="row well-sm">
			<div class="col-sm-2"><label>Expiry alert days:</label></div>
			<div class="col-sm-2"><input type="number" id="expiry_alert_days" step="any" name="expiry_alert_days" class="inputbox form-control" value="<?php echo $expiry_alert_days; ?>" />
			</div>
		</div>
    </div>
    <div id="properties" class="tab-pane fade in">
		<div class="row well-sm">
			<div class="col-sm-2"><label>Expiry alert days:</label></div>
			<div class="col-sm-2"><input type="number" id="expiry_alert_days" step="any" name="expiry_alert_days" class="inputbox form-control" value="<?php echo $expiry_alert_days; ?>" />
			</div>
		</div>
    </div>
    <div id="season" class="tab-pane fade in">
		<div class="row well-sm">
			<div class="col-sm-3">
				<div class=""><label class="control-label" for="seasons">Press 'Ctrl+Click' for multiple seasons:</label></div><div class=""><?php 
			
				echo '<SELECT name="seasons[]" id="seasons" class="form-control" size="10" multiple>';
				/*if(!$tg){
					echo '<OPTION value=""></OPTION>';
				}*/
				foreach ($this->seasons as $s){
					$sel='';
					//$as = array_search($s['id'], $tg);
					//if($as>=1 || $as === 0){$sel=' selected';}
					echo '<OPTION value="' . $s['id'] . '" ' . $sel . ' >' . $s['title'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
			
		</div>
    </div>
    <div id="dimensions" class="tab-pane fade in">
		<div class="row well-sm">
			<div class="col-sm-1"><label>Width:</label></div>
			<div class="col-sm-1"><input type="number" id="dim_width" step="any" name="dim_width" class="inputbox form-control" value="<?php echo $dim_width; ?>" />
			</div>
			<div class="col-sm-1"><label>Height:</label></div>
			<div class="col-sm-1"><input type="number" id="dim_height" step="any" name="dim_height" class="inputbox form-control" value="<?php echo $dim_height; ?>" />
			</div>
			<div class="col-sm-1"><label>Length:</label></div>
			<div class="col-sm-1"><input type="number" id="dim_length" step="any" name="dim_length" class="inputbox form-control" value="<?php echo $dim_length; ?>" />
			</div>
			<div class="col-sm-1"><label>Unit:</label></div>
			<div class="col-sm-2"><?php 
			echo '<SELECT name="sale_unit" id="sale_unit" class="form-control dropdown-header">';
			echo '<OPTION value="">...</OPTION>';
			foreach ($this->art_units as $au){
				if($au['is_distance']){
					echo '<OPTION value="' . $au['id'] . '" ';
					if(isset($this->row) && $this->row['dim_unit'] == $au['id']){
						echo 'selected';
					}
					echo ' >' . $au['title'] . '</OPTION>';
				}
			}
			echo '</SELECT>';
			?></div>
			
		</div>
    </div>
		</div>
		</div>
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
		</div>
		</fieldset>

<!-- Modal -->
<div class="modal fade" id="model_advance" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header" style="padding:35px 50px;">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4>Advance Options</h4>
</div>
<div class="modal-body" style="padding:40px 50px;">

<div class="row well-sm">
<div class="col-sm-3"><label><input id="is_inv_item" type="checkbox" name="is_inv_item" <?php 

	if(isset($this->row)){
		if($this->row['is_inv_item']){
			echo 'checked';
		}
	}else{
		echo 'checked';
	}
?> /> Is inv</label></div>
<div class="col-sm-3"><label><input id="is_sale_item" name="is_sale_item" type="checkbox" <?php
	if(isset($this->row)){
		if($this->row['is_sale_item']){
			echo 'checked';
		}
	}else{
		echo 'checked';
	}

?> /> Is Sale</label></div>
<div class="col-sm-3"><label><input id="is_purchase_item" name="is_purchase_item" type="checkbox" <?php
	if(isset($this->row)){
		if($this->row['is_purchase_item']){
			echo 'checked';
		}
	}else{
		echo 'checked';
	}
?> /> Is Purchase</label></div>
<div class="col-sm-3"><label><input id="is_fixed_asset" name="is_fixed_asset" type="checkbox" <?php

	if(isset($this->row)){
		if($this->row['is_fixed_asset']){
			echo 'checked';
		}
	}
?> /> Fixed Asset</label></div>
<div class="col-sm-3"><label><input id="published" name="published" type="checkbox" <?php

	if(isset($this->row)){
		if($this->row['published']){
			echo 'checked';
		}
	}else{
		echo 'checked';
	}
?> /> Published</label></div>
</div>



</div>
<div class="modal-footer">
</div>
</div>

</div>
</div>
		
	</form>
</div>
<script>
$(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
  
  $("#adv_options").click(function(){
    $("#model_advance").modal();
  }); 
});
</script>
