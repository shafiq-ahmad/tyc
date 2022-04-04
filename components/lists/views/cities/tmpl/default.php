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
	<h3>Cities</h3>
</div>
<div class="form"><?php
	$list = array();
	$list['view']='country';
	$list['task']='edit';
	//$view = $this->getView('country');
	//echo $view->display($list);
?></div>
	<div>
		<span><a href="index.php?com=lists&view=city&task=edit" class="btn btn-info btn-flat btn-sm" tabindex="-1" ><i class="fa fa-circle-o"></i> New</a></span>
	</div>
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="list" />
			<input type="hidden" name="view" value="cities" />
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
		<thead><tr><th>ID#</th><th>Country</th><th>City</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['country'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			//echo '<td>' . $row['cnt'] . '</td>'; 
			//echo '<td>' . $row['parent_title'] . '</td>';
			//echo '<td>' . $row['low_stock'] . '</td>';
			$edit_link = "?com=lists&view=city&id={$row['id']}&task=edit";
			echo '<td>'; 
				echo '<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=lists&view=city&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			//}
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
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
	
	
	
})
</script>