<?php
defined('_MEXEC') or die ('Restricted Access');
$this->app->setTitle('New Item');
//print_r($cats);exit;
//$row = $this->row;
//print_r($this->tags);exit;
//$tg = explode(',', $row['tags']);
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
</div>
<div class="form-group">
	<form class="form-inline" method="post" id="main-form" name="frm" action="?com=articles&view=article&task=new">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" name="id" value="" />
			<input type="hidden" name="article_type" value="1" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="article_code">Item#:</label></div><div class="col-sm-2"><input autocomplete="off" id="article_code" pattern=".{3,}" name="article_code" class="inputbox form-control" value="" required /></div>
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div>
				<div class="col-sm-5"><input autocomplete="off" pattern=".{2,}" id="title" name="title" class="inputbox form-control" value="" required /></div>
				<div class="col-sm-1"><label class="control-label" for="category">Category:</label> </div><div class="col-sm-2"><?php 
				
				echo '<SELECT name="category" id="category" class="category form-control dropdown-header"><OPTION value="">...</OPTION>';
				foreach ($this->cats as $cat){
					echo ($cat);
				}
				echo '</SELECT>';
				?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1 hide"><label class="control-label" for="ref_code">Ref#:</label> </div><div class="col-sm-2 hide"><input id="ref_code" name="ref_code" class="inputbox form-control" value="" /></div>
				<div class="col-sm-1 hide"><label class="control-label" for="comments">Comments:</label> </div><div class="col-sm-5 hide"><input id="comments" name="comments" class="inputbox form-control" value="" /></div>
			<div class="col-sm-1"><label class="control-label" for="size">Size:</label> </div><div class="col-sm-2"><input type="number" step="any" id="size" name="size" class="inputbox form-control" value="" /></div>
			<div class="col-sm-1"><label class="control-label" for="unit">Unit:</label> </div><div class="col-sm-2">
			<input id="unit" list="units" name="unit" class="inputbox form-control" value="" />
			<datalist id="units">
				<option value="PCS">
				<option value="EA">
				<option value="KG">
				<option value="G">
				<option value="MG">
				<option value="L">
				<option value="ML">
				<option value="KM">
				<option value="M">
				<option value="CM">
				<option value="MM">
			</datalist>
			</div>
			<div class="col-sm-1 hide"><label class="control-label" for="packing">Packing:</label> </div><div class="col-sm-2 hide"><input type="number" id="packing" name="packing" class="inputbox form-control" value="" /></div>
			</div>
			<hr/>
			<div class="row well-sm hide"><label class="control-label col-sm-2" for="add_stock_record">Create Stock Record:</label><div class="col-sm-1"><input type="checkbox" id="add_stock_record" name="add_stock_record" class="minimal" checked tabindex="-1" /></div></div>

				<div class="row well-sm">
					<div class="col-sm-2">
						<div><label class="control-label" for="cost_price">Cost Price:</label></div><div><input autocomplete="off" id="cost_price" name="cost_price" class="inputbox form-control" value="0" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="sale_price">Sale Price:</label> </div><div><input autocomplete="off" id="sale_price" name="sale_price" class="inputbox form-control" value="" required /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" title="Openning stock" for="qty">Qty:</label></div><div><input autocomplete="off" type="number" id="qty" name="qty" class="inputbox form-control" value="0" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" title="Min stock alert" for="min_stock">Alert:</label></div><div><input autocomplete="off" type="number" id="min_stock" name="min_stock" class="inputbox form-control" value="0" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="discount">Discount:</label></div><div><input type="number" autocomplete="off" id="discount" name="discount" class="inputbox form-control" value="0" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="expiry_alert_days">Expiry alert:</label></div><div><input autocomplete="off" type="number" id="expiry_alert_days" name="expiry_alert_days" class="inputbox form-control" value="0" /></div>
					</div>
				</div>
				<div class="row well-sm hide">
					<div class="col-sm-1"><label class="control-label" for="loc_section">Location: </label></div><div class="col-sm-1"><input id="loc_section" name="loc_section" class="inputbox form-control" value="" /></div>
					<div class="col-sm-1"><label class="control-label" for="loc_rack">-</label> </div><div class="col-sm-1"><input id="loc_rack" name="loc_rack" class="inputbox form-control" value="" /></div>
					<div class="col-sm-1"><label class="control-label" for="loc">-</label> </div><div class="col-sm-1"><input id="loc" name="loc" class="inputbox form-control" value="" /></div>
				</div>
				<div class="row well-sm">
					<div id="sale_price_terms" class="json-box col-sm-3">
						<div><label class="control-label" for="sale_price_terms">Price Terms:</label></div>
						<div><input type="hidden" name="sale_price_terms" class="inputbox form-control json-data" value="" /></div>
						<div class="json-form-el-list">
							<div class="json-form-add">
								<div class="data-fields"><input type="number" data-datatype="number" class="json-value inputbox form-control input-sm" data-key-name="qty" value="" /><input type="number" data-datatype="number" class="json-value inputbox form-control input-sm" data-key-name="price" value="" /></div>
								<div class="actions"><button class="json-btn btn btn-primary btn-sm btn-flat" tabindex="-1"><i class="glyphicon glyphicon-plus"></i> Add</button></div>
							</div>
							<div>
								<table>
									<thead><tr><!--<th class="col1">Opt</th>--><th class="col2">Qty</th><th class="col3">Price</th><th class="col4">Action</th></tr></thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="stock_expiry_dates" class="json-box col-sm-3">
						<div><label class="control-label" for="stock_expiry_dates">Stock Expiry:</label></div>
						<div><input type="hidden" name="stock_expiry_dates" class="inputbox form-control json-data" value="" /></div>
						<div class="json-form-el-list">
						<div class="json-form-add">
							<div class="data-fields"><input type="number" data-datatype="number" class="json-value inputbox form-control input-sm" data-key-name="qty" value="" /><input class="json-value date inputbox form-control input-sm" data-datatype="date" data-key-name="expiry" value="" /></div>
							<div class="actions"><button class="json-btn btn btn-primary btn-sm btn-flat" tabindex="-1" ><i class="glyphicon glyphicon-plus"></i> Add</button></div>
						</div>
						<div>
							<table>
								<thead><tr><!--<th class="col1">Opt</th>--><th class="col2">Qty</th><th class="col3">Expiry</th><th class="col4">Action</th></tr></thead>
								<tbody>
								</tbody>
							</table>
						</div>
						</div>
					</div>

					
					
			<div class="col-sm-3">
				<div class=""><label class="control-label" for="tags">Features:</label></div><div class=""><?php 
			
				echo '<SELECT name="tags[]" id="tags" class="form-control" size="10" multiple>';
				/*if(!$tg){
					echo '<OPTION value=""></OPTION>';
				}*/
				foreach ($this->tags as $t){
					$sel='';
					//$as = array_search($t['id'], $tg);
					//if($as>=1 || $as === 0){$sel=' selected';}
					echo '<OPTION value="' . $t['tag'] . '" ' . $sel . ' >' . $t['tag'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
			
			<div class="col-sm-3">
				<div class=""><label class="control-label" for="seasons">Seasons:</label></div><div class=""><?php 
			
				echo '<SELECT name="seasons[]" id="seasons" class="form-control" size="10" multiple>';
				/*if(!$tg){
					echo '<OPTION value=""></OPTION>';
				}*/
				foreach ($this->seasons as $s){
					$sel='';
					//$as = array_search($s['id'], $tg);
					//if($as>=1 || $as === 0){$sel=' selected';}
					echo '<OPTION value="' . $s['id'] . '" ' . $sel . ' >' . $s['title'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
			
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