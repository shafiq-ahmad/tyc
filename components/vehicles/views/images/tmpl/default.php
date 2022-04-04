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
		echo "<button onClick='broadcast(this.id)' 
class='btn btn-xss btn-broadcast btn-primary' value='{$id}'>
Broadcast</button>
<button class='btn btn-xss btn-broadcast disabled btn-warning'
 value='{$id}' disabled>Retract</button>
<button class='btn btn-xss btn-broadcast btn-danger'
 onClick='remove(this.id)' id='{id}']>Remove</button>";
	}
	if($value == 1 )
	{
		echo "<button class='btn btn-xss btn-broadcast btn-primary disabled' value='{$id}' disabled>
Broadcast</button>
<button class='btn btn-xss btn-broadcast btn-warning'
onClick='retract(this.id)' value='{$id}'>Retract</button>
<button class='btn btn-xss btn-broadcast btn-danger'
 onClick='remove(this.id)' id='{id}']>Remove</button>";
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
<table class="table table-striped table-bordered datatable table-hover">
<thead style="font-size:.8em;">
<tr>
<!--<th>ID</th>-->
<th>Vehicle</th>
<th>Owner</th>
<th>Model</th>
<th>Make</th>
<th>Transmission</th>
<th>Mileage</th>
<th>Image</th>
<th>Action</th>
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
<td><?php echo $value['mileage'] ?></td>
<?php $sql="SELECT media FROM vehicles_image_media WHERE vehicle_id={$value['id']} LIMIT 1"; 
	$vehicle_image=$db->get_by_sqlRows($sql);
	foreach($vehicle_image as $value_image):
	?><td><img src="media/images/vehicles/<?php echo $value_image['media']?>" width="80" height="45" alt="motor"></td><?php
	endforeach;
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


function remove(id)
{
if(confirm('Are you sure you want to remove this vehicle from inventory?'))
{
	$.ajax({
		url:'operations.php',
		data:{id:id,action:'remove_vehicle'},
		type:'POST',
		success: function(data){
			$('tr#'+id).fadeOut('slow');
			}
		});
}
}
function broadcast(id)
{
	//alert(id); return false;
	if(confirm('Are you sure you want to broadcast this vehicle?'))
{
	$.ajax({
		url:'operations.php',
		data:{id:id,action:'broadcast_vehicle'},
		type:'POST',
		success: function(data){
		alert('Vehicle has been broadcast');
			}
		});
}

	
}
</script>