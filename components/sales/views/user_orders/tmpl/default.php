<?php
defined('_MEXEC') or die ('Restricted Access');
$app = core::getApplication();
?>
<div id="com-wrapper" class="pull-left" style="max-width:80%;padding:0 20px;">
<link rel="stylesheet" href="media/system/DataTables/datatables.min.css"><div class="com-head">
<!-- DataTables -->
<script src="media/system/DataTables/datatables.min.js"></script>
	<h3>User Orders</h3>
</div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
<!-- bootstrap datepicker -->
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="sales" />
			<div>
			
			
			<!--<div class="input-group date">
			<div class="input-group-addon">
			<i class="fa fa-calendar"></i>
			</div>
			<input type="text" class="form-control pull-right" id="datepicker">
			</div>-->
			
			
			<div class="form-group date-range">
				<label class="control-label col-sm-1" for="start_date">Range:</label>
				<div class="col-sm-3">
					<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input name="start_date" type="date" autocomplete="off" id="start_date"class="form-control" value="<?php if(isset($_GET['start_date'])){ echo $_GET['start_date'];}?>" tabindex="-1" />
					</div>
				</div>
				<div class="col-sm-3">
					<div class="input-group date">
						<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
						</div>
						<input name="end_date" type="date" autocomplete="off" id="end_date"class="form-control" value="<?php if(isset($_GET['end_date'])){ echo $_GET['end_date'];}?>" tabindex="-1" />
					</div>
				</div>
				<div class="col-sm-3">
				<input type="submit" name="search_date" class="btn btn-success btn-sm screen" value="Search" />
				</div>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table table-bordered table-hover">
		<thead>
		<tr>
			<th>Invoice#</th><th>Date</th><th>Status</th><th>Total</th><th class="no-print">Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><script>
	var json_data = <?php
		echo json_encode($this->rows); ?>;
	//console.log(json_data);
	var subTotal=0;
	var discount_amount=0;
	var total=0;
	var change_return=0;
	$.each(json_data, function(i, v) {
		document.write('<tr>');
		document.write('<td class="sale_date">'+v.id+ '</td>');
		document.write('<td class="sale_date">'+v.sale_date+ '</td>');
		document.write('<td class="sale_date">'+v.status_name+ '</td>');
		var cust = '';
		if(v.cust_title){
			cust = v.cust_title;
		}
		total = eval(v.sub_total);
		subTotal += total;
		document.write('<td class="total">'+total.toFixed(2)+'</td>');
		
		//document.write('<td class="discount_amount">'+eval(v.discount_amount).toFixed(2)+'</td>');
		//document.write('<td class="change_return">'+eval(v.change_return).toFixed(2)+'</td>');
		//document.write('<td class="no-print"><a onClick="getInvoice(' + v.id + ');return false;" href="?com=sales&view=pos&id='+v.id+'" title="Edit"><i class="fa fa-edit"></i>Edit</a></td>');
		document.write('<td class="no-print"><a onClick="cancelOrder(' + v.id + ');return false;" href="?com=sales&view=pos&id='+v.id+'" title="Cancel"><i class="fa fa-edit"></i>Cancel</a></td>');
		document.write('</tr>');
	});
		</script></tbody>
		<tfoot>
			<tr>
				<th colspan="2" style="text-align:right">Total:</th>
				<th colspan="1"><script>document.write(subTotal.toFixed(2));</script></th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
</div>
<div class="chart">
<?php //require_once "bar-chart.php"; ?>
</div>
<script>
$(document).ready(function(){

})

function cancelOrder(id){
	var r = confirm("<?php echo Localize::_('confirm_cancel');?>");
	if (!r) {
		return false;
	}
	$.post("index.php?com=sales&view=user_orders&task=json",
	{
	id: id,
	action: "cancel"
	},
	function(data, status){
		console.log(data);
		if(data.error){alert('Error!!!');}
		if(data.data){
			$('#messages div').html('<div class="alert alert-info">' + data.data.message + '</div>');
			location.reload();
		}
	//alert("Data: " + data + "\nStatus: " + status);
	});
}

</script>
</div>