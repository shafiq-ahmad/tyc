<?php
defined('_MEXEC') or die ('Restricted Access');
//var_dump($this->rows);exit;

//var_dump($this->rows);exit;

$db=Core::getDBO();
?><div class="vehicles_inventory">
<h4 class="veh_headings"><span class="inventory_headings"><?php echo Localize::_('vehicles');?></span>
<div class="vehicles_list">
<ul>
<?php
//$sql="SELECT * FROM vehicles WHERE visibility=1 AND vehicle_condition=1 LIMIT 4";
//$latest_vehicles=$db->get_by_sqlRows($sql); 
foreach($this->rows as $value):
$url = Route::_('?com=vehicles&view=vehicle&id=' . $value['id']);

?>
<li>
<div class="single_vehicle" id="single_vehicle<?php echo $value['id']?>">
<a href="<?php echo $url;?>" style="margin-bottom:.2em;">
<?php 
$v_sql = "SELECT m.* FROM media AS m ";
$v_sql .= "INNER JOIN vehicles_image_media AS vim ON (m.id = vim.media_id) ";
$v_sql .= "WHERE vim.vehicle_id={$value['id']} LIMIT 1";

$vehicle_image=$db->get_by_sqlRows($v_sql);

foreach($vehicle_image as $veh_img){?>
<img class="cmpr" src="<?php echo $veh_img['img_mobile']?>"">
<?php } ?>
</a>
<div class="veh_info">
<div style="width:60%; float:left;">
<span class="veh_title"><?php echo $value['title']?></span>
<span class="veh_desc"><?php echo $value['model']?></span>
</div>
<div class="price_div">
<span class="price">$<?php echo $value['price']?></span>
</div>
<a class="add_towatch_list" href="#" onClick="add_towatch(this.id)" id="<?php echo $value['id']?>">
<?php echo Localize::_('add_to_watchlist');?></a>
</div>
<span class="digit_info"><?php echo $value['mileage']?></span><?php
$tr=$db->loadTable('transmission',"id='{$value['transmission']}'");
$title='';
if($tr){
	$title=$tr[0]['title'];
}
?><span class="transmission"><?php echo $title;?></span>
<span class="comparison_link" id="<?php echo $value['id']?>"><?php echo Localize::_('compare');?></span>
</div>
</li> 
<?php endforeach; //} ?>
</ul>
</div>
</div>
<script>
$(function(){
	
	var i=0;
	$('.comparison_link').click(function(){
		i++;
		var item=$(this);
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
				$(this).remove(); $(item).remove();
				//alert('Vehicle Added For comparison');
				$('.dynamic_comp_ref').empty();
$('a.compre_vehicle_link').append('<span class="dynamic_comp_ref">'+ i +'</span>');
var total_count=$('.dynamic_comp_ref').text();
total_count=parseInt(total_count);
/*var iterations=check_existing_comparison(total_count);
if(iterations == 3 )
{
	$('.comparison_link').remove();
}*/
$.ajax({       /****add vehicle to db for comparision****/
	url:'index.php?com=vehicles&view=vehicles',
	data:{id:id, 'action':'addCompare'},
	type:'POST'
	});
});
});
});
</script>
<script>
function add_towatch(id)
{
	$.ajax({
		url: 'operations.php',
		type:'POST',
		data:{id:id,'action': 'add_towatch'},
		success: function(data)
		{
			alert('Added to your watchlist');
		}
		});
}
</script>


