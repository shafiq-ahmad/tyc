<?php
defined('_MEXEC') or die ('Restricted Access');
$this->app->setTitle('New Employee');
$this->designations = $this->m_des->getCombo();
$this->depts = $this->m_dept->getCombo();
//print_r($cats);exit;
//$row = $this->row;
//print_r($this->tags);exit;
//$tg = explode(',', $row['tags']);
		//`employees`(`id`, `branch_id`, `title`, `dept`, `designation`, `address`, `mobile`, `phone`)
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div>
<div class="form-group">
	<form class="form-inline" method="post" id="main-form" name="frm" action="?com=employees&view=employee&task=new">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div>
				<div class="col-sm-4"><input autocomplete="off" autofocus pattern=".{2,}" id="title" name="title" class="inputbox form-control" value="" required /></div>
				<div class="col-sm-1"><label class="control-label" for="designation">Designation:</label> </div><div class="col-sm-2"><?php 
				
				echo '<SELECT name="designation" id="designation" class="designation form-control dropdown-header"><OPTION value="">...</OPTION>';
				foreach ($this->designations as $ed){
					echo ($ed);
				}
				echo '</SELECT>';
				?></div>
				<div class="col-sm-1"><label class="control-label" for="dept">Department:</label> </div><div class="col-sm-2"><?php 
				
				echo '<SELECT name="dept" id="dept" class="dept form-control dropdown-header"><OPTION value="">...</OPTION>';
				foreach ($this->depts as $d){
					echo ($d);
				}
				echo '</SELECT>';
				?></div>
			</div>
			<div class="row well-sm">
			<div class="col-sm-1"><label class="control-label" for="address">Address:</label> </div><div class="col-sm-4"><input id="address" name="address" class="inputbox form-control" value="" /></div>
			<div class="col-sm-1"><label class="control-label" for="mobile">Mobile:</label> </div><div class="col-sm-2"><input id="mobile" name="mobile" class="inputbox form-control" value="" /></div>
			<div class="col-sm-1"><label class="control-label" for="phone">Phone:</label> </div><div class="col-sm-2"><input id="phone" name="phone" class="inputbox form-control" value="" /></div>

			</div>
		</div>
		<div class="btn-group">
		<ul class="form-buttons">
			<li>
				<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1" ><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
				<span><button class="btn btn-warning" type="reset" name="reset" tabindex="-1" ><i class="glyphicon glyphicon-remove"></i> Reset</button></span>
				<span><button type="submit" name="save" id="save" class="btn btn-success" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
			</li>
			<li></li>
		</ul>
		</div>
		</fieldset>
	</form>
</div>