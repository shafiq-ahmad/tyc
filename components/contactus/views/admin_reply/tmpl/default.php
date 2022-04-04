<?php
defined('_MEXEC') or die ('Restricted Access');
//var_dump($this->rows);exit;
$arr = array(1=>'Approved', 2=>'Pending', 3=>'Approve');


?>

<div class="table-responsive">
<div class="com-head">
	<h3>Vehicles: Admin approval awaiting</h3>
</div>
<div class="form"><?php
	//$list = array();
	//$list['view']='country';
	//$list['task']='edit';
	//$view = $this->getView('country', 'countries', 'edit');
	//echo $view->display($list);
?></div>
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
		<thead><tr><th>ID#</th><th>Title</th><th>Owner</th><th>Subscription</th><th>Approval</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody"><?php
		if($this->rows){
			//var_dump($this->rows);exit;
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['owner_name'] . '</td>'; 
			echo '<td>' . $row['sub_name'] . '</td>';
			if($row['visibility']==3){
				echo '<td><a class="approve btn btn-warning btn-sm" data-id="' . $row['id'] . '">' . $arr[$row['visibility']] . '</a></td>'; 
			}else{
				echo '<td>' . $arr[$row['visibility']] . '</td>';
			}
			$edit_link = "?com=vehicles&view=make&id={$row['id']}&task=edit";
			echo '<td>'; 
				echo '<a href="' . $edit_link . '" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=vehicles&view=make&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			//}
			echo '</td>'; 
		?></tr><?php
			}
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
	$('#data-table').DataTable();
});

$(".approve").click(function(e){
	e.preventDefault();
	var r = confirm("Please confirm Approve!");
	if (r != true){
		return false;
	}
	var r = $(this);
	var vehicle = $(this).data('id');
	$.post("index.php?com=vehicles&view=vehicle&task=edit",
		{action: "approveVehicle",	id: vehicle},
	function(data, status){
	//console.log(data);
	alert('Vehicle broadcast successful');
	var msg = $('#messages');
	$(r).attr("disabled", true);
	$(msg).html('<h3 class="info">Vehicle approved for broadcast</h3>').fadeOut(10000,function (){
	});
	});
});




</script>