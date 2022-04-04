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
$shipping=null;
$service_charge=null;
$clearance=null;
$origin_port=null;
$destination_port=null;
$veh_type=null;
$vat_percent=5;
$action='add';
//var_dump($this->row);exit;
if(isset($this->row['id'])){
	$id=$this->row['id'];
	$action='update';
	$shipping=$this->row['shipping'];
	$service_charge=$this->row['service_charge'];
	$clearance=$this->row['clearance'];
	$origin_port=$this->row['origin_port'];
	$destination_port=$this->row['destination_port'];
	$veh_type=$this->row['vehicle_type'];
	$vat_percent=$this->row['vat_percent'];
}



?>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="media/system/select2/theme/dist/select2-bootstrap.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<?php /*?><?php */ ?>
<style>
.form-row>div 

</style>
<div class="table-responsive">
<div class="com-head">
</div><div class="form-group">
	<form class="form-inline" id="mainForm" method="post" name="frm" action="?com=shipping&view=price_list&task=json<?php if($this->id){echo '&id=' .$this->id;}?>">
		<fieldset class="form">
			<div class="form grid"><?php if(isset($this->row['id'])){?>
			<input type="hidden" name="id" value="<?php echo $this->row['id'];?>" /><?php } ?>
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />

			<div class="form-row py-sm-2 mb-0">
			
				<div class="form-group col-sm-8">
					<input class="form-control title frm_input" id="title" name="title" type="text" style="min-width:500px;" value="" required readonly />
				</div>
			</div>
			<div class="form-row py-sm-2 mb-0">
				<div class="col-sm-5 select2-wrapper">
				<div class="form-group">
				<div class="input-group input-group-sm">
				<span class="input-group-addon">Desti. Port:</span>
				<select class="custom-select destination_port select2 frm_input" name="destination_port" required><?php
					if(!$destination_port){echo '<option value="">Select port..</option>';}
					foreach($this->dest_ports as $dp){
						$sel='';
						if($destination_port==$dp['id']){
							$sel='selected="selected"';
						}
						if(!$origin_port || !$destination_port || $sel){
							echo "<option value='{$dp['id']}' " . $sel . " >{$dp['title']}</option>";
						}
					}
				?>
				</select>
			</div>
			</div>
			</div>
			</div>

			<div class="form-row py-sm-2 mb-0">
				<div class="col-sm-4 select2-wrapper">
				<div class="form-group">
				<div class="input-group input-group-sm">
				<span class="input-group-addon">Origin Port:</span>
					<select class="custom-select mr-sm-2 origin_port frm_input" name="origin_port" required><?php
					if(!$origin_port){echo '<option value="">Select port..</option>';}
					//if($origin_port){
						foreach($this->origin_ports as $op){
							$sel='';
							if($origin_port==$op['id']){
								$sel='selected="selected"';
							}
							if(!$origin_port || !$destination_port || $sel){
								echo "<option value='{$op['id']}' " . $sel . " >{$op['title']}</option>";
							}
						}
					//}
					?></select>
				</div></div></div>
				
				<div class="col-sm-5 select2-wrapper margin-left">
				<div class="form-group">
				<div class="input-group input-group-sm">
				<span class="input-group-addon">Veh. Type:</span>
				<select name="vehicle_type" id="vehicle_type" class="form-control vehicle_type frm_input" required>
					<option value="">Select...</option><?php
						foreach($this->veh_types as $k => $v){
							$sel='';
							if($k == $veh_type){$sel='selected="selected"';}
							echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
						}
					?></select></div></div></div>
			</div>
			<div class="form-row py-sm-2 mb-0">
				<div class="form-group col-sm-4">
				<div class="input-group input-group-sm">
				<div class="input-group-prepend">
				<span class="input-group-text">Shipping:</span>
				</div>
				<input name="shipping" type="number" step="any" class="form-control sum shipping frm_input" value="<?php echo $shipping;?>" required />
				</div>
				</div>
				<div class="form-group col-sm-4">
				<div class="input-group input-group-sm">
				<div class="input-group-prepend">
				<span class="input-group-text">Service:</span>
				</div>
				<input name="service_charge" type="number" step="any" class="form-control sum frm_input" value="<?php echo $service_charge;?>" required />
				</div>
				</div>
			</div>
			<div class="form-row py-sm-2 mb-0">
			
			
				<div class="form-group col-sm-4">
				<div class="input-group input-group-sm">
				<div class="input-group-prepend">
				<span class="input-group-text">Clearance:</span>
				</div>
					<input name="clearance" type="number" step="any" class="form-control sum frm_input" value="<?php echo $clearance;?>" required />
				</div>
				</div>
				<div class="form-group col-sm-4">
				
				<div class="input-group input-group-sm">
				<div class="input-group-prepend">
				<span class="input-group-text">Total:</span>
				</div>
				<input type="number" step="any" class="form-control sum_result frm_input" value="<?php echo $shipping+$service_charge+$clearance;?>" readonly />
				
				</div>
				</div>
			</div>
			
			<div class="form-row py-sm-2 mb-0">
			</div><hr/>
			
			<div class="btn-group">
				<span><button type="submit" id="save" class="btn btn-success btn-flat btn-sm" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="index.php?com=shipping&view=prices_list" class="btn btn-info btn-flat btn-sm" tabindex="-1" ><i class="fa fa-list"></i> Prices List</a></span>
				<span><a href="javascript:void(0);" id="newRecord" class="btn btn-primary btn-flat btn-sm" tabindex="-1" ><i class="fa fa-plus"></i> New</a></span>
			</div>
			</div>
			</div>
		</fieldset>
	</form>
</div>

<script>
(function(){
	setTitle();
})();
$("input").change(function(){
  $('.sum_result').val(calcTotal());
});
/*$(".origin_city").change(function(){
	var city = $(this).val();
	if(!city){
		$(".origin_port").html('');
		return;
	}
	console.log(city);
	$.ajax({
	method: "POST",
	url: "index.php?com=shipping&view=ports&task=json",
	data: { 
	city: city, 
	action:'getCityPorts'
	}
	})
	.done(function( response ) {
		console.log(response.data);
		if(response){
			//var row_id=1;
			var options = '<option value="">Select...</option>';
			$.each(response.data, function(i,v){
				options += addSelOption(v.id, v.title, '')
			});
			//getTowing();
			//console.log(options);
			$(".origin_port").html(options);
		}
	});
	calcTotal();
});*/

$(".origin_port").change(function(){
		getTowing();
});

$(".vehicle_type").change(function(){
		getTowing();
});
	


function addSelOption(v_val, v_text, selected){
	calcTotal();
	var selected = selected || 0;
	var js ="";
	sel_text='';
	if(selected==v_val){
		sel_text = 'selected="selected"';
	}
		var html = '<option ' + sel_text + ' value="' + v_val + '">' + v_text + '</option>';
		return html;
	
}

function getTowing(){
	calcTotal();
	//var city = $("select.origin_city").val();
	var port = $("select.origin_port").val();
	var v_type = $("select.vehicle_type").val();
	//console.log(port + ' ' + v_type)
	
	/*$.ajax({
		url : 'index.php?com=shipping&view=port_cities&task=json',
		type: 'get',
		data : {
			city:city,
			port:port,
			v_type:v_type
		}
	}).done(function(res){
		if(res.error){
			showMsg('<div class="alert alert-warning">Select Origin Port, City and Vehicle type</div>','msg_modal');
			//$(".towing").val(null);
		}else{
			//showMsg('<div class="alert alert-info">' + res.data.message + '</div>');
			$(".towing").val(res.data.charges);
			//$(".towing").hide();
		}
		//console.log($(res));
	});*/
 
	
	
}

$( "#mainForm" ).submit(function(event) {
	calcTotal();
	//console.log('kskdkjdskf');
	event.preventDefault();
	var post_url = $(this).attr("action");
	//var request_method = $(this).attr("method");
	var form_data = $(this).serialize();
	console.log(form_data);
	console.log(post_url);
	
	$.ajax({
		url : post_url,
		type: 'post',
		data : form_data
	}).done(function(res){ //
		console.log(res);
		if(res.error){
			showMsg('<div class="alert alert-danger">' + res.error.message + '</div>','msg_modal');
		}else{
			showMsg('<div class="alert alert-info">' + res.data.message + '</div>','msg_modal');
			//location.reload();
		}
	});
 
});

$("#newRecord").click(function(){
	var frm = $('#mainForm');
  clearForm(frm);
});

function clearForm(frm){
	//$('select').val('');
	//$("[name='vehicle_type']").val(''); //load....
	$("[name='origin_port']").html('<option value="">Select...</option>');
	$("[name='vehicle_type']").val('');
	//$('.towing').val('');
	$('.shipping').val('');
	$("[name='service_charge']").val('');
	$("[name='clearance']").val('');
	$('.clearance').val('');
	$('.total_charge').val('');
	$("[name='action']").val('add');
	$("[name='id']").val('');
}

function calcTotal(){
	setTitle();
	var vSum = eval(sumFields());
	//var vat_p_raw = eval(document.getElementById('vat_percent').value);
	var vat_amount = 0;
	var result = 0;
	//$vat_amount=vat_p_raw+100 ; //* vSum;
	//result = vSum+vat_amount;
	//console.log(vSum);
	return vSum;
}

function setTitle(){
	var city = $("select.origin_city option:selected").text();
	var port = $("select.origin_port option:selected").text();
	var v_type = $("select.vehicle_type option:selected").text();
	var d_port = $("select.destination_port option:selected").text();
	$("#title").val(city.trim() + ' ' + port.trim() + ' ' + v_type.trim() + ' ' + d_port.trim());
}

$(".select2" ).select2({
	theme: "bootstrap",
	//width: '100%'
});


</script>

