<?php
defined('_MEXEC') or die ('Restricted Access');


?><div class="vehicles_inventory">
<h4 class="veh_headings"><span class="inventory_headings">New Vehicles</span>
<a href="#" class="btn btn-sm btn-warning">View All</a></h4>
<div class="vehicles_list">
<ul>
<?php 
$a=1;
while($a<=4): ?>
<li>
<div class="single_vehicle" id="single_vehicle<?php echo $a?>">
<a href="vehicle_details.php">
<img class="cmpr" src="assets/images/vehicle.jpg">
</a>
<div class="veh_info">
<div style="width:60%; float:left;">
<span class="veh_title">bmw 5351, navi</span>
<span class="veh_desc">leather, abs</span>
</div>
<div class="price_div">
<span class="price">$25,000</span>
</div>
</div>
<span class="digit_info">44/47</span>
<span class="transmission">automatic</span>
<span class="comparison_link" id="<?php echo $a ?>">compare</span>
</div>
</li>
<?php $a++;
endwhile; ?>
</ul>
</div>
</div>
<script>
$(function(){
	
	var i=0;
	$('.comparison_link').click(function(){
		alert(5465465);
		i++;
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
				$('.dynamic_comp_ref').empty();
$('a.compre_vehicle_link').append('<span class="dynamic_comp_ref">'+ i +'</span>');
var total_count=$('.dynamic_comp_ref').text();
total_count=parseInt(total_count);
var iterations=check_existing_comparison(total_count);
if(iterations == 3 )
{
	$('.comparison_link').remove();
}
//alert(total_count);
				});
		});
	});
</script>


