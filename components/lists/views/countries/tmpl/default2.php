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
<div class="table-responsive">
<div class="com-head">
	<h3>Countries</h3>
</div>
<div class="form"><?php
	/*$list = array();
	$list['view']='country';
	$list['task']='edit';
	$view = $this->getView('lists.country');
	//echo $view->display('edit');// error load base component
	echo $view->display($list);*/
?></div>
	<div>
		<span><a href="index.php?com=lists&view=country&task=edit" class="btn btn-info btn-flat" tabindex="-1" ><i class="fa fa-circle-o"></i> New</a></span>
	</div>
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
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
		<thead><tr><th>ID#</th><th>Country</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
		?><tr <?php if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			//echo '<td>' . $row['cnt'] . '</td>'; 
			//echo '<td>' . $row['parent_title'] . '</td>';
			//echo '<td>' . $row['low_stock'] . '</td>';
			$edit_link = "?com=lists&view=country&id={$row['id']}&task=edit";
			echo '<td>'; 
				echo '<a class="btn btn-info btn-sm" href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=lists&view=country&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a class="btn btn-danger btn-sm" href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			//}
			echo '</td>'; 
		?></tr><?php
			}
		?></tbody>
		<?php /*?><tfoot>
			<tr>
				<th colspan="3" style="text-align:right">Total:</th>
				<th colspan="2"></th>
			</tr>
		</tfoot><?php */?>
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
$(function () {
	//Initialize Select2 Elements
	$('select').select2()
})
/*
var app = new Vue({

	el: "#root-form",
	data: {
		showingModal:false,
		showingeditModal: false,
		showingdeleteModal: false,
		errorMessage : "",
		successMessage : "",
		countries: [],
		newCountry: {id: 0, title: "", published: 1},
		clickedCountry: {},
		
	},
	mounted: function () {
		console.log("Hi KK");
		this.getAllCountries();
	},
	methods: {
		getAllCountries: function(){
			axios.get("<?php echo URI . 'index.php?com=lists&view=countries&task=json'; ?>")
			.then(function(response){
				console.log(response);
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.countries = response.data.countries;
				}
			});
		},
		saveCountry:function(){

			var formData = app.toFormData(app.newCountry);
			axios.post("<?php echo URI . 'index.php?com=lists&view=country&task=edit'; ?>", formData)
				.then(function(response){
					console.log(response);
					app.newCountry = {id: 0, title: "", published: 1};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
			},
			updateCountry:function(){

			var formData = app.toFormData(app.clickedCountry);
			axios.post("<?php echo URI . 'index.php?com=lists&view=country&task=edit'; ?>", formData)
				.then(function(response){
					console.log(response);
					app.clickedCountry = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
			},
			deleteCountry:function(){

			var formData = app.toFormData(app.clickedCountry);
			axios.post("<?php echo URI . 'index.php?com=lists&view=country&task=edit'; ?>", formData)
				.then(function(response){
					console.log(response);
					app.clickedCountry = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
			},
			selectCountry(country){
				app.clickedCountry = country;
			},

			toFormData: function(obj){
				var form_data = new FormData();
			      for ( var key in obj ) {
			          form_data.append(key, obj[key]);
			      } 
			      return form_data;
			},
			clearMessage: function(){
				app.errorMessage = "";
				app.successMessage = "";
			},
		
	}
});*/

$(document).ready(function(){
	
	$('#data-table').DataTable(
	/*{
		"footerCallback": function(row, data, start, end, display ) {
		var api = this.api(), data;

		// Remove the formatting to get integer data for summation
		var intVal = function (i) {
			return typeof i === 'string' ?
			i.replace(/[\$,]/g, '')*1 :
			typeof i === 'number' ?
			i : 0;
		};

		// Total over all pages
		total = api
		.column(3)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Total over this page
		pageTotal = api
		.column(3, { page: 'current'} )
		.data()
		.reduce(function (a, b){
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(3).footer()).html(
			''+pageTotal +' ( '+ total +' total)'
		);
		}
	}*/
	);

	
	
})
</script>