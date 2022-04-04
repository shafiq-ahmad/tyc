<?php
defined('_MEXEC') or die ('Restricted Access');
//var_dump($this->rows);exit;

?>
<div class="com-head">
	<h3>Lists</h3>
</div>
<div class="table-responsive">
	<div class="col-sm-4">
	<h3>Features</h3>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>Title</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->tags as $t){
		?><tr><?php 
			echo '<td>' . $t['tag'] . '</td>';
			//echo '<td>' . $row['parent_title'] . '</td>';
			//echo '<td>' . $row['low_stock'] . '</td>';
			$edit_link = "?com=list&view=tags&id={$t['tag']}";
			echo '<td>'; 
				echo '<a href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>';
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
	</div>
	<div class="col-sm-4">
	</div>
	<div class="col-sm-4">
	
	<h3>Seasons</h3>
	<table id="data-table" class="table">
		<thead>
		<tr>
			<th>ID</th><th>Title</th><th>Months</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->seasons as $s){
		?><tr><?php 
			echo '<td>' . $s['id'] . '</td>';
			echo '<td>' . $s['title'] . '</td>';
			echo '<td>' . $s['months'] . '</td>';
		?></tr><?php
			}
		?></tbody>
	</table>
</div>
</div>
<script>
</script>