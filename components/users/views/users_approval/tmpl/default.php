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
$status=array(0=>'Inactive',1=>"Active");

?>
<div class="table-responsive">
<div class="com-head">
<h3>Users Pending Approvals</h3>
</div>
<div class="form"><?php
	//$list = array();
	//$list['view']='country';
	//$list['task']='edit';
	//$view = $this->getView('country', 'countries', 'edit');
	//echo $view->display($list);
?></div>
	
	<?php /* ?><div></div><?php */?>
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="users" />
			<input type="hidden" name="view" value="users" />
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
		<thead><tr><th>Picture</th><th>Login</th><th>Full Name</th><th>Status</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			//echo '<td>' . $row['id'] . '</td>';
			echo '<td><img src="' . $row['img_thumb'] . '" class="img-thumbnail" style="max-width:100px;" /></td>';
			echo '<td>' . $row['user_name'] . '</td>';
			echo '<td>' . $row['full_name'] . '</td>';
			echo '<td>' . $status[$row['published']] . '</td>';
			$edit_link = "?com=users&view=user&id={$row['id']}&task=edit&tmpl=com";
			echo '<td>'; 
				//<a class="btn btn-info btn-sm"></a>
				echo '<a class="btn btn-info btn-sm" data-remote="false" data-toggle="modal" data-target="#myModal" href="' . $edit_link . '" title="Edit"><i class="fa fa-eye"></i></a>';
				$del_link = "index.php?com=users&view=user&id={$row['id']}&task=edit";
				$publish_link = "index.php?com=users&view=users&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return publishItem(' . $row['id'] . ",1,'" . $publish_link . "','" . 'Confirm Approval' . '\')" title="Approve"><i class="fa fa-check"></i>Approve</a>';
				
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable();

	
	
})
</script>