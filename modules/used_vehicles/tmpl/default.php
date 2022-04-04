<?php
defined('_MEXEC') or die ('Restricted Access');


$db=Core::getDBO();
?><div class="vehicles_inventory">
<h4 class="veh_headings"><span class="inventory_headings"><?php echo Localize::_('used_vehicles');?></span>
<a href="<?php echo Route::_('index.php?com=vehicles&view=vehicles&used=2');?>" class="btn btn-sm btn-warning"><?php echo Localize::_('view_all');?></a></h4>
<div class="vehicles_list">
<ul>
<?php $sql="SELECT * FROM vehicles WHERE visibility=1 AND vehicle_condition=2 LIMIT 4";
//$ip=get_ip();
$used_vehicles=$db->get_by_sqlRows($sql);
foreach($used_vehicles as $value): ?>
<li>
<div class="single_vehicle" id="single_vehicle<?php echo $value['id']?>">
<a href="<?php echo Route::_('?com=vehicles&view=vehicle&id=' . $value['id']);?>">
<?php 
$v_sql = "SELECT m.* FROM media AS m ";
$v_sql .= "INNER JOIN vehicles_image_media AS vim ON (m.id = vim.media_id) ";
$v_sql .= "WHERE vim.vehicle_id={$value['id']} LIMIT 1";

$vehicle_image=$db->get_by_sqlRows($v_sql);
foreach($vehicle_image as $veh_img){?>
<img class="cmpr" src="<?php echo $veh_img['img_mobile']?>" srcset="<?php echo $veh_img['srcset']?>">
<?php } ?>
</a>
<div class="veh_info">
<div style="width:60%; float:left;">
<span class="veh_title"><?php echo $value['title']?></span>
<span class="veh_desc"><?php echo $value['model']?></span>
</div>
<div style="width:40%; float:right;">
<div class="price_div" style="width:100%;">
<span class="price">$<?php echo $value['price']?></span>
</div>
<a class="add_towatch_list" href="#" onClick="add_towatch(this.id)" id="<?php echo $value['id']?>">
<?php echo Localize::_('add_to_watchlist');?></a>
</div>
</div>
<span class="digit_info"><?php echo $value['mileage']?></span><?php
$tr=$db->loadTable('transmission',"id='{$value['transmission']}'");
$title='';
if($tr){
	$title=$tr[0]['title'];
}
?>
<span class="transmission"><?php echo $title;?></span>
<span class="comparison_link" id="<?php echo $value['id']?>"><?php echo Localize::_('compare');?></span>
</div>
</li>
<?php endforeach;

?>
</ul>
</div>
</div>
<script>
$(function(){
	var c=0;
	$('.comparison_link').click(function(){
		var id=$(this).attr('id');
		var container=$('#single_vehicle'+id+'');
		var ghost=$(this).siblings().find('img');
		new_duplicate=ghost.clone().appendTo(container).addClass('duplicate');
		var target=$('.compre_vehicle_link');
		var cmpcoords=new_duplicate.offset();
		var targetcoords=target.offset();
		new_duplicate.animate({
			'left': targetcoords.left - cmpcoords.left,
			'top': targetcoords.top - cmpcoords.top ,
			'width': '120px',
			'opacity': 0.5
			}, 1200, function(){
				$(this).remove();
				//alert('Vehicle Added For comparison');
				$('span.dynamic_comp_ref').appendTo(c++);
				});
		});
	});
</script>
