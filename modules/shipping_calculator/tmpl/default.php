<?php
defined('_MEXEC') or die ('Restricted Access');

?>
<div class="module_shippingcalculator"> 
<div class="search"> 
<h3><?php echo Localize::_('shipping_calculator');?></h3>
<form name="shipping_calculator">
<div class="calculator_left">
<div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('origin_country');?>:</label>
<select id="origin_country" name="origin_country" class="my_form_select"><option value="0">Select...</option><?php 
echo HtmlForm::htmlSelectOptions($countries_o,0);
?></select></div><div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('origin_state_city');?>:</label>
<select name="origin_state" class="my_form_select">
<option value="">Select State/City</option>
</select>
</div>
<div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('origin_port');?>:</label>
<select name="origin_port" class="my_form_select">
<option value="">Select Port</option>
</select>
</div>
<div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('vehicle_type');?>:</label>
<select name="vehicle_type" class="my_form_select vehicle_type"><?php
foreach($vehicle_types as $key => $val){
echo '<option value="' . $key . '">' . $val . '</option>';
}
?></select>
</div>
<div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('dest_country');?>:</label>
<select name="destination_country" class="my_form_select destination_country"><option value="0">Select...</option><?php
echo HtmlForm::htmlSelectOptions($countries_d);
?>
<?php /* ?><?php */ ?>
</select>
</div>
<div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('dest_port');?>:</label>
<select name="destination_port" class="my_form_select">
<option value="">Select...</option>
</select>
</div>
<div  style="float:right">
<button type="button" onClick="reset_all()" class="btn btn-sm btn-danger"><?php echo Localize::_('reset');?></button>
<button type="button" class="btn btn-sm btn-primary" onClick="calculate_charges()"><?php echo Localize::_('calculate');?></button>
</div>
</div>
<div class="calculator_right">
<div class="control_separator">
<label class="my_form_label"><?php echo Localize::_('shipping');?>:</label><input type="text" class="my_form_text" name="shipping_charge" value=""></div>
<div class="control_separator"><label class="my_form_label"><?php echo Localize::_('towing');?>:</label><input type="text" class="my_form_text" name="towing_charge" value=""></div>
<div class="control_separator"><label class="my_form_label"><?php echo Localize::_('services');?>:</label><input type="text" class="my_form_text" name="service_charge" value=""></div>
<div class="control_separator"><label class="my_form_label"><?php echo Localize::_('clearance');?>:</label><input type="text" class="my_form_text" name="clearance_charge" value=""></div>
<div class="control_separator"><label class="my_form_label"><?php echo Localize::_('total');?>:</label><input type="text" class="my_form_text" name="total_charge" value=""></div>

</div>
</form>
</div>
</div>
<script>
function reset_all(){
var all_states="<option value=''>Select State/City</option>";
var all_ports="<option value=''>Select Port</option>";
$("#origin_country").val(0);
$('select[name="destination_country"]').val(0);
//$('select[name="origin_country"]').html(all_countries);
$('select[name="origin_state"]').html(all_states);
$('select[name="origin_port"]').html(all_ports);
$('form[name="shipping_calculator"]').find('input[type="text"]').val("");
}
</script>
<script>
$(function(){
	$('select[name="origin_country"]').change(function(){
		$('form[name="shipping_calculator"]').find('input[type="text"]').val("");
		var country=$(this).val();
		$.ajax({
			//url:'calculate_charges.php',
			url:'index.php?com=lists&view=cities&task=json',
			type:'POST',
			//data:{country:country,action:'load_states'},
			data:{country:country},
			success:function(data){
				//console.log(data);
				var obj = data;
				var html = '<option value="">Select State/City</option>';
				$.each(obj, function(i, v) {
					html = html + '<option value="' + v.id + '">' + v.title + '</option>';
				});
				$('select[name="origin_state"').html(html);
			}
			});
			
			
		$('form[name="shipping_calculator"]').find('input[type="text"]').val("");
		//var city=$(this).val();

		$.ajax({
			url:'index.php?com=shipping&view=ports&task=json',
			type:'GET',
			data:{country:country},
			success:function(data){
				
				//console.log(data);
				//var obj = JSON.parse(data);
				var obj = data;
				var html = '<option value="">Select Port</option>';
				$.each(obj.data, function(i, v) {
					html = html + '<option value="' + v.id + '">' + v.title + '</option>';
				});
				
				$('select[name="origin_port"').html(html);
				//console.log(html);
			}
			});
		});
	});
	
$(function(){
	$('select[name="origin_state"]').change(function(){
		});
	});
	
function calculate_charges(){
	var country=$('select[name="origin_country"]').val();
	var state=$('select[name="origin_state"]').val();
	var port=$('select[name="origin_port"]').val();
	var dest_port=$('select[name="destination_port"]').val();
	var vehicle_type=$('select[name="vehicle_type"]').val();
	var dest_country=$('select[name="dest_country"]').val();
	var dest_port=$('select[name="dest_port"]').val();
	if(country == 0){
		alert("No Origin Country selected");return false;
	}else if(state == ""){
		alert("NO Origin City selected");return false;
	}else if(port == ""){
		alert("No Origin Port selected");return false;
	}else if(vehicle_type == ""){
		alert("No Vehicle Type selected");return false;
	}else if(dest_country == 0){
		alert("No Destination Country selected");return false;
	}else if(dest_port == ""){
		alert("No Destination Port selected");return false;
	}
	var total = 0;
	$.ajax({
	url:'index.php?com=shipping&view=price_list&task=json',
	//dataType:"JSON",
	type:'GET',
	data:{
		port:port,
		origin_city:state,
		veh_type:vehicle_type,
		dest_port:dest_port
	},
	success:function(data){
		clearForm();
		if(data.error){
			showMsg('<div><span class="alert alert-warning">' + data.error.message + '</span></div>','messages',5000);
			return false;
		}
		var obj = data.data[0];
		/*if(obj){
			//obj=obj.data[0];
			$.each(obj, function( index, value ) {
				obj = value;
			});
		}*/
		if(obj){
			if(obj.shipping){
				$('input[name="shipping_charge"]').val('$ ' +obj.shipping);
				total += eval(obj.shipping);
			}else{
				//$('input[name="shipping_charge"]').val('');
			}
			if(obj.charges){
				$('input[name="towing_charge"]').val('$ ' +obj.charges);
				total += eval(obj.charges);
			}else{
				//$('input[name="towing_charge"]').val('');
			}
			if(obj.clearance){
				$('input[name="clearance_charge"]').val('$ ' +obj.clearance);
				total += eval(obj.clearance);
			}else{
				//$('input[name="clearance_charge"]').val('');
			}
			if(obj.service_charge){
				$('input[name="service_charge"]').val('$ ' +obj.service_charge);
				total += eval(obj.service_charge);
			}else{
				//$('input[name="service_charge"]').val('');
			}
			//if(obj.shipping){
				$('input[name="total_charge"]').val('$ ' +total);
				if(total==0){
					showMsg('<div><span class="alert alert-warning">Prices Not defined!!!</span></div>','messages',2000);
				}
			//}
		}
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
			alert(xhr.responseText);
}
	});
	
	
	$.ajax({
	url:'index.php?com=shipping&view=port_cities&task=towing',
	//dataType:"JSON",
	type:'GET',
	data:{
		port_id:port,
		city_id:state,
		veh_type:vehicle_type,
	},
	success:function(data){
		console.log(data);
		//clearForm();
		if(data.error){
			showMsg('<div><span class="alert alert-warning">' + data.error.message + '</span></div>','messages',5000);
			return false;
		}
		var obj = data.data;
		if(obj){
			if(obj.charges){
				$('input[name="towing_charge"]').val('$ ' +obj.charges);
				total += eval(obj.charges);
			}else{
				//$('input[name="towing_charge"]').val('');
			}
			//if(obj.shipping){
				$('input[name="total_charge"]').val('$ ' +total);
				if(total==0){
					showMsg('<div><span class="alert alert-warning">Prices Not defined!!!</span></div>','messages',2000);
				}
			//}
		}
		},
		error: function(xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);
			alert(xhr.responseText);
}
	});
	
}


function clearForm(){
	$('input[name="shipping_charge"]').val('');
	$('input[name="towing_charge"]').val('');
	$('input[name="clearance_charge"]').val('');
	$('input[name="service_charge"]').val('');
	$('input[name="total_charge"]').val('');
}

$(function(){
	$('select[name="destination_country"]').change(function(){
		$('form[name="destination_country"]').find('input[type="text"]').val("");
		var country=$(this).val();
		//console.log(country);
		$.ajax({
			url:'index.php?com=shipping&view=ports&task=json',
			type:'GET',
			data:{country:country},
			success:function(data){
				//console.log(data);
				var obj = data.data;
				var html = '<option value="">Select Port</option>';
				$.each(obj, function(i, v) {
					html = html + '<option value="' + v.id + '">' + v.title + '</option>';
				});
				$('select[name="destination_port"').html(html);
			}
			});
		});
	});
	
</script>