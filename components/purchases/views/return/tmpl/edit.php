<?php
defined('_MEXEC') or die ('Restricted Access');

$id=0;
$status='';
$comments='';
$return_id=0;

if($this->id){
	$id = $this->id;
	$ret = $this->ret;
	$status = $ret['status'];
	$return_id = $ret['id'];
	$comments = $ret['comments'];
}

//echo $id . '<br/>';
//echo $ret['return_id'];
//var_dump($ret);exit;
//exit;
?><div class="com-head">
<script type="text/javascript">

</script>
</div>
  <!-- Select2 -->
  <link rel="stylesheet" href="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/css/select2.min.css">
<!-- Select2 -->
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/select2/dist/js/select2.full.min.js"></script>

<!--<p><span class="suggest"></span></p>-->
<div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose an item</h4>
        </div>
        <table class="modal-body nav-able"></table>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  

<form class="form-inline" method="post" name="frm" action="?com=purchases&view=return<?php if($id){echo '&id='.$id;} ?>">
		<fieldset class="form">
		<div class="form grid">
			<input type="hidden" id="form_type" name="form_type" value="return_main" />
			<input type="hidden" id="frm_main_state" name="frm_main_state" value="<?php
				if($id){
					echo 'edit';
				}else{
					echo 'unset';
				}
			?>" />
			<input type="hidden" name="status" value="<?php echo $status ;?>" />
			<input type="hidden" name="return_id" value="<?php echo $return_id; ?>"  />
			<input type="hidden" name="return_" value="<?php echo $return_id; ?>" />
			<input type="hidden" name="comments" value="<?php echo $comments; ?>" />
			<input type="hidden" name="payment_date" value="" />
			<div class="btn-group">
			</div><hr/>
			<div class="row well-sm">
				<div class="col-sm-3">
					<SELECT name="supplier_id" class="form-control input-sm flat" required <?php if($id){echo 'readonly';} ?> >
						<OPTION value=""></OPTION><?php
						//var_dump($sup_list);exit;
							foreach ($this->sup_list as $sl){
								$selected="";
								if ($ret['supplier_id']==$sl['id']){$selected='selected="selected"';}
								echo '<OPTION value="' . $sl['id'] . '" ' . $selected . ' >' . $sl['title'] . '</OPTION>';
							}
					?></SELECT>
				</div>
				<div class="col-sm-2"><input name="ref_inv_no" placeholder="Reference #" class="inputbox form-control input-sm" value="<?php if(isset($ret)){ echo $ret['ref_inv_no'];}?>" tabindex="-1" <?php if($id){echo 'disabled';} ?> /></div>
				<div class="col-sm-2"><input type="date" name="return_date" class="inputbox form-control input-sm date<?php if(!isset($ret)){ echo '-default';}?>" value="<?php if(isset($ret)){ echo $ret['return_date'];}?>" tabindex="-1" <?php if($id){echo 'disabled';} ?> /></div>
				<?php if(!$id){ ?><span><button id="save" name="save" id="save" class="btn btn-success btn-sm btn-flat" tabindex="-1"><i class="fa fa-save"></i> New</button></span><?php } ?>
			</div><?php if($id){ ?>
			<div class="row well-sm">
				<div class="col-sm-2"><input type="number" placeholder="Amount" name="amount" class="inputbox form-control input-sm" value="<?php if(isset($ret['amount']) && $ret['amount']){ echo $ret['amount'];}?>" tabindex="-1" readonly /></div>
				<div class="col-sm-2"><input type="number" placeholder="Cash" name="cash" class="inputbox form-control input-sm" value="<?php if(isset($ret) && $ret['cash']){ echo $ret['cash'];}?>" tabindex="-1" step="any" <?php if($status){echo 'disabled';} ?> /><span class="validity"></span></div>
				<div class="col-sm-2"><input type="number" placeholder="Credit" name="credit" class="inputbox form-control input-sm" value="<?php if(isset($ret) && $ret['credit']){ echo $ret['credit'];}?>" tabindex="-1" step="any" <?php if($status){echo 'disabled';} ?> /><span class="validity"></span></div>
				<div class="col-sm-1 hide"><label class="control-label" for="finish_return">Finish:</label></div><div class="col-sm-1 hide"><input type="checkbox" name="finish_return" class="checkbox" tabindex="-1" <?php if($status){echo 'disabled';} ?> checked /></div>
				<div class="col-sm-1">&nbsp;</div>
				<?php if(!$status){?><span><button id="save" name="save" id="save" class="btn btn-success btn-sm btn-flat" tabindex="-1"><i class="fa fa-edit"></i> Done</button></span><?php }?>
			</div>
			<div class="row well-sm hide">
				<div class="col-sm-1 grid-label"><label class="control-label" for="credit_terms">CreditTerms:</label></div><div class="col-sm-8"><input name="credit_terms" class="inputbox form-control input-sm" value="<?php if(isset($ret)){ echo $ret['credit_terms'];} ?>" tabindex="-1" /></div>
			</div><?php } ?>
			</div><div class="clear"></div>
		</fieldset></form><hr/><?php
	
	if(!$this->ret['status']){
	?><form class="form-inline screen" method="post" id="frm_ret_art" name="frm_ret_art" action="?com=purchases&view=return<?php if($this->id){echo '&id='.$this->id;} ?>">
		<fieldset class="form">
			<legend>Items</legend>
			<div class="form grid">
				<input type="hidden" name="form_type" value="return_items" />
				<input type="hidden" name="return_id" value="<?php if(isset($ret)){ echo $ret['id'];} ?>" />
				<div class="row well-sm">
					<div class="col-sm-3"><input placeholder="Item #" id="article_code" name="article_code" class="inputbox form-control input-sm" value="" autofocus /></div>
					<div class="col-sm-2"><input placeholder="Stock" id="qty" name="qty" class="inputbox form-control input-sm number" value="" readonly tabindex="-1" /></div>
				</div>
				<div class="row well-sm">	
					<div class="col-sm-3"><input placeholder="Title" id="title" name="title" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div>
					<div class="col-sm-1"><input type="number" step="any" placeholder="Cost" id="cost_price" name="cost_price" class="inputbox form-control input-sm col-sm-1 number" value="" /></div>
					<div class="col-sm-1"><input placeholder="Price" type="number" step="any" id="sale_price" placeholder="Price" name="sale_price" class="inputbox form-control input-sm number" value="" /></div>
					<div class="col-sm-1"><input type="number" step="any" id="qty_scheme" placeholder="Qty" name="qty_scheme" class="inputbox form-control input-sm number" value="" /></div>
					<div class="col-sm-2 hide"><input type="number" step="any" id="scheme" name="scheme" placeholder="Scheme" class="inputbox form-control input-sm number" value="0" /></div>
					<div class="col-sm-2 hide"><input type="checkbox" id="update_main_prices" name="update_main_prices" class="checkbox" tabindex="-1" /></div>

					<div class="col-sm-1"><input id="batch_no" placeholder="Batch #" name="batch_no" class="inputbox form-control input-sm col-sm-1" value="" /></div>
					<div class="col-sm-2"><input type="date" id="expire_date" placeholder="Expiry" name="expire_date" class="inputbox form-control input-sm date<?php if(!isset($ret)){ echo '-default';}?>" value="" /></div>
					<div class="col-sm-1"><span><button id="save_art" name="save_art" id="save_art" class="btn btn-success btn-sm btn-flat" tabindex="-1" onclick="saveArticle();return false;"><i class="glyphicon glyphicon-plus"></i> Add</button></span></div>
				</div>
			</div><div class="clear"></div>
			<hr/>
		</fieldset>
	</form><?php
		}
?></div>