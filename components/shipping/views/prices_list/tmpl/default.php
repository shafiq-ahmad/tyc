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
$app = Core::getApplication();
$vTypes=array('Regular','Bike','Big Truck');
//var_dump($this->rows);exit;

?>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<div class="table-responsive">
<div class="com-head">
	<h3>Shipping Prices</h3>
</div>
<div class="form"><?php
	/*$list = array();
	$list['view']='price_list';
	$list['task']='edit';
	$view = $this->getView('price_list', 'shipping', 'edit');
	echo $view->display($list);*/
?></div>
	<div class="btn-group">
		<span><a href="index.php?com=shipping&view=price_list&task=edit&tmpl=com" class="btn btn-info btn-flat btn-sm" tabindex="-1"  data-remote="false" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus"></i> New</a></span>
	</div>
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="shipping" />
			<input type="hidden" name="view" value="ports" />
			<input type="hidden" name="token" value="<?php echo TOKEN; ?>" />
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
		<tr><th>ID#</th><th>Vehicle Type</th><th>Port</th><th>Dest. Port</th><th>Shipping</th><th>Service Charges</th><th>Clearance</th><th>Actions</th></tr>
		</thead>
		<tbody id="tblContentBody"><?php
		if($this->rows){
			foreach ($this->rows as $row){
		?><tr <?php
		if($this->id==$row['id']){echo ' class="active"';}
		echo ' id="id-' . $row['id'] . '"';
		?>><?php 
			echo '<td class="id">' . $row['id'] . '</td>';
			echo '<td class="vehicle_type">' . $vTypes[$row['vehicle_type']-1] . '</td>'; 
			echo '<td class="o_port">' . $row['o_port'] . '</td>';
			//echo '<td class="charges">' . $row['charges'] . '</td>';  
			echo '<td class="dest_title">' . $row['dest_title'] . '</td>'; 
			echo '<td class="shipping">' . $row['shipping'] . '</td>'; 
			echo '<td class="service_charge">' . $row['service_charge'] . '</td>'; 
			echo '<td class="clearance">' . $row['clearance'] . '</td>'; 
			//echo '<td class="total_charge">' . $row['total_charge'] . '</td>'; 
			$edit_link = "index.php?com=shipping&view=price_list&id={$row['id']}&task=edit&tmpl=com";
			echo '<td>'; 
				echo '<a class="btn btn-info btn-sm" data-remote="false" data-toggle="modal" data-target="#myModal" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=shipping&view=price_list&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			//}
			echo '</td>'; 
		?></tr><?php
			}
			}
		?></tbody>
		<tfoot>
		</tfoot>
	</table>
</div>
<!-- Default bootstrap modal example -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
		<div id="msg_modal"></div>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.reload()">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){

	//$('#data-table').DataTable();
    $('#data-table').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                   // .appendTo( $(column.header()).empty() )
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
	
	
});

</script>