<?php
defined('_MEXEC') or die ('Restricted Access');

$app = core::getApplication();
$message=$app->getMessage();
$user = core::getUser();
$u = $user->getUser();
$company = $user->getCompany();
$print=0;
if(isset($_GET['print'])){
	$print = $_GET['print'];
}
//var_dump($user->getUser());exit;
/*
billing_contacts


*/

?>
<form id="invArts">
<div id="header">
	<div id="logo-section">
		<div id="logo" style="background-image:url('templates/default/images/branches/<?php echo $company['id'];?>/bill_logo_<?php echo $u['branch_id'];?>.jpg');">
			<img src="templates/default/images/branches/<?php echo $company['id'];?>/bill_logo.jpg" alt="Logo" title="Logo" />
		</div>
		<div id="company">
			<div class="title"><?php echo $app->branch_title; ?></div>
			<div class="address"><?php if($company['billing_address']){ echo $company['billing_address'];}else{echo $app->branch_address;}; ?></div>
		<div class="doc-title">Quotation</div><div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="user">
		<p class="date-time left">
		<?php
		if(isset($this->inv["time_stamp"])){
			echo $this->inv['time_stamp'];
		}else{
			echo date('d / m /Y H:i:s');
		}
		?> - 
		</p><p class="user-name right"><?php echo $app->full_name ?></p>
	</div><div class="clear"></div>
	
	<div class="invoice_info">
	<div><label class="" for="quotation_id">Bill#:</label><input id="quotation_id" name="quotation_id" class="inputbox form-control input-sm" value="<?php if($this->id){echo $this->inv['id'];}?>" readonly tabindex="-1" /></div>
	<div><label class="" for="person">Person:</label><input id="person" name="person" class="inputbox form-control input-sm" value="<?php if(isset($pur)){ echo $pur['person'];}?>" /></div>
	<div class="customer"><label class="" for="customer_id">Name:</label><?php
	echo '<SELECT name="customer_id" id="customer_id" class="customer_id form-control dropdown-header">';
	echo '<OPTION value="">....</OPTION>';
	foreach ($this->customers as $c){
		echo '<OPTION value="' . $c['id'] . '">' . $c['title'] . '</OPTION>';
	}
	echo '</SELECT>';
	?>

</div>
	<div><label class="" for="cust_account_value">Balance:</label><input id="cust_account_value" name="cust_account_value" class="inputbox form-control input-sm number" value="" readonly tabindex="-1" /></div>
	<div class="address"><label class="" for="cust_address">Address:</label><input id="cust_address" name="cust_address" class="inputbox form-control input-sm" value="" readonly tabindex="-1" /></div>
	
<div id="message"><?php
	if($message['messages']){
		echo $message['messages'];
	}
?></div><div class="clear"></div>
</div><div class="clear"></div>
</div>




<div id="center">
	<div id="componant">
	
	<iframe id="ifrmPrint" style="width:0;height:0;"></iframe><?php
	$app = core::getApplication();
	$css_path = "templates/{$app->getTemplate()}/css/print_" . $this->u['print_paper_size'] . ".css";
	//$css_path = "templates/{$app->getTemplate()}/css/print_pos.css";

?><link rel="stylesheet" type="text/css" href="<?php echo $css_path;?>" media="print" />

<div class="form">
<div class="form-message"><span class="info"></span></div><?php
	$list = array();
	$list['view']='quotation';
	$list['task']='edit';
	$view = $this->getView('quotation', 'sales', 'edit');
	echo $view->display($list);
?></div>
<div class="table-responsive frm_quotation_art">
		<div class="row well-sm th">
			<div class="col-sm-2 cell screen item">Item#</div><div class="col-sm-4 cell title">Description</div><div class="col-sm-1 cell qty">Qty</div><div class="col-sm-1 cell price">Price</div>
			<div class="col-sm-1 cell screen disc">Dis.</div><div class="col-sm-1 cell price">Amount</div><div class="col-sm-1 cell stock screen">Stock</div><div class="col-sm-1 cell screen action">Action</div>
		</div><div id="invArticles">
		</div>
</div>
		<fieldset class="form-bill-total">
		<div class="grid">
			<input type="hidden" name="form_type" value="quotation" />
			<input type="hidden" id="bill_status" name="bill_status" value="" />
			<div class="row well-sm">
				<div><label class="control-label" for="sub_total">Total:</label><div><input id="sub_total" name="sub_total" class="inputbox form-control input-sm number" value="0" readonly tabindex="-1" /></div></div>
				<div><label class="control-label" for="discount_amount">Discount:</label><div><input id="discount_amount" name="discount_amount" class="inputbox form-control input-sm number" value="0" tabindex="-1" readonly /></div></div>
				<div><label class="control-label" for="net_total">Amount:</label><div><input id="net_total" name="net_total" class="inputbox form-control input-sm" value="" tabindex="-1" readonly /></div></div>
				<div class="hide"><label class="control-label" for="cash">Cash:</label><div><input data-toggle="tooltip" data-placement="top" title="Shortcut 'Insert' key" id="cash" name="cash" class="inputbox form-control input-sm" value="" /></div></div>

				<div class="screen">
				<label>&nbsp;</label>
				<a href="#" id="inv-done" class="btn btn-primary btn-lg" tabindex="-1" onclick="calc_bill();setQuotationData();printInvoice();window.print();return false;">Save</a>
				</div>

			</div><div class="clear"></div>
		</div><div class="clear"></div>
		</fieldset>

	</div>
</div>
<div id="billing_notes" class="print">
<?php if($company['billing_notes']){ echo $company['billing_notes'];} ?>
</div>

<div id="billing_contacts" class="print">
<?php if($company['billing_contacts']){ echo $company['billing_contacts'];} ?>
</div>

</form>
<?php
if(isset($this->inv["data_articles"]) && ($this->inv["data_articles"])){
	$json_data= "var json_data = " . $this->inv["data_articles"] . "";
}else{
	$json_data='var json_data = ""';
}
if(isset($this->inv["status"])){
	$status= $this->inv["status"];
}else{
	$status="Open";
}
$cash=0;
if(isset($this->inv["cash"]) && ($this->inv["cash"])){
	$cash=$this->inv["cash"];
}
$script = '











	$("#article_code").focus();
	$("#article_code").select();
	$("input#article_code").keypress(function(e){
		//alert(txt_article);
		e.stopPropagation();
		txt_article = $("input#article_code").val();
		if (e.which==13){
			//return false;
			txt_article = txt_article.toString();
			var pos = txt_article.substr(0,1);
			if(pos=="-"){
				artSearch(txt_article);
				return false;
			}
			getArtInfoQuotation(txt_article);

		
		} //end which
	});

		$("#sub_total").change(function(e){
		//e.stopPropagation();
			subTotal = subTotal - eval($("#sub_total").val());
			//console.log(subTotal);
			calc_bill();
	});

	$("#cash").keyup(function(e){
		e.stopPropagation();
		if (e.which==13){
			if($("#bill_status").val()=="Open"){
				calc_bill();
				var res = setQuotationData();
				if(!res){return false;}
				//printInvoice();
				$("#article_code").focus();
				$("#article_code").select();
			}
			console.log("done inv");
			return false;
		} //end which
	});

	$("#credit").keyup(function(e){
		e.stopPropagation();
		if (e.which==13){
			$("#cash").focus();
			$("#cash").select();
			calc_bill();
			return false;
		} //end which
	});

	$("input#qty1").keypress(function(e){
		e.stopPropagation();
		if (e.which==13){
			$("#discount-item").focus();
			$("#discount-item").select();
			//preSetQArticle();
		} //end which
	});
	
	$("input#discount-item").keypress(function(e){
		e.stopPropagation();
		if (e.which==13){
			preSetQArticle();
		} //end which
	});
	
	$("input#discount_amount").keyup(function(e){
		//e.stopPropagation();
		if (e.which==13){
			$("#cash").focus();
			$("#cash").select();
			calc_bill();
			return false;
		} //end which
	});

	$("#customer_id").change(function(e){
		//e.stopPropagation();
		$("#cust_address").val("");
		$("#cust_account_value").val("");
		var cus = $("#customer_id option:selected").val();
		if(cus){
			$("#customer_id").closest(".customer").removeClass("screen");
		}else{
			$("#customer_id").closest(".customer").addClass("screen");
		}
		$("#cust_name").val($("#customer_id option:selected").text());
		var customer_id = $("#customer_id").val();
		if(!customer_id){return false;}
	$.post("?com=customers&view=customer&task=json&tmpl=com", {id: customer_id}, function(obj){
		//console.log(result);
		//var obj = JSON.parse(result);
		//console.log(obj.id);
		//console.log(typeof(result));
		if(!obj){showMsg("Data not saved");return false;}
		$("#cust_account_value").val(eval(obj.account_value));
		$("#cust_address").val(obj.address);
		calc_bill();
		if(obj.account_value>0){
			$("#cash").focus();
			$("#cash").select();
			return false;
			
		}
		return obj;
	});
	});

	$("div.form-bill-total input").focusout(function(e){
		calc_bill();
		return false;
	});

	$("input.number").keypress(function(e){
		//e.stopPropagation();
		if(!inputNumber(e)){return false;}
	});

	$("table.nav-able").keydown(function(e){
	//console.log(e.which);
		if (e.which == 13) {
			// close model form
			//alert("entered");
			var cur_cell = currCell.html().toString();
			$("#article_code").val(cur_cell);$(".modal.in").modal("hide");getArtInfoQuotation(currCell.html(),true);return false;
		}
		currCell = navigateTableCells(e, currCell)
	});

	$("#art-ok").click(function(e){
		e.preventDefault();
		//alert("clicked");
		//console.log(multiQty);
		if(multiQty){
			preSetQArticle();
			//alert("multiQty");
			multiQty=false;
		}else{
			getArtInfoQuotation($("input#article_code").val());
			//alert("single");
		}
		return false;
	});

	$("#search_filter").focus();
	$("#search_filter").select();
	$("input#search_filter").keyup(function(e){
		var value = $(this).val().toLowerCase();
		$("#tblContentBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		//culculate values
		cals_reportItemsTotal();
	});
	
	
	
	
	
	
    $("body").keydown(function(e){
		var key = e.keyCode || e.which;
		var vFind = "";
		if (key==45){
			vFind = $("input#cash");
			if(vFind.length){
				vFind.focus();
				vFind.select();
				e.preventDefault();
			}
		}
        if(e.ctrlKey){
				console.log(key);
            if (key==67){
            e.preventDefault();
                vFind = $("select#customer_id");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
            if (key==68){
            e.preventDefault();
                vFind = $("input#discount_amount");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        }else{return;}
    });

	

	' . $json_data. '
	var row_id=1;
	var status ="' . $status . '";
	if(status==0){$("#bill_status").val("Open");unlockForm(false);}
	if(status==1){$("#bill_status").val("Closed");lockForm();}
	$("#cash").val("' . $cash . '");
	$.each(json_data, function(i, v) {
		//addBillRow(row_id, v.article_code, v.price, v.qty,v.stock,status, v.title, v.price_terms, v.discount,v.tp_price);
		addBillRow(row_id, v.article_code, v.price, v.qty,v.stock,status, v.title, "", v.discount,v.tp_price);
		row_id++;
	});




';

$app->setScript($script);

?>
<script>

$("#article_code").autocomplete({
    source:function(request,response){
        $.ajax({
          type: "GET",
          data:{txt: request.term},
          url: "?com=articles&view=branch_articles&task=json&tmpl=com&comboList=1",
          dataType: "json",
          success:function(data){
			var list= [];
			$.each(data,function (i,e){
				list.push({value:e.article_code, label:e.label});
			});
			response($.map(list, function (value, key) {
                return {label: value.label,value: value.value};
            }));
			
           }
         });
    },      
    minLength:2,
    delay: 100
});

<?php if($print){
	echo '$(document).ready(function () {window.print();});';
	echo 'window.setTimeout(function(){window.location = "?com=sales&view=quotation";}, 0);';

} ?>
</script>