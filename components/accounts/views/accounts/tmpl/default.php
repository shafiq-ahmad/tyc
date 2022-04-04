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

?>
<div class="table-responsive">
<div class="com-head">
	<h3>Accounts</h3>
</div>
	<table id="data-table" class="table">
		<thead><tr><th>ID#</th><th>Type</th><th>Title</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody"><?php
		
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['type_name'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>';
			$edit_link = "?com=accounts&view=account&id={$row['id']}&task=edit";
			echo '<td>';
				echo '<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>';
				//$del_link = "index.php?com=accounts&view=account&id={$row['id']}&task=edit";
				//echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			echo '</td>';
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="3" style="text-align:right">Total:</th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
</div>
<script>
$(document).ready(function(){
	
$(document).ready(function() {
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
} );
	
	
	
});
</script>