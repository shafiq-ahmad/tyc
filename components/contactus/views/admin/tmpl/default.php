<?php
defined('_MEXEC') or die ('Restricted Access');
//var_dump($this->rows);exit;
$arr = array(1=>'Approved', 2=>'Pending', 3=>'Approve');
$app=Core::getApplication();


?>
<!-- Select2 
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
-->
<div class="table-responsive">
<div class="com-head">
	<h3>User Inquiries</h3>
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
		<thead><tr><th>ID#</th><th>User</th><th>City</th><th>Phone</th><th>E-mail</th><th>Subject</th><th>Message</th></tr></thead>
		<tbody id="tblContentBody"><?php
		if($this->rows){
			//var_dump($this->rows);exit;
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['full_name'] . '</td>'; 
			echo '<td>' . $row['city_title'] . '</td>'; 
			echo '<td>' . $row['phone'] . '</td>';
			echo '<td>' . $row['e_mail'] . '</td>';
			echo '<td>' . $row['subject'] . '</td>';
			echo '<td>' . $row['message'] . '</td>';
			//$url = 'index.php?com=contactus&view=admin&tmpl=com&id=' . $row['id'];
			//echo '<td><a href="' . $url . '" data-toggle="modal" class="btn btn-default" >Read</a></td>';
			
			/*if($row['published']==3){
				echo '<td><a class="approve btn btn-warning btn-sm" data-id="' . $row['id'] . '">' . $arr[$row['published']] . '</a></td>'; 
			}else{
				echo '<td>' . $arr[$row['published']] . '</td>';
			}*/
			/*$edit_link = "?com=contactus&view=msgread&id={$row['id']}&task=edit";
			echo '<td>'; 
				echo '<a href="' . $edit_link . '" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>'; 
				$del_link = "index.php?com=contactus&view=contact&id={$row['id']}";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			echo '</td>'; */
		?></tr><?php
			}
		}
		?></tbody>
	</table>
</div>
<script>
/*$(document).ready(function() {

// Support for AJAX loaded modal window.
// Focuses on first input textbox after it loads the window.
$('[data-toggle="modal"]').click(function(e) {
e.preventDefault();
var url = $(this).attr('href');
console.log(url);
if (url.indexOf('#') == 0) {
$(url).modal('open');
} else {
$.get(url, function(data) {
	//alert(data);
	console.log(data);
	$(this).find(".modal-body").html(data);
	//$('#msgModal').modal('show');
	//jQuery.noConflict(); 
$('#msgModal').modal('show');
	//$('#msgModal').find(".modal-body").html(data);
//$('<div class="modal hide fade">' + data + '</div>').modal();
});
}
});

});*/



</script>