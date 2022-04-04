<?php
defined('_MEXEC') or die ('Restricted Access');

?>

	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
	
	<!-- Modal -->
	<div id="new_art_type_list" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Article Type</h4>
				</div>
				<div class="modal-body">
					<span><a href="#" onclick="window.open('?com=articles&view=article&task=new&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> Merchantize</a></span>
					<span><a href="#" onclick="window.open('?com=articles&view=article&task=new_service&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> Service</a></span>
					<span><a href="#" onclick="window.open('?com=articles&view=article&task=new_asset&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> Asset</a></span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	
	
<div class="com-head">
	<h3>Items</h3>
	<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1"><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><a href="#" class="btn btn-info" data-toggle="modal" data-target="#new_art_type_list" tabindex="-1"><i class="fa fa-file"></i> New</a></span>
				<span><a href="#" onclick="window.open('?com=articles&view=branch_stock&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-primary" tabindex="-1"><i class="glyphicon glyphicon-th"></i> Stock</a></span>
				<span><a href="#" onclick="window.open('?com=articles&view=stock_alerts&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-warning" tabindex="-1"><i class="glyphicon glyphicon-alert"></i> Stock Alert</a></span>
				<span><a href="#" onclick="window.open('?com=articles&view=expiry_alerts&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-warning" tabindex="-1"><i class="glyphicon glyphicon-alert"></i> Expiry Alert</a></span>
			</li>
			<li></li>
		</ul>
	</div>
</div>
<div class="form"><?php
	/*$list = array();
	$list['view']='branch_article';
	$list['task']='edit';
	$view = $this->getView('branch_article', 'articles', 'edit');
	echo $view->display($list);*/
?></div>
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
			</div><div class="clear"></div>
		</form>
	</div>
	<div class="box-body">
	<table id="data-table" class="table display">
		<thead>
		<tr>
			<th>Item#</th><th>Title</th><th>Size - Unit</th>
			<th>Cost Price</th><th>Sale Price</th><th>Stock</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
			$tr_class='';
			if($row['qty']<0){
				//$qty = abs($row['qty']);
				$tr_class='neg-qty';
			}
			$qty = $row['qty'];
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
			echo '<td>' . $row['art_size'] . ' ' . $row['unit'] . '</td>'; 
			echo '<td>' . $row['cost_price'] . '</td>'; 
			echo '<td>' . $row['sale_price'] . '</td>';
			echo '<td>' . $row['qty'] . '</td>'; 
			$edit_link = "?com=articles&view=branch_article&task=edit&id={$row['article_code']}";
			echo '<td>'; 
			echo '<a href="#" onclick="window.open(\'' . $edit_link . '\',\'_blank\');return false;" title="Edit"><i class="fa fa-edit"></i></a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="5" style="text-align:right">Total:</th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
</div>
</div>

<script>
$(document).ready(function(){
	$('#data-table').DataTable({dom: 'lfBrtip',buttons:['excel', 'pdf']} );
	

});




</script>
<?php

$script = '
var json_data = getData();

//console.log(json_data);
console.log(json_data.rows);

';

$app = core::getApplication();
$app->setScript($script);


?>