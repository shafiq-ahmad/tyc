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
$vehicles = null;
$compare=null;
//var_dump($_SESSION['vehicles']);//exit;
if(isset($_SESSION['vehicles']['compare']) && $_SESSION['vehicles']['compare']){
	$compare = implode(',', $_SESSION['vehicles']['compare']);
	$sql = "SELECT v.*, ft.title AS fuelType, y.title AS yearName, t.title AS transName, d.title AS driveName, ";
	$sql .= "m.img_thumb,m.srcset FROM vehicles AS v ";
	$sql .= "INNER JOIN fuel_type AS ft ON (v.fuel_type = ft.id) ";
	$sql .= "INNER JOIN years AS y ON (v.year = y.id) ";
	$sql .= "INNER JOIN transmission AS t ON (v.transmission = t.id) ";
	$sql .= "INNER JOIN drive AS d ON (v.drive = d.id) ";
	$sql .= "LEFT JOIN media AS m ON (v.image_id = m.id) ";
	$sql .= "WHERE v.id IN ({$compare}) AND v.visibility = 1 LIMIT 3 ";
	$vehicles = $db->get_by_sqlRows($sql);
}




?>

<script>
function remove_compare(id){
	if(confirm('Are you sure you want to remove this vehicle from comparison')){
			$('#compare'+id).fadeOut(1000);
			$.ajax({
	url:'index.php?com=vehicles&view=vehicles',
	data:{id:id, 'action':'removeCompare'},
	type:'POST'
	});	
	}
}
</script>
<aside class="search_params left_sidebar"><aside class="comparison_params">
<div class="compare_heads">
<div class="comparison_header">
<h3>compare</h3>
<h3>Vehicles</h3>
<span>----</span>
</div>
</div>
<ul>
<li>body</li>
<li>mileage</li>
<li>fuel type</li>
<li>engine</li>
<li>year</li>
<li>transmission</li>
<li>drive</li>
<li>fuel economy</li>
<li>exterior color</li>
<li>interior color</li>
</ul>
</aside></aside>
<div class="site_contents">
<?php

if($vehicles){
foreach($vehicles as $v){
	//echo $v;
	//var_dump($v);exit;
?><section class="comparative_vehicle" id="compare<?php echo $v['id'] ?>">
<p class="remove_comparison" onClick="remove_compare(this.id)" id="<?php echo $v['id'] ?>">X</p>

<div class="compare_heads">
<div class="vehicle">
<div class="single_vehicle">
<a href="<?php echo Route::_('index.php?com=vehicles&view=vehicle&id=' . $v['id']);?>">
<img src="<?php echo $v['img_thumb']; ?>">
</a>
<div class="veh_info">
<div style="width:60%; float:left;">
<span class="veh_title"><?php echo $v['title'] ?></span>
<span class="veh_desc">leather, abs</span>
</div>
<div style="width:40%; float:right;">
<span class="price">$<?php echo $v['price'] ?></span>
</div>
</div>
</div>
</div>
</div>
<ul>
<li>&nbsp;</li>
<li><?php echo $v['title'] ?></li>
<li><?php echo $v['mileage'] ?></li>
<li><?php echo $v['fuelType'] ?></li>
<li><?php echo $v['engine'] ?></li>
<li><?php echo $v['yearName'] ?></li>
<li><?php echo $v['transName'] ?></li>
<li><?php echo $v['driveName'] ?></li>
<li><?php echo $v['fuel_economy'] ?></li>
<li><?php echo $v['exterior_color'] ?></li>
<li><?php echo $v['interior_color'] ?></li>
</ul>
</section>
<?php
}
}
?>
</div>


