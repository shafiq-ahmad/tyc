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
$app = Core::getApplication();

?>
<div class="table-responsive">
<div class="form"><?php
	//$list = array();
	//$list['view']='country';
	//$list['task']='edit';
	//$view = $this->getView('country', 'countries', 'edit');
	//echo $view->display($list);
?></div>
	<div>
		<span class="hide"><a href="index.php?com=shipping&view=subscriptions&task=edit" class="btn btn-info btn-flat" tabindex="-1" ><i class="fa fa-circle-o"></i> <?php echo Localize::_('buy_subscription'); ?></a></span>
	</div>
<div class="com-head">
	<h3><?php echo Localize::_('user_subscriptions'); ?></h3>
</div>
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="shipping" />
			<input type="hidden" name="view" value="subscription" />
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
				<label class="control-label" for="search_filter"><?php echo Localize::_('filter'); ?></label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead><tr><th><?php echo Localize::_('id'); ?></th><th><?php echo Localize::_('user'); ?></th><th><?php echo Localize::_('subscription'); ?></th><th><?php echo Localize::_('dated'); ?></th><th><?php echo Localize::_('expiry'); ?></th><th><?php echo Localize::_('actions'); ?></th></tr></thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['full_name'] . '</td>';
			echo '<td>' . $row['subscription_title'] . '</td>'; 
			echo '<td>' . $row['dated'] . '</td>'; 
			echo '<td>' . $row['expiry'] . '</td>';
			$edit_link = "?com=shipping&view=subscription&id={$row['id']}&task=edit";
			echo '<td>'; 
				echo '<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i>Upgrade</a>'; 
				echo '&nbsp;&nbsp;  &nbsp;&nbsp;<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i>Renew</a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=shipping&view=subscription&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp;  &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItemzzz(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i>Remove</a>'; 
			//}
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="3" style="text-align:right"><?php echo Localize::_('total'); ?></th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
</div>

<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/jszip/dist/jszip.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/pdfmake/build/pdfmake.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/pdfmake/build/vfs_fonts.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable({
	"language": {
	"emptyTable": "You are not subscribed. please contact admin",
	"lengthMenu": "Display _MENU_ records per page",
	"zeroRecords": "Nothing found - sorry",
	"info": "Showing page _PAGE_ of _PAGES_",
	"infoEmpty": "No records available",
	"infoFiltered": "(filtered from _MAX_ total records)"
	}
} );

	
	
});

/*
    "sProcessing":   "جارٍ التحميل...",
    "sLengthMenu":   "أظهر _MENU_ مدخلات",
    "sZeroRecords":  "لم يعثر على أية سجلات",
    "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
    "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
    "sInfoPostFix":  "",
    "sSearch":       "ابحث:",
    "sUrl":          "",
    "oPaginate": {
        "sFirst":    "الأول",
        "sPrevious": "السابق",
        "sNext":     "التالي",
        "sLast":     "الأخير"
    }
$(document).ready(function() {
    $('#example').DataTable( {
        "ajax": '../ajax/data/arrays.txt'
    } );
} )



*/
</script>