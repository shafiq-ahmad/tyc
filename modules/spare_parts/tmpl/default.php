<?php
defined('_MEXEC') or die ('Restricted Access');


?><div class="vehicles_inventory">
<h4 class="veh_headings"><span class="inventory_headings"><?php echo Localize::_('spare_parts');?></span><a href="view_all.php" class="btn btn-sm btn-warning btn-view-all"><?php echo Localize::_('view_all');?></a></h4>

<div class="vehicles_list">
<ul>
<?php $a=1;
while($a<=4): ?>
<li>
<div class="single_vehicle">
<a href="?com=vehicles&view=vehicle&id=1">
<img src="media/images/vehicle.jpg" class="cmpr">
</a>
<div class="veh_info">
<div style="width:60%; float:left;">
<span class="veh_title">bmw 5351, navi</span>
<span class="veh_desc">leather, abs</span>
</div>
<div style="width:40%; float:right;">
<div class="price_div" style="width:100%;">
<span class="price">$25,000</span>
</div>
</div>
</div>
<span class="digit_info">44/47</span>
<span class="transmission">automatic</span>
</div>
</li>
<?php $a++;
endwhile; ?>
</ul>
</div>
</div>

