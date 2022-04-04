<?php
defined('_MEXEC') or die ('Restricted Access');

$this->app->setTitle('Items');
//print_r($this);exit;
//print_r(getArticleBrands());exit;
?><?php /* ?><div class="com-head">
	<h3>View Articles</h3>
</div><?php */ ?>
<div class="form"><?php
	/*$list = array();
	$list['view']='article';
	$list['task']='edit';
	$view = $this->getView('article', 'articles', 'edit');
	echo $view->display($list);*/
?>

	<!-- Modal -->
<div id="modalCom" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



</div>
<div class="table-responsive">
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
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
		<thead>
		<tr>
			<th>Item#</th><th>Title</th><th>Size</th><th>Unit</th><th>Actions</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php /*if($this->id==$row['id']){echo ' class="active"';}*/ ?>><?php 
			echo '<td>' . $row['id'] . '</td>'; 
			echo '<td>' . $row['title'] . '</td>'; 
			//echo '<td>' . $row['purchase_price'] . '</td>'; //echo '<td>' . $row['brand'] . '</td>'; 
			//echo '<td>' . $row['purchase_unit'] . '</td>'; 
			//echo '<td>' . $row['sale_price'] . '</td>'; 
			//echo '<td>' . $row['sale_unit'] . '</td>'; 
			$edit_link = "?com=articles&view=article&task=edit&id={$row['id']}";
			//$stock_link = "?com=articles&view=branch_article&task=edit&tmpl=modal&id={$row['id']}";
			//$delete_link = "?com=articles&view=article&task=delete&id={$row['id']}";
			echo '<td>'; 
			echo '<a href="' . $edit_link . '" title="Edit" tabindex="-1">Edit</a>'; 
			//echo '<a data-toggle="modal" data-target="#modalCom" href="' . $stock_link . '" title="Stock" tabindex="-1">Stock</a>'; 
			//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
	</table>
</div>