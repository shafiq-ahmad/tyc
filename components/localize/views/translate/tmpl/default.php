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
License URI: http://www.gnu.org/licenses/gpl-2.0.html  */
defined('_MEXEC') or die ('Restricted Access');
$app = Core::getApplication();
//var_dump($this->rows);exit;

?>
<style>
tr td input{width:100% !important;}
</style>
<div class="table-responsive">
<div class="com-head">
	<h3>Translations</h3>
</div>

	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="localize" />
			<input type="hidden" name="view" value="translate" />
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
	<form method="POST" action="">
	<input type="hidden" name="com" value="localize" />
	<input type="hidden" name="action" value="update" />
	<div class="btn-group">
	<input type="submit" value="Update" class="btn btn-success btn-flat btn-sm right" />
	</div>
	<table id="data-table" class="table">
		<thead><tr><th>English</th><th>Arabic</th><th>Turkish</th></tr></thead>
		<tbody id="tblContentBody"><?php
		
		$rows = $this->rows;
		foreach ($rows['en'] as $key => $row){
		
			//echo '<br><br><br>';
			//echo $this->rows['ar'][$key];
			
		?><tr id="<?php echo $key; ?>"><?php
			//$result = 5 > 3 ? "Bigger" : "Less";
			$ar_key = isset($rows['ar'][$key]) ? $rows['ar'][$key] : '';
			$en_key = isset($rows['en'][$key]) ? $rows['en'][$key] : '';
			$tr_key = isset($rows['tr'][$key]) ? $rows['tr'][$key] : '';
			
			echo '<td><input class="inputbox form-control lang-en" name="en[' . $key . ']" value="' . $en_key . '" /></td>';
			echo '<td><input class="inputbox form-control lang-ar" name="ar[' . $key . ']" value="' . $ar_key . '" /></td>';
			echo '<td><input class="inputbox form-control lang-tr" name="tr[' . $key . ']" value="' . $tr_key . '" /></td>';
			//var_dump($row);

		?></tr><?php
			}
		?></tbody>
	</table>
	</form>
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
	
	//$('#data-table').DataTable();

})
</script>