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
$id_='';
$user_id=0;
$vat_type_id=0;
$method_of_payment=0;
$charges=null;
$action='add';
/*echo '<pre>';
print_r($this->row);
echo '</pre>';
exit;*/


if(isset($this->row['id'])){
	$id=$this->row['id'];
	$id_= "&id=" . $id;
	$action='paid';
	$sub_total=$this->row['sub_total'];
	$user_id=$this->row['user_id'];
	$vat_type_id=$this->row['vat_type_id'];
	$method_of_payment=$this->row['method_of_payment'];
	//$veh_type=$this->row['vehicle_type'];
	$data_articles=json_decode($this->row['data_articles'],true);
}


?>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="media/system/select2/theme/dist/select2-bootstrap.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<?php /*?><?php */ ?>
<style>
</style>
<div class="table-responsive">
<div class="com-head">
<h2><?php echo $this->row['status_name'];?> #: <?php echo $this->row['id'];?></h2>
</div>

<div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=sales&view=sale<?php echo $id_;?>">
		<fieldset class="form">
			<div class="form grid">
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			<input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />
			<div class="form-row py-sm-2 mb-0">
				<div class="form-group col-sm-3">
				<div class="input-group">
				<div class="input-group-prepend">
				<span class="input-group-text">Customer:</span>
				</div>
				<input type="text" class="form-control frm_input" value="<?php echo $this->row['full_name'];?>" required readonly />
				</div>
				</div>
				<div class="form-group col-sm-3">
				<div class="input-group">
				<div class="input-group-prepend">
				<span class="input-group-text">Date:</span>
				</div>
				<input type="text" class="form-control frm_input" value="<?php echo $this->row['sale_date'];?>" required readonly />
				</div>
				</div>
				<div class="col-sm-4 select2-wrapper">
				<div class="form-group">
				<div class="input-group">
				<span class="input-group-addon" title="Payment method">POM: </span>
				<select name="city_id" id="city_id" class="form-control select2 city_id frm_input" readonly><?php
					echo HtmlForm::htmlSelectOptions($this->poms, $method_of_payment, 'method_of_payment');
				?></select></div></div>
				</div>
			</div>
			<div class="form-row">
			</div>
  
			<div class="form-row py-sm-3 mb-0">
				<div class="form-group col-sm-4">
					<div class="input-group">
					<div class="input-group-prepend">
					<span class="input-group-text">Sub Total:</span>
					</div>
					<input name="sub_total" type="number" step="any" class="form-control frm_input" value="<?php echo $sub_total; ?>" required readonly />
					</div>
				</div>
				<div class="col-sm-4 select2-wrapper hide">
				<div class="form-group">
				<div class="input-group"><span class="input-group-addon">VAT Type: </span>
				<select name="vehicle_type" id="vehicle_type" class="form-control frm_input" readonly><?php
					$vat_sel=array();
					foreach($this->vat_types as $vt){
						$sel='';
						if($vt['id'] == $vat_type_id){$sel='selected="selected"';$vat_sel=$vt;}
						echo '<option value="' . $vt['id'] . '" ' . $sel . '>' . $vt['title'] . '</option>';
					}
				?></select></div></div></div>
				<div class="form-group col-sm-3">
				<div class="input-group">
				<div class="input-group-prepend">
				<span class="input-group-text">VAT Amount:</span>
				</div>
				<input name="vat_amount" type="number" step="any" class="form-control frm_input" value="<?php
					$vat = $vat_sel['vat_value'] * $sub_total / 100;
					echo $vat;
					?>" required readonly />
				</div>
				</div>
			</div>
			<div class="form-row py-sm-3 mb-0">
				<div class="form-group col-sm-4">
					<div class="input-group">
					<div class="input-group-prepend">
					<span class="input-group-text">Total:</span>
					</div>
					<input name="total" type="number" step="any" class="form-control frm_input" value="<?php echo $sub_total + $vat; ?>" required readonly />
					</div>
				</div>
			</div>
			<div class="btn-group">
				<span><button type="submit" id="save" class="btn btn-success btn-flat btn-sm" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="index.php?com=sales&view=sale_orders" class="btn btn-info btn-flat btn-sm" tabindex="-1" ><i class="fa fa-list-ol"></i> Orders</a></span>
			</div>
			</div>
			</div>
		</fieldset>
	</form>
</div>
<hr/>
<h3>Items</h3>

	<table id="data-table" class="table">
		<thead>
		<tr><th>Code</th><th>Item</th><th>Quantity</th><th>Price</th><th>Total</th><th>Actions</th></tr>
		</thead>
		<tbody id="tblContentBody"><?php
		//var_dump($this->port_cities);exit;
		if($data_articles){
			$veh_types = array(1=>'Regular',2=>'Bike', 3=>'Big Pickup');
			foreach ($data_articles as $row){
				//var_dump($row);exit;
		?><tr><?php 
			echo '<td class="id">' . $row['article_id'] . '</td>';
			echo '<td class="title">' . $row['title'] . '</td>'; 
			echo '<td class="qty">' . $row['qty'] . '</td>'; 
			echo '<td class="price">' . $row['price'] . '</td>'; 
			echo '<td class="price">' . $row['qty']*$row['price'] . '</td>'; 
			//echo '<td class="vehicle_type">' . $price_terms[0] . '</td>';
			//$edit_link = "index.php?com=shipping&view=port_cities&task=cities&id={$row['id']}&user_id={$user_id}";
			echo '<td>'; 
				//echo '<a class="btn btn-info btn-sm" data-remote="false" data-toggle="modal" data-target="#myModal" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
				//echo '<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
			echo '</td>'; 
		?></tr><?php
			}
			}
		?></tbody>
		<tfoot>
		</tfoot>
	</table>

<script>

(function(){
	//setTitle();
})();

$("#city_id").change(function(){
	//setTitle();
});

$("#vehicle_type").change(function(){
		//setTitle();
});

function setTitle(){
	var city = $("#city_id option:selected").text();
	var port = <?php echo "'" . $this->port['title'] . "'";?>;
	var v_type = $("#vehicle_type option:selected").text();
	$("#title").val(city.trim() + ' ' + port.trim() + ' ' + v_type.trim());
}

/*$("select.select2" ).select2({
	theme: "bootstrap"
});*/
</script>

