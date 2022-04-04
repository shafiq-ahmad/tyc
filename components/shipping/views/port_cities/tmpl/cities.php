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
$city_id=0;
$port_id=0;
$veh_type=0;
$charges=null;
$action='add';
if(isset($this->row['id'])){
	$id=$this->row['id'];
	$action='update';
	$charges=$this->row['charges'];
	$port_id=$this->row['port_id'];
	$city_id=$this->row['city_id'];
	$veh_type=$this->row['vehicle_type'];
}
if(!$port_id){
	$port_id=$this->port['id'];
}

if(!$port_id){
	//$this->redirect('?com=shipping&view=ports');
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
<h2>Assigned cities</h2>
<div class="btn-group">
	<span><a href="index.php?com=shipping&view=port_cities&task=cities&port_id=<?php echo $this->row['id'];?>" class="btn btn-info btn-flat btn-sm" tabindex="-1"><i class="fa fa-circle-o"></i> Assign New City</a></span>
</div>
<h4>Port: <?php 
//var_dump($this->port);exit;
echo $this->port['title'];?></h4>
</div>

<div class="form-group">
	<form class="form-inline" method="post" name="frm" action="">
		<fieldset class="form">
			<div class="form grid">
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			<input type="hidden" name="port_id" value="<?php echo $port_id;?>" />
			<input type="hidden" name="action" value="<?php echo $action; ?>" />
			<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />
			<div class="form-row py-sm-2 mb-0">
				<div class="form-group col-sm-8">
					<input class="form-control title frm_input" id="title" name="title" type="text" style="min-width:500px;" value="" required readonly />
				</div>
			</div>
			<div class="form-row">
				<div class="col-sm-6 select2-wrapper">
				<div class="form-group">
				<div class="input-group">
				<span class="input-group-addon">City: </span>
				<select name="city_id" id="city_id" class="form-control select2 city_id frm_input"><option value="">Select...</option><?php
					echo HtmlForm::htmlSelectOptions($this->cities, $city_id, 'city_id');
				?></select></div></div>
				</div>
			</div>
  
			<div class="form-row py-sm-3 mb-0">
				
				
				<div class="col-sm-5 select2-wrapper">
				<div class="form-group">
				<div class="input-group"><span class="input-group-addon">Veh. Type: </span>
				<select name="vehicle_type" id="vehicle_type" class="form-control frm_input"><option value="1">Select...</option><?php
					foreach($this->veh_types as $k => $v){
						$sel='';
						if($k == $veh_type){$sel='selected="selected"';}
						echo '<option value="' . $k . '" ' . $sel . '>' . $v . '</option>';
					}
				?></select></div></div></div>
				<div class="form-group col-sm-5">
				<div class="input-group">
				<div class="input-group-prepend">
				<span class="input-group-text">Charges:</span>
				</div>
				<input name="charges" type="number" step="any" class="form-control frm_input" value="<?php echo $charges; ?>" required />
				</div>
				</div>
			</div>
			<div class="btn-group">
				<span><button type="submit" id="save" class="btn btn-success btn-flat btn-sm" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				<span><a href="index.php?com=shipping&view=ports" class="btn btn-info btn-flat btn-sm" tabindex="-1" ><i class="fa fa-list-ol"></i> Ports</a></span>
			</div>
			</div>
			</div>
		</fieldset>
	</form>
</div>
<hr/>
<h3>Assigned Cities</h3>

	<table id="data-table" class="table">
		<thead>
		<tr><th>ID#</th><th>City</th><th>Vehicle Type</th><th>Charges</th><th>Actions</th></tr>
		</thead>
		<tbody id="tblContentBody"><?php
		//var_dump($this->port_cities);exit;
		if($this->port_cities){
			$veh_types = array(1=>'Regular',2=>'Bike', 3=>'Big Pickup');
			foreach ($this->port_cities as $row){
		?><tr <?php
		if($this->id==$row['id']){echo ' class="active"';}
		echo ' id="id-' . $row['id'] . '"';
		?>><?php 
			echo '<td class="id">' . $row['id'] . '</td>';
			echo '<td class="city">' . $row['city'] . '</td>'; 
			echo '<td class="vehicle_type">' . $veh_types[$row['vehicle_type']] . '</td>'; 
			echo '<td class="charges">' . $row['charges'] . '</td>';
			$edit_link = "index.php?com=shipping&view=port_cities&task=cities&id={$row['id']}&port_id={$port_id}";
			echo '<td>'; 
				//echo '<a class="btn btn-info btn-sm" data-remote="false" data-toggle="modal" data-target="#myModal" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
				echo '<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=shipping&view=port_cities&task=cities&id={$row['id']}&port_id={$port_id}";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			//}
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
	setTitle();
})();

$("#city_id").change(function(){
	setTitle();
});

$("#vehicle_type").change(function(){
		setTitle();
});

function setTitle(){
	var city = $("#city_id option:selected").text();
	var port = <?php echo "'" . $this->port['title'] . "'";?>;
	var v_type = $("#vehicle_type option:selected").text();
	$("#title").val(city.trim() + ' ' + port.trim() + ' ' + v_type.trim());
}

$("select.select2" ).select2({
	theme: "bootstrap"
});
</script>

