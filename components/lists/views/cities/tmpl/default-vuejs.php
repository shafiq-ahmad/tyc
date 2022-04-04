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

?>
<div class="com-head">
	<h3>Cities</h3>
</div><div class="table-responsive" id="root-data">

	<div class="crud_header btn-group">
		<button class="right addnew btn btn-primary" @click="showingModal = true;" data-toggle="modal" data-target="#addmodal">Add New</button>
	</div>
	<p class="errorMessage alert alert-danger text-danger" v-if="errorMessage">{{errorMessage}}</p>
	<p class="successMessage alert alert-info text-info" v-if="successMessage">{{successMessage}}</p>
	<table id="data-table" class="table">
		<thead><tr><th>ID#</th><th>Country</th><th>City</th><th>Actions</th></tr></thead>
		<tbody id="tblContentBody">
	<tr v-for="reocrd in records">
		<td>{{reocrd.id}}</td>
		<td>{{reocrd.country}}</td>
		<td>{{reocrd.title}}</td>
		<td><button data-toggle="modal" class="btn btn-info btn-sm" @click="showingeditModal = true; selectRecord(reocrd)" data-target="#modelEdit">Edit</button>
		 &nbsp; | &nbsp; <button data-toggle="modal" class="btn btn-danger" @click="showingdeleteModal = true; selectRecord(reocrd)"  data-target="#deletemodal">Delete</button></td>
	</tr>
		
		</tbody>
	</table>
	

	
<!-- Add Modal -->
<div id="addmodal" class="modal col-md-6 fade" role="dialog" v-if="showingModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" @click="showingModal = false;">&times;</button>
        <h4 class="modal-title">Add Record</h4>
      </div>
      <div class="modal-body">
					<div class="modalcontent">
						<table class="form">
							<tr>
								<th>Country</th>
								<th>: </th>
								<td><select required id="dropDown" name="country_id" class="form-control" v-model="newRecord.country_id">
								<option>country...</option>
								<option v-for="c in countries" :value="c.id">{{ c.title }}</option>
								</select></td>
							</tr>
							<tr>
								<th>City</th>
								<th>:</th>
								<td><input class="form-control" autofocus type="text" placeholder="City name" v-model="newRecord.title"></td>
							</tr>
						</table>
						<div class="margin"></div>
						<button class="center btn btn-success"  @click="showingModal = false; saveRecord();" data-dismiss="modal">Add City</button>
					</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" @click="showingdeleteModal = false;">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Delete Modal -->
<div id="deletemodal" class="modal col-md-6 fade" role="dialog" v-if="showingdeleteModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" @click="showingModal = false;">&times;</button>
        <h4 class="modal-title">Delete City</h4>
      </div>
      <div class="modal-body">
		
			<div class="modalcontent">
				<div class="margin"></div>
				<h3 class="center">Are you sure to Delete?</h3>
				<div class="margin"></div>
				<h4 class="center">{{clickedRecord.title}}</h4>
				<div class="margin"></div>
				<div class="col-md-6 center">
					<button class="left btn btn-danger" @click="showingdeleteModal = false; deleteRecord(clickedRecord.id)" data-dismiss="modal">YES</button>
					<button class="right btn btn-info" @click="showingdeleteModal = false;" data-dismiss="modal">NO</button>
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" @click="showingdeleteModal = false;">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Update Modal -->
<div id="modelEdit" class="modal col-md-6 fade" role="dialog" v-if="showingeditModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" @click="showingModal = false;">&times;</button>
        <h4 class="modal-title">Update Record</h4>
      </div>
      <div class="modal-body">
		
			<div class="modalcontent">
				<table class="form">
					<tr>
						<th>Country</th>
						<th>: </th>
						<td><select required id="dropDown" name="country_id" class="form-control" v-model="clickedRecord.country_id">
						<option>country...</option>
						<option v-for="c in countries" :value="c.id">{{ c.title }}</option>
						</select></td>
					</tr>
					<tr>
						<th>City</th>
						<th>: </th>
						<td><input class="form-control" type="text" placeholder="City name" autofocus v-model="clickedRecord.title"></td>
					</tr>
					<?php /*?><tr>
						<th>Published</th>
						<th>:</th>
						<td><input class="" type="checkbox" placeholder="Published" v-model="clickedRecord.published"></td>
					</tr><?php */?>
				</table>
				<div class="margin"></div>
				<button class="btn btn-primary"  @click="showingeditModal = false; updateRecord(clickedRecord.id)">Update Record</button>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" @click="showingModal = false;">Close</button>
      </div>
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
		selected: null,
		countries: [],
		records: [],
		posts: [],
		newRecord: {id: 0, title: "", published: 1, country_id:0},
		clickedRecord: {}
  },
	mounted() {
		this.getAllRecords();
		this.getCountriesList();
	},
	methods:{
		getAllRecords: function(){
			var url_link = "<?php echo URI . 'index.php?com=lists&view=cities&task=json'; ?>";
			//console.log('get all');
			axios.get(url_link)
			.then(function(response){
				//response = JSON.parse(response);
				console.log(response.data);
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.records = response.data;
					//this.$set(this.someObject, 'b', 2);
					//Vue.set(app.records, 'data', response.data);
				}
				//console.log(app.records);
			});
			
		},
		getCountriesList: function(){
			var url_link = "<?php echo URI . 'index.php?com=lists&view=countries&task=json'; ?>";
			//console.log('get countries');
			axios.get(url_link)
			.then(function(response){
				//console.log(response.data);
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.countries = response.data;
				}
				//console.log(app.countries);
			});
			
		},
		saveRecord:function(){
			app.newRecord.action="add";
			app.errorMessage = '';
			app.successMessage = '';

			var formData = app.toFormData(app.newRecord);
			var url_link = "<?php echo URI . 'index.php?com=lists&view=city&task=json'; ?>";
			axios.post(url_link, formData)
				.then(function(response){
					if(response.data.data){
						response.data= response.data.data;
					}
					if(response.data.error){
						//response.error= response.data.error;
					}
					//console.log(response.data);
					app.newRecord = {id: 0, title: "", published: 1, country_id:0};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						//app.records = response.data;
						//app.getAllRecords();
					}
					app.getAllRecords();
				});
				//$.ajax({url: url_link, success: function(result){
				//$("#div1").html(result);
				//console.log(result);
				//}});
				
			},
			updateRecord:function(id){

			app.clickedRecord.action="update";
			//console.log(app.clickedRecord);
			var formData = app.toFormData(app.clickedRecord);
			//console.log(app.clickedRecord);
			var url_link= "<?php echo URI . 'index.php?com=lists&view=city&task=json&id='; ?>"+id;
			//console.log(url_link);
			app.errorMessage = '';
			app.successMessage = '';
			axios.post(url_link, formData)
				.then(function(response){
					//response = JSON.parse(response);
					if(response.data.data){
						response.data= response.data.data;
					}
					if(response.data.error){
						//response.error= response.data.error;
					}
					console.log(response.data);
					app.clickedRecord = {};
					if (response.data.error) {
						app.errorMessage = response.data.error.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllRecords();
					}
				});
				$('#modelEdit').modal('hide');
			},
			
			deleteRecord:function(id){
			app.errorMessage = '';
			app.successMessage = '';

			app.clickedRecord.action="remove";
			var formData = app.toFormData(app.clickedRecord);
			var url_link= "<?php echo URI . 'index.php?com=lists&view=city&task=json&id='; ?>"+id;
			axios.post(url_link, formData)
				.then(function(response){
					console.log(response.data);
					if(response.data.data){
						response.data= response.data.data;
					}
					if(response.data.error){
						//response.error= response.data.error;
					}
					console.log(response.data);
					app.clickedRecord = {};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllRecords();
					}
					
				});
			},
			selectRecord(record){
				//console.log(record.title);
				app.clickedRecord = record;
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





$(document).ready(function(){
	
	$('#data-table').DataTable(/*{
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
	}*/ );

	
	
})
</script>