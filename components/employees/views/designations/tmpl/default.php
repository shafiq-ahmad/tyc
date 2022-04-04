<?php
defined('_MEXEC') or die ('Restricted Access');
//var_dump($this->rows);exit;

?>
<div class="com-head">
	<h3>Designations</h3>
</div>
<div class="form"><?php
	$list = array();
	$list['view']='designation';
	$list['task']='edit';
	$view = $this->getView('designation', 'employees', 'edit');
	echo $view->display($list);
?></div>
<div class="table-responsive">
	<div id="search-date-range">
	</div>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>ID#</th><th>Title</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			$edit_link = "?com=employees&view=designations&id={$row['id']}";
			echo '<td>'; 
			echo '<a href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>';
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