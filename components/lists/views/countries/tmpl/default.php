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
	<h3>Countries</h3>
</div>
<!-- Select2 -->
<link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<div class="table-responsive" id="root-data">

	<div class="crud_header btn-group">
		<button class="right addnew btn btn-primary btn-flat btn-sm" @click="showingModal = true;" data-toggle="modal" data-target="#addmodal"><i class="fa fa-plus"></i> Add New</button>
	</div>
	<p class="errorMessage alert alert-danger text-danger" v-if="errorMessage">{{errorMessage}}</p>
	<p class="successMessage alert alert-info text-info" v-if="successMessage">{{successMessage}}</p>
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
		<td><button data-toggle="modal" class="btn btn-info btn-flat btn-sm" @click="showingeditModal = true; selectCountry(coutry)" data-target="#modelEdit"><i class="fa fa-edit"></i></button>
		&nbsp;|&nbsp; <button data-toggle="modal" class="btn btn-danger btn-flat btn-sm" @click="showingdeleteModal = true; selectCountry(coutry)"  data-target="#deletemodal"><i class="fa fa-trash"></i></button></td>
	</tr>
		
		
		<?php
			//}
		?></tbody>
	</table>
	
	
	
	


<!-- Add Modal -->
<div id="addmodal" class="modal col-md-6 fade" role="dialog" v-if="showingModal">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" @click="showingModal = false;">&times;</button>
        <h4 class="modal-title">Add Country</h4>
      </div>
      <div class="modal-body">
					<div class="modalcontent">
						<table class="form">
							<tr>
								<th>
			<div class="form-row py-sm-3 mb-0">
				<div class="form-group col-sm-10">
				<div class="input-group input-sm">
				<div class="input-group-prepend">
				<span class="input-group-text">Country: </span>
				</div>
				<input type="text" placeholder="Country name" class="form-control" v-model="newCountry.title" required autofocus autocomplete="off" />
				</div>
				</div>
			</div>
								</th>
							</tr>
						</table>
						<div class="margin"></div>
						<button class="center btn btn-success btn-flat btn-sm"  @click="showingModal = false; saveCountry();" data-dismiss="modal">Add Country</button>
					</div>
		
      </div>
      <div class="modal-footer">
        <div class="btn-group"><button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal" @click="showingdeleteModal = false;">Close</button></div>
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
        <h4 class="modal-title">Delete Country</h4>
      </div>
      <div class="modal-body">
		
			<div class="modalcontent">
				<div class="margin"></div>
				<h3 class="center">Are you sure to Delete?</h3>
				<div class="margin"></div>
				<h4 class="center">{{clickedCountry.title}}</h4>
				<div class="margin"></div>
				<div class="col-md-6 center">
					<button class="left btn btn-danger btn-flat btn-sm" @click="showingdeleteModal = false; deleteCountry(clickedCountry.id)" data-dismiss="modal"><i class="fa fa-close"></i> YES</button>
					<button class="right btn btn-info btn-flat btn-sm" @click="showingdeleteModal = false;" data-dismiss="modal"><i class="fa fa-check"></i> NO</button>
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal" @click="showingdeleteModal = false;">Close</button>
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
        <h4 class="modal-title">Update Country</h4>
      </div>
      <div class="modal-body">
		
			<div class="modalcontent">
				<table class="form">
				
				
				
							<tr>
								<td>
			<div class="form-row py-sm-3 mb-0">
				<div class="form-group col-sm-10">
				<div class="input-group input-sm">
				<div class="input-group-prepend">
				<span class="input-group-text">Country: </span>
				</div>
				<input type="text" placeholder="Country name" class="form-control" v-model="clickedCountry.title" required autofocus autocomplete="off" />
				</div>
				</div>
			</div>
								</td>
							</tr>
				</table>
				<div class="margin"></div>
				<button class="btn btn-primary btn-flat btn-sm"  @click="showingeditModal = false; updateCountry(clickedCountry.id)">Update Country</button>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal" @click="showingModal = false;">Close</button>
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
			var url_link = "<?php echo URI . 'index.php?com=lists&view=countries&task=json'; ?>";
			axios.get(url_link)
			.then(function(response){
				//console.log(response.data);
				if (response.data.error) {
					app.errorMessage = response.data.message;
				}else{
					app.countries = response.data;
				}
			});
			/*$.ajax({url: url_link, success: function(result){
			//$("#div1").html(result);
			//console.log(result);
			}});*/
			
		},
		saveCountry:function(){
			app.newCountry.action="add";
			app.errorMessage = '';
			app.successMessage = '';

			var formData = app.toFormData(app.newCountry);
			var url_link = "<?php echo URI . 'index.php?com=lists&view=country&task=json'; ?>";
			axios.post(url_link, formData)
				.then(function(response){
					if(response.data.data){
						response.data= response.data.data;
					}
					if(response.data.error){
						//response.error= response.data.error;
					}
					console.log(response.data);
					app.newCountry = {id: 0, title: "", published: 1};
					if (response.data.error) {
						app.errorMessage = response.data.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
				$.ajax({url: url_link, success: function(result){
				//$("#div1").html(result);
				//console.log(result);
				}});
				
			},
			updateCountry:function(id){

			app.clickedCountry.action="update";
			//console.log(app.clickedCountry);
			var formData = app.toFormData(app.clickedCountry);
			//console.log(app.clickedCountry);
			var url_link= "<?php echo URI . 'index.php?com=lists&view=country&task=json&id='; ?>"+id;
			//console.log(url_link);
			app.errorMessage = '';
			app.successMessage = '';
			axios.post(url_link, formData)
				.then(function(response){
					//response = JSON.parse(response);
					if(response.data.data){
						response.data= response.data.data;
					}
					console.log(response.data);
					app.clickedCountry = {};
					if (response.data.error) {
						app.errorMessage = response.data.error.message;
					}else{
						app.successMessage = response.data.message;
						app.getAllCountries();
					}
				});
				$('#modelEdit').modal('hide');
			},
			
			deleteCountry:function(id){
			app.errorMessage = '';
			app.successMessage = '';

			app.clickedCountry.action="remove";
			var formData = app.toFormData(app.clickedCountry);
			var url_link= "<?php echo URI . 'index.php?com=lists&view=country&task=json&id='; ?>"+id;
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
				//console.log(country.title);
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

$(function () {
	//Initialize Select2 Elements
	$('select').select2()
});


$(document).ready(function(){
	
	$('#data-table').DataTable();

	
	
})
</script>