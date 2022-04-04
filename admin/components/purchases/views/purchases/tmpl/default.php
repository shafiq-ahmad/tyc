<?php
defined('_MEXEC') or die ('Restricted Access');

?><div class="com-head">
	<h3>Purchases</h3>
	<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1"><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><a href="#" onclick="window.open('?com=purchases&view=purchase&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> New Purchase</a></span>
			</li>
			<li></li>
		</ul>
	</div>
</div>
<div class="form"><?php
?></div>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="purchases" />
			<input type="hidden" name="view" value="purchases" />
			<div>
			<div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input type="date" name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['start_date']));}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input type="date" name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['end_date']));}?>" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success screen btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			<div class="filter hide">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
			
		</form>
	</div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
	<table id="data-table" class="table nav-able">
		<thead>
		<tr>
			<th>Purchase date</th><th>Ref Inv.#</th><th>Supplier</th><th>Amount</th><th>Cash</th><th>Credit</th><th class="no-print">Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			$x=2;
			foreach ($this->rows as $row){
		?><tr <?php /*if($id==$row['purchase_id']){echo ' class="active"';}*/ ?>><?php 
			echo '<td>' . $row['purchase_date'] . '</td>'; 
			echo '<td>' . $row['ref_inv_no'] . '</td>';
			echo '<td>' . $row['supplier_title'] . '</td>'; 
			echo '<td>' . round($row['amount'],2) . '</td>'; 
			echo '<td>' . round($row['cash'],2) . '</td>'; 
			echo '<td>' . round($row['credit'],2) . '</td>'; 
			$stock_link = "?com=purchases&view=purchase&id={$row['purchase_id']}";
			//$delete_link = "?com=articles&view=article&task=delete&id={$row['article_code']}";
			echo '<td class="no-print">'; 
			echo '<a href="' . $stock_link . '" title="Edit" tabindex="-1"><i class="fa fa-edit"></i></a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>'; 
		?></tr><?php
		$x++;
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="3" style="text-align:right">Total:</th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
			</tr>
		</tfoot>
	</table>
</div>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable({
		dom: 'lfBrtip',buttons:['excel', 'pdf'],
		"footerCallback": function(row, data, start, end, display ) {
		var api = this.api(), data;

		// Remove the formatting to get integer data for summation
		var intVal = function (i) {
			return typeof i === 'string' ?
			i.replace(/[\$,]/g, '')*1 :
			typeof i === 'number' ?
			i : 0;
		};

		// Total over all pages
		total1 = api
		.column(3)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total2 = api
		.column(4)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);
		total3 = api
		.column(5)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(3).footer()).html(
			eval(total1).toFixed(2)
		);
		$( api.column(4).footer()).html(
			eval(total2).toFixed(2)
		);
		$( api.column(5).footer()).html(
			eval(total3).toFixed(2)
		);
		},
		paging:false
		
	} );

	
	
})
</script>