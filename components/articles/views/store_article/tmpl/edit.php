<?php
defined('_MEXEC') or die ('Restricted Access');

//print_r($_POST);exit;

//print_r(json_decode($this->sub['tags']));exit;
//$row = $this->row;this->sub['seasons'];
$tg = json_decode($this->sub['tags']);

$ss = json_decode($this->sub['seasons']);
//print_r($tg);exit;


?><div class="com-head">
</div><div>
	<form class="form-inline validate" id="main-form" method="post" name="frm" action="?com=articles&view=branch_article&task=edit<?php if($this->id){echo '&id='.$this->id;} ?>">
		<div class="form grid">
		<fieldset class="form">
			<input type="hidden" name="id" value="" />
			<div class="row well-sm">
				<div class="col-sm-1"><label class="control-label" for="article_code">Item#:</label></div><div class="col-sm-2"><input id="article_code" pattern=".{1,}" name="article_code" class="inputbox form-control" value="<?php echo $this->row['article_code'];?>" required readonly /></div>
				<div class="col-sm-1"><label class="control-label" for="title">Title:</label></div>
				<div class="col-sm-5"><input autocomplete="off" pattern=".{5,}" id="title" name="title" class="inputbox form-control" value="<?php echo $this->row['title'];?>" required /></div>
				<div class="col-sm-1"><label class="control-label" for="category">Category:</label> </div><div class="col-sm-2"><?php 
				
				echo '<SELECT name="category" id="category" class="category form-control dropdown-header"><OPTION value="">...</OPTION>';
				foreach ($this->cats as $cat){
					echo($cat);
				}
				echo '</SELECT>';
				?></div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-1 hide"><label class="control-label" for="comments">Comments:</label> </div><div class="col-sm-5 hide"><input id="comments" name="comments" class="inputbox form-control" value="<?php echo $this->row['comments'];?>" /></div>
			<div class="col-sm-1"><label class="control-label" for="size">Size:</label> </div><div class="col-sm-2"><input type="number" step="any" id="size" name="size" class="inputbox form-control" value="<?php echo $this->row['art_size'];?>" /></div>
			<div class="col-sm-1"><label class="control-label" for="unit">Unit:</label> </div><div class="col-sm-2">
			<input id="unit" list="units" name="unit" class="inputbox form-control" value="<?php echo $this->row['unit'];?>" />
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
			</div>
			<div class="row well-sm hide">
				<div class="col-sm-1 hide"><label class="control-label" for="ref_code">Ref#:</label> </div><div class="col-sm-2 hide"><input id="ref_code" name="ref_code" class="inputbox form-control" value="<?php echo $this->row['ref_code'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="packing">Packing:</label> </div><div class="col-sm-2"><input type="number" id="packing" name="packing" class="inputbox form-control" value="<?php echo $this->row['packing'];?>" /></div>
			</div>
		</fieldset>
			
		
		
		<?php
		if ($this->sub){?>
		<fieldset class="form">
			<div class="form grid">
				<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
				<div class="row well-sm">
					<div class="col-sm-2">
						<div><label class="control-label" for="cost_price">Cost Price:</label></div><div><input autocomplete="off" id="cost_price" name="cost_price" class="inputbox form-control" value="<?php echo $this->sub['cost_price'];?>" autofocus /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="sale_price">Sale Price:</label> </div><div><input autocomplete="off" id="sale_price" name="sale_price" class="inputbox form-control" value="<?php echo $this->sub['sale_price'];?>" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="qty">Qty:</label></div><div><input autocomplete="off" id="qty" name="qty" class="inputbox form-control" value="<?php echo $this->sub['qty'];?>" tabindex="-1" readonly /></div>
					</div>
					<div class="col-sm-2 hide">
						<div><label class="control-label" title="Min stock alert" for="min_stock">Alert:</label></div><div><input autocomplete="off" id="min_stock" name="min_stock" class="inputbox form-control" value="<?php echo $this->sub['min_stock'];?>" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="discount">Discount:</label></div><div><input autocomplete="off" id="discount" name="discount" class="inputbox form-control" value="<?php echo $this->sub['discount'];?>" /></div>
					</div>
					<div class="col-sm-2">
						<div><label class="control-label" for="expiry_alert_days">Expiry alert:</label></div><div><input autocomplete="off" id="expiry_alert_days" name="expiry_alert_days" class="inputbox form-control" value="<?php echo $this->sub['expiry_alert_days'];?>" /></div>
					</div>
				</div>
				<div class="row well-sm hide">
					<div class="col-sm-1"><label class="control-label" for="loc_section">Location: </label></div><div class="col-sm-1"><input autocomplete="off" id="loc_section" name="loc_section" class="inputbox form-control" value="<?php echo $this->sub['loc_section'];?>" /></div>
					<div class="col-sm-1"><label class="control-label" for="loc_rack">-</label> </div><div class="col-sm-1"><input autocomplete="off" id="loc_rack" name="loc_rack" class="inputbox form-control" value="<?php echo $this->sub['loc_rack'];?>" /></div>
					<div class="col-sm-1"><label class="control-label" for="loc">-</label> </div><div class="col-sm-1"><input autocomplete="off" id="loc" name="loc" class="inputbox form-control" value="<?php echo $this->sub['loc'];?>" /></div>
				</div>
				<div class="row well-sm">
					<div id="sale_price_terms" class="json-box col-sm-3">
						<div><label class="control-label" for="sale_price_terms">Price Terms:</label></div>
						<div><input type="hidden" name="sale_price_terms" class="inputbox form-control json-data" value="<?php echo htmlspecialchars($this->sub['sale_price_terms']);?>" /></div>
						<div class="json-form-el-list">
							<div class="json-form-add">
								<div class="data-fields"><input class="json-value inputbox form-control input-sm" data-datatype="number" data-key-name="qty" value="" /><input class="json-value inputbox form-control input-sm" data-datatype="number" data-key-name="price" value="" /></div>
								<div class="actions"><button class="json-btn btn btn-primary btn-sm btn-flat" tabindex="-1"><i class="glyphicon glyphicon-plus"></i> Add</button></div>
							</div>
							<div>
								<table>
									<thead><tr><!--<th class="col1">Opt</th>--><th class="col2">Qty</th><th class="col3">Price</th><th class="col4">Action</th></tr></thead>
									<tbody><script>
										var data = <?php if(isset($this->sub['sale_price_terms']) && $this->sub['sale_price_terms']){echo $this->sub['sale_price_terms'];}else{echo '[]';}?>;
										if(data){
											$.each(data, function(i, v) {
												document.write('<tr>');
												document.write('<td  data-key-name="qty">'+v.qty+ '</td>');
												document.write('<td  data-key-name="price">'+v.price+ '</td>');
												document.write('<td class="delete"><a onclick="removeJSONRow(this);return false;"> X </a></td>');
												document.write('</tr>');
											});
										}
									</script>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="stock_expiry_dates" class="json-box col-sm-3">
						<div><label class="control-label" for="stock_expiry_dates">Stock Expiry:</label></div>
						<div><input type="hidden" name="stock_expiry_dates" class="inputbox form-control json-data" value="<?php echo htmlspecialchars($this->sub['stock_expiry_dates']);?>" /></div>
						<div class="json-form-el-list">
						<div class="json-form-add">
							<div class="data-fields"><input class="json-value inputbox form-control input-sm" data-datatype="number" data-key-name="qty" value="" /><input class="json-value date inputbox form-control input-sm" data-datatype="date" data-key-name="expiry" value="" /></div>
							<div class="actions"><button class="json-btn btn btn-primary btn-sm btn-flat" tabindex="-1"><i class="glyphicon glyphicon-plus"></i> Add</button></div>
						</div>
						<div>
							<table>
								<thead><tr><!--<th class="col1">Opt</th>--><th class="col2">Qty</th><th class="col3">Expiry</th><th class="col4">Action</th></tr></thead>
								<tbody><script>
									var data = <?php if(isset($this->sub['stock_expiry_dates']) && $this->sub['stock_expiry_dates']){echo $this->sub['stock_expiry_dates'];}else{echo '[]';}?>;
									if(data){
										$.each(data, function(i, v) {
											document.write('<tr>');
											document.write('<td data-key-name="qty" data-datatype="number">'+v.qty+ '</td>');
												var dt= new Date(v.expiry);
												var strDay=dt.getDate();
												if(strDay<10){
													strDay = '0'+strDay;
												}
												var strMonth=dt.getMonth()+1;
												if(strMonth<10){
													strMonth = '0'+strMonth;
												}
												var strDate=dt.getFullYear()+'/'+strMonth+'/'+strDay;
				
											document.write('<td data-key-name="expiry" data-datatype="date">'+strDate+ '</td>');
											document.write('<td class="delete"><a onclick="removeJSONRow(this);return false;"> X </a></td>');
											document.write('</tr>');
										});
									}
								</script>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				
				
			<div class="col-sm-3">
				<div class=""><label class="control-label" for="tags">Features:</label></div><div class=""><?php 
			
				echo '<SELECT name="tags[]" id="tags" class="form-control" size="10" multiple>';
				if(!$tg){
					echo '<OPTION value=""></OPTION>';
				}/**/
				foreach ($this->tags as $t){
					$sel='';
					$as = array_search($t['tag'], $tg);
					if($as>=1 || $as === 0){$sel=' selected';}
					echo '<OPTION value="' . $t['tag'] . '" ' . $sel . ' >' . $t['tag'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
			
			<div class="col-sm-3">
				<div class=""><label class="control-label" for="seasons">Seasons:</label></div><div class=""><?php 
			
				echo '<SELECT name="seasons[]" id="seasons" class="form-control" size="10" multiple>';
				if(!$ss){
					echo '<OPTION value=""></OPTION>';
				}/**/
				foreach ($this->seasons as $s){
					$sel='';
					$as = array_search($s['id'], $ss);
					if($as>=1 || $as === 0){$sel=' selected';}
					echo '<OPTION value="' . $s['id'] . '" ' . $sel . ' >' . $s['title'] . '</OPTION>';
				}
				echo '</SELECT>';
				?></div>
				
			</div>
				
			</div>
			
				
			</div><!--form grid-->
			<div class="row well-sm hide">
				<div class="col-sm-1"><label class="control-label" for="discount_terms">Terms:</label> </div><div class="col-sm-5"><input id="discount_terms" name="discount_terms" class="inputbox form-control" value="" readonly /></div>
			</div>
	</div>
			<div class="btn-group">
			<ul class="form-buttons">
				<div class="row well-sm">
					<span><button type="reset" id="Cancel" class="btn btn-danger" value="Cancel" onclick="history.back();self.close();" tabindex="-1" ><i class="glyphicon glyphicon-off"></i> Cancel</button></span>
					<span><button class="btn btn-warning" type="reset" name="reset" tabindex="-1" ><i class="glyphicon glyphicon-remove"></i> Reset</button></span>
					<span><button type="submit" name="save" id="save" class="btn btn-success" tabindex="-1" ><i class="fa fa-save"></i> Save</button></span>
				</div>
			</ul>
			</div>
	</fieldset>
	</form></div><?php
		}elseif($this->id){
			$stock_link = "?com=articles&view=branch_article&task=edit&create_record=1&id={$this->id}";
			echo '<div class="btn-group"><a href="' . $stock_link . '" title="Create Recrod" class="btn btn-info">Create Record</a></div>';
		}else{
} ?>