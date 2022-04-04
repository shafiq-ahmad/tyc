<?php
defined('_MEXEC') or die ('Restricted Access');

?><?php /* ?><div class="com-head">
	<h3>{branch name} Articles</h3>
</div>
<div class="com-head">
	<div class="text-right"><a href="?com=articles&view=articles" title="New Article">All Articles</a></div>
</div><?php */ ?>
<div class="form"><?php
	/*$list = array();
	$list['view']='branch_article';
	$list['task']='edit';
	$view = $this->getView('branch_article', 'articles', 'edit');
	echo $view->display($list);*/
?></div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<div>
			<?php /* ?><div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date'];}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date'];}?>" tabindex="-1" />
				<input type="submit" name="search_date" class="btn btn-success screen" value="Search" />
			</div><?php */ ?>
			<div class="filter hide">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>Item#</th><th>Title</th><th>Unit</th>
			<th>Cost Price</th><th>Sale Price</th><th>Stock</th><th>Cost Total</th><th>Amount</th><th>Profit</th><th>%</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
			$tr_class='';
			if($row['qty']<0){
				//$qty = abs($row['qty']);
				$qty = 0;
				$tr_class='neg-qty';
			}else{
				$qty =$row['qty'];
			}
			if($this->id==$row['article_code']){
				if($tr_class){
					$tr_class .= ' active';
				}else{
					$tr_class = 'active';
				}
			}
		?><tr class="<?php echo $tr_class; ?>"><?php 
			echo '<td>' . $row['article_code'] . '</td>'; 
			$stock_link = "?com=articles&view=stock_compare&id={$row['article_code']}";
			//echo '<td>' . '<a style="display:inline-block;line-height:16px;width:100%;" href="' . $stock_link . '">' . $row['title'] . '</a></td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['unit'] . '</td>'; 
			echo '<td>' . $row['cost_price'] . '</td>'; 
			$savings=0;
			if($row['sale_price']>0){
				$savings = $row['sale_price'] -($row['cost_price']+$row['discount']);
			}
			echo '<td>' . $row['sale_price'] . '</td>';
			echo '<td>' . $qty . '</td>'; 
			echo '<td>' . ($row['cost_price']*$qty) . '</td>'; 
			echo '<td>' . ($row['sale_price']*$qty) . '</td>'; 
			echo '<td>' . ($savings) . '</td>'; 
			$per = 0;
			if($row['sale_price']){
				$per = round($savings/$row['sale_price']*100);
			}
			echo '<td>' . $per . '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="5" style="text-align:right">Total:</th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="2"></th>
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
		.column(5)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total2 = api
		.column(6)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);
		total3 = api
		.column(7)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);
		total4 = api
		.column(8)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Total over this page
		pageTotal1 = api
		.column(5, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal2 = api
		.column(6, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal3 = api
		.column(7, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);
		pageTotal4 = api
		.column(8, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(5).footer()).html(
			total1.toFixed(1)
		);
		$( api.column(6).footer()).html(
			total2.toFixed(1)
		);
		$( api.column(7).footer()).html(
			total3.toFixed(1)
		);
		$( api.column(8).footer()).html(
			total4.toFixed(1)
		);
		}
		
	
	} );

	
	
})
</script>