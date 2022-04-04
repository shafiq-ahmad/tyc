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
$app=core::getApplication();

?>
<div class="com-head">
	<h3>Translation</h3>
</div>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<?php /*?><?php */ ?>
<div class="form"><?php
	/*$list = array();
	$list['view']='country';
	$list['task']='edit';
	$view = $this->getView('country', 'countries', 'edit');
	echo $view->display($list);*/
?></div>
	<div>
		<span><a href="index.php?com=lists&view=country&task=edit" class="btn btn-info btn-flat" tabindex="-1" ><i class="fa fa-circle-o"></i> New</a></span>
	</div>
	<style>

button{
	padding: 0 15px;
	border: 0;
	background: #02a2ff;
	color: #fff;
	border-radius: 3px;
	cursor: pointer;
	outline: 0;
}
.modalheading{
	background: #fff;
	padding: 5px;
	font-size: 17px;
	line-height: 32px;
}
.modalcontent {
    padding: 10px;
}
.form td{
margin: 0 10px;
}
p.errorMessage {
    background: #ffbaba;
    padding: 10px;
    border-left: 5px solid #f00;
}
p.successMessage {
    background: #a2ffa2;
    padding: 10px;
    border-left: 5px solid #008c1e;
}
.form td input {
    padding:5px 10px;
    outline: 0;
}
	</style>
<div class="table-responsive" id="root-data">

			<?php /*?><div class="crud_header">
				<button class="right addnew" @click="showingModal = true;">Add New</button>
			</div><?php */?>
	<p class="errorMessage" v-if="errorMessage">{{errorMessage}}</p>
	<p class="successMessage" v-if="successMessage">{{successMessage}}</p>
	<div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<input type="hidden" name="token" value="<?php //echo TOKEN; ?>" />
			<div>
			<div class="filter hide">
				<label class="control-label" for="search_filter">Filter:</label><input id="search_filter" name="search_filter" class="inputbox form-control" value="" />
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<table id="data-table" class="table">
		<thead><tr><th>ID#</th><th>Country</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody"><?php
			//foreach ($this->rows as $row){
		?><?php /* ?><tr <?php //if($this->id==$row['id']){echo ' class="active"';} ?>><?php 
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . $row['title'] . '</td>'; 
			$edit_link = "?com=lists&view=country&id={$row['id']}&task=edit";
			echo '<td>'; 
				echo '<a href="' . $edit_link . '" title="Edit"><i class="fa fa-edit"></i></a>'; 
			//if(!$row['cnt']){
				$del_link = "index.php?com=lists&view=country&id={$row['id']}&task=edit";
				echo '&nbsp;&nbsp; | &nbsp;&nbsp;<a href="#" onclick="return removeItem(' . $row['id'] . ",'" . $del_link . '\')" title="Delete"><i class="fa fa-remove"></i></a>'; 
			//}
			echo '</td>'; 
		?></tr><?php */ ?>
		
		
		
	<tr v-for="coutry in countries">
		<td>{{coutry.id}}</td>
		<td>{{coutry.title}}</td>
		<td><button data-toggle="modal" class="btn btn-info btn-sm" @click="showingeditModal = true; selectCountry(coutry)" data-target="#modelEdit">Edit</button></td>
		<td><button @click="showingdeleteModal = true; selectCountry(coutry)" >Delete</button></td>
	</tr>
		
		
		<?php
			//}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="3" style="text-align:right">Total:</th>
				<th colspan="2"></th>
			</tr>
		</tfoot>
	</table>
	
	
	

	
	

	

<!-- Modal -->
<div id="modelEdit" class="modal col-md-6 fade" role="dialog" v-if="showingeditModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" @click="showingModal = false;">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
		
			<div class="modalcontent">
				<table class="form">
					<tr>
						<th>Country</th>
						<th>:</th>
						<td><input type="text" placeholder="Country name" v-model="clickedCountry.title"></td>
					</tr>
					<tr>
						<th>Published</th>
						<th>:</th>
						<td><input type="number" placeholder="Published" v-model="clickedCountry.published"></td>
					</tr>
				</table>
				<div class="margin"></div>
				<button class="center"  @click="showingeditModal = false; updateCountry(clickedCountry.id)">Update Country</button>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" @click="showingModal = false;">Close</button>
      </div>
    </div>

  </div>
</div>
	
	
</div>
<script>
var app = new Vue({
  el: '#root-data',
  data: {
		showingModal:false,
		showingeditModal: false,
		showingdeleteModal: false,
		errorMessage : "",
		successMessage : "",
		countries: [],
		posts: [],
		newCountry: {id: 0, title: "", published: 1},
		clickedCountry: {}
  },
	mounted() {
		this.getAllCountries();
	},
	methods:{
		getAllCountries: function(){
			axios.get("<?php echo URI . 'index.php?com=lists&view=countries&task=json'; ?>")
			.then(function(response){
				//console.log(response.data);
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.countries = response.data;
				}
			});
		},
		saveCountry:function(){

			var formData = app.toFormData(app.newCountry);
			axios.post("<?php echo URI . 'index.php?com=lists&view=country&task=edit'; ?>", formData)
				.then(function(response){
					//console.log(response);
					app.newCountry = {id: 0, title: "", published: 1};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
			},
			updateCountry:function(id){

			app.clickedCountry.com="localize";
			app.clickedCountry.view="translate";
			//app.clickedCountry.task="edit";
			app.clickedCountry.action="update";
			console.log(app.clickedCountry);
			var formData = app.toFormData(app.clickedCountry);
			//console.log(app.clickedCountry);
			axios.post("<?php echo URI . 'index.php?com=lists&view=country&task=json&id='; ?>"+id, formData)
				.then(function(response){
					console.log(response.data);
					app.clickedCountry = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
				$('#modelEdit').modal('hide');
			},
			deleteCountry:function(){

			var formData = app.toFormData(app.clickedCountry);
			axios.post("<?php echo URI . 'index.php?com=lists&view=country&task=edit'; ?>", formData)
				.then(function(response){
					//console.log(response);
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
				console.log(country.title);
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
		
	
		
	},
	watch: {
		
		
	},
	computed: {
		
	}
});
//$(document).ready(function(){
	
	/*$('#data-table').DataTable(*//*{
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
	}*/ //);

	
	
//})
</script>