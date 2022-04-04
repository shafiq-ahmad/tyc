<?php
defined('_MEXEC') or die ('Restricted Access');

?>
<div class="com-head">
	<h3>Employees</h3>
	<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1"><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><a href="#" onclick="window.open('?com=employees&view=employee&task=new&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-info" tabindex="-1"><i class="fa fa-file"></i> New</a></span>
				<span><a href="#" onclick="window.open('?com=employees&view=departments&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-primary" tabindex="-1"><i class="glyphicon glyphicon-th"></i> Departments</a></span>
				<span><a href="#" onclick="window.open('?com=employees&view=designations&tmpl=js_win','_blank', 'top=10, left= 100, scrollbars=no, titlebar=no, location=top, resizable=no, width=1124,height=560');return false;" class="btn btn-warning" tabindex="-1"><i class="glyphicon glyphicon-alert"></i> Designations</a></span>
			</li>
			<li></li>
		</ul>
	</div>
</div>
<div class="form"><?php
	$list = array();
	$list['view']='employee';
	$list['task']='edit';
	$view = $this->getView('employee', 'employees', 'edit');
	echo $view->display($list);
?></div>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="employees" />
			<input type="hidden" name="view" value="employees" />
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
	<table id="data-table" class="table table-bordered table-hover">
		<thead>
		<tr>
			<th>Item#</th><th>Title</th><th>Department</th>
			<th>Designation</th><th>Address</th><th>Mobile</th><th>Phone</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
			$tr_class='';
			if($this->id==$row['id']){
				if($tr_class){
					$tr_class .= ' active';
				}else{
					$tr_class = 'active';
				}
			}
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
		?><tr class="<?php echo $tr_class; ?>"><?php 
			echo '<td>' . $row['id'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			echo '<td>' . $row['dept_title'] . '</td>'; 
			echo '<td>' . $row['designation_title'] . '</td>'; 
			echo '<td>' . $row['address'] . '</td>';
			echo '<td>' . $row['mobile'] . '</td>'; 
			echo '<td>' . $row['phone'] . '</td>'; 
			$edit_link = "?com=employees&view=employee&task=edit&id={$row['id']}";
			echo '<td>'; 
			echo '<a href="#" onclick="window.open(\'' . $edit_link . '\',\'_blank\');return false;" title="Edit"><i class="fa fa-edit"></i></a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div>
</div>
<script>
$(document).ready(function(){
	$('#data-table').DataTable();
})
</script>