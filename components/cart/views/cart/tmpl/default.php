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

$db=Core::getDBO();

$app = Core::getApplication();
function check_broadcast($value,$id){
	global $db;
	//$expiry_date=$db->load_by_sql('SELECT expiry FROM subscription_history WHERE user={$id}');
	//$expiry_date=$expiry_date['expiry'];
	if($value == 2){
		echo "<button onClick='broadcast({$id}, this)' 
class='btn btn-xss btn-broadcast btn-primary' data-id='{$id}'>" . Localize::_('broadcast') . "</button>
<button class='btn btn-xss btn-retract btn-warning' onClick='retract({$id},this)'
 data-id='{$id}' disabled>" . Localize::_('retract') . "</button>
<button class='btn btn-xss btn-remove btn-danger'
 onClick='remove({$id},this)' id='{id}']>" . Localize::_('remove') . "</button>";
	}
if($value == 1 || $value == 3 ){
		echo "<button class='btn btn-xss btn-broadcast btn-primary' onClick='broadcast({$id}, this)' data-id='{$id}' disabled>
" . Localize::_('broadcast') . "</button>
<button class='btn btn-xss btn-retract btn-warning'
onClick='retract({$id},this)' data-id='{$id}'>" . Localize::_('retract') . "</button>
<button class='btn btn-xss btn-remove btn-danger'
 onClick='remove({$id},this)' id='{id}']>" . Localize::_('remove') . "</button>";
	}
}


?>
<!-- Datatables -->
 <link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!--<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>-->
 
 
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<style>
td { vertical-align:middle !important; }
</style>
<div class="user_inventory">
<div class="btn-group"><a class="btn btn-primary btn-lg" href="<?php echo Route::_('index.php?com=vehicles&view=vehicle&task=edit');?>"><?php echo Localize::_('New Vehicle'); ?></a></div>
<table class="table table-striped table-bordered datatable table-hover">
<thead style="font-size:.8em;">
<tr>
<!--<th>ID</th>-->
<th><?php echo Localize::_('vehicle'); ?></th>
<th><?php echo Localize::_('owner'); ?></th>
<th><?php echo Localize::_('model'); ?></th>
<th><?php echo Localize::_('make'); ?></th>
<th><?php echo Localize::_('transmission'); ?></th>
<th><?php echo Localize::_('mileage'); ?></th>
<th><?php echo Localize::_('image'); ?></th>
<th><?php echo Localize::_('action'); ?></th>
</tr>
</thead>
<tbody>
<?php //$all_inventory=$db->load('vehicles');
foreach($this->rows as $value)://for($a=1;$a<=100;$a++): ?>
<tr id="<?php echo $value['id']?>">
<td><a href="?com=vehicles&view=vehicle&task=edit&id=<?php echo $value['id']?>"><?php echo $value['title']?></a></td>
<td><?php echo $value['owner_name'];?></td>
<td><?php echo $value['yearfull'];?></td>
<td><?php echo $value['make_name'];?></td>
<td><?php echo $value['tra_name'];?></td>
<td><?php echo $value['mileage'] ?></td><?php
$sql="SELECT m.*, vim.vehicle_id FROM vehicles_image_media AS vim
INNER JOIN media AS m ON (m.id = vim.media_id)
WHERE vim.vehicle_id={$value['id']} LIMIT 1";

	$vehicle_image=$db->get_by_sqlRows($sql);
	if($vehicle_image){
		foreach($vehicle_image as $value_image):
		?><td><img src="<?php echo $value_image['img_thumb']?>" width="80" height="45" alt="motor"></td><?php
		endforeach;
	}else{
		echo '<td></td>';
	}
?><td>
<?php check_broadcast($value['visibility'],$value['id']);?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<script>
$(function(){$('.datatable').dataTable({dom: 'Bfrtip',responsive: true,buttons: ['copy', 'excel', 'pdf', 'print'],pageLength: 25,});});


function remove(id){
if(confirm('Are you sure you want to remove this vehicle from inventory?')){
	$.ajax({
		url:'index.php?com=vehicles&view=vehicle',
		data:{id:id,action:'remove'},
		type:'POST',
		success: function(data){
			$('tr#'+id).fadeOut('slow');
			//console.log(data);
			}
		});
}
}
function broadcast(id, btn){
	//alert(id); return false;
//	if(confirm('Are you sure you want to broadcast this vehicle?')){
	var b = $(btn);
	var msg = $('#messages');
	var cl_btn = $(btn).closest('td').find(".btn-retract");

	
	//$(cl_btn).attr("disabled", false);
	$.ajax({
		url:'index.php?com=vehicles&view=vehicles',
		data:{id:id,action:'broadcast'},
		type:'POST',
		success: function(data){
			//console.log(data);
			if(!data.data || !data.error){
				//data=JSON.parse(data);
			}
			$(msg).show();
			$(msg).css('opacity',1);
				//console.log(data);
			if(data.error){
				$(msg).html('<div class="alert alert-danger">' + data.error.msg + '</div>').stop().fadeOut(8000);
				//.alert-success, .alert-info, .alert-warning or .alert-danger
			}else if(data.data && data.data.updated){	//data.updated
				$(msg).html('<div class="alert alert-success">Vehicle has been broadcasted</div>').stop().fadeOut(8000);
				$(cl_btn).attr("disabled",false);
				$(b).attr("disabled", true);
			}else{
				$(msg).html('<div class="alert alert-warning">Vehicle has not been broadcasted</div>').stop().fadeOut(8000);
			}
		}
		});
//}
}

function retract(id, btn){
	//alert(id); return false;
//	if(confirm('Are you sure you want to broadcast this vehicle?')){
	var msg = $('#messages');
	var b = $(btn);
	var cl_btn = $(btn).closest('td').find(".btn-broadcast");
	$.ajax({
		url:'index.php?com=vehicles&view=vehicles',
		data:{id:id,action:'retract'},
		type:'POST',
		success: function(data){
			if(!data.data || !data.error){
				//data=JSON.parse(data);
			}
			//console.log(data);
			$(msg).show();
			$(msg).css('opacity',1);
			if(data.error){
				//$(b).attr("disabled", true);
				//$(cl_btn).attr("disabled",false);
				$(msg).html('<div class="alert alert-danger">' + data.error.msg + '</div>').stop().fadeOut(8000);
			}else if(data.data && data.data.updated){ //data.updated
				$(cl_btn).attr("disabled",false);
				$(b).attr("disabled", true);
				$(msg).html('<div class="alert alert-success">Vehicle has been retracted</div>').stop().fadeOut(8000);
			}else{
				$(msg).html('<div class="alert alert-warning">Vehicle not retracted</div>').stop().fadeOut(8000);

			}
		}
		});
//	}

	
}
</script>