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

?><div class="com-head">
	<h3>Purchases return report by Item#</h3>
</div>

<div class="form"><?php
?></div>
<div class="table-responsive"><div id="search-date-range">
		<form method="post" action="?com=purchases&view=items_return_report" >
			<div>
			<div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_POST['start_date'])){ echo '-default';}?>" value="<?php if(isset($_POST['start_date'])){ echo $_POST['start_date'];}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_POST['end_date'])){ echo '-default';}?>" value="<?php if(isset($_POST['end_date'])){ echo $_POST['end_date'];}?>" tabindex="-1" />
				<input type="submit" name="search_date" class="btn btn-success screen" value="Search" />
			</div>
			<div class="filter">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="purchasesReportItems" class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th>Item#</th><th>Category</th><th>Title</th><th>Unit</th><th>Pur. Price</th>
			<th>Return Qty</th><th>Total Return</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6" style="text-align:right;"><b>Sub Total:</b></td>
				<td id="subTotal"><b>0</b></td><td id="subTotalMargin"><b>0</b></td>
			</tr>
		</tfoot>
		<tbody id="tblContentBody"><script>
	var json_data = <?php 
		echo json_encode($this->rows); 
	?>;
		//console.log(json_data);
		//var subTotal=0;
		//var subTotalMargin=0;
		$.each(json_data, function(i, v) {
			document.write('<tr>');
			document.write('<td class="article_code">'+v.article_code+ '</td>');
			document.write('<td class="cat">'+v.pcat_title + ' - ' + v.cat_title+'</td>');
			document.write('<td class="title">'+v.title+'</td>');
			document.write('<td class="unit">'+v.unit+'</td>');
			document.write('<td class="salePrice">'+eval(v.salePrice).toFixed(2)+'</td>');
			document.write('<td class="sumQty">'+eval(v.sum_qty).toFixed(2)+'</td>');
			document.write('<td class="total">'+eval(v.total).toFixed(2)+'</td>');
			//subTotal += eval(v.total);
			//document.write('<td class="margin">'+eval(v.margin).toFixed(2)+'</td>');
			//subTotalMargin += eval(v.margin);
			document.write('</tr>');
		});
		cals_reportItemsTotal();
		</script></tbody>
	</table>
	<table>
	<tbody>
	</tbody>
	</table>
</div><?php 
?>