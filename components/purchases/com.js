
currCell = $('.nav-able td').first();


function cals_reportItemsTotal(){
	var subTotal =0;
	//console.log('helloo');
	var subTotalMargin =0;
	$('#tblContentBody tr td').each(function( index, element ){
		var style = $( element ).parent().css( "display");
		if(style != 'none'){
		//$("#sub_total").val((eval($("#sub_total").val()) + eval($(element).text())).toFixed(2));
		var cellTotal = $(element).hasClass('total');
		var cellMargin = $(element).hasClass('margin');
        //if(($.trim($(this).text()).length>0)){
        // console.log($(this).text());
        //}
		//});
		
		if(cellTotal==true){
			//console.log($(this).text());
			subTotal += eval($(this).text());
		}
		
		if(cellMargin==true){
			//console.log($(this).text());
			subTotalMargin += eval($(this).text());
		}
		
		//console.log(r);
		
		}
	});
	$('#subTotal').text(subTotal);
	$('#subTotalMargin').text(subTotalMargin);

}


function getArtDetails(){
	//console.log('hello');
	var txt = $("input#article_code").val();
	var frm = $("#frm_main_state").val();
	if(frm=="unset"){alert('Please create a purchase record first.');return false;}
	if(txt==""){return false;}
	$.post("?com=purchases&view=ajax&task=html&part=itemByID&tmpl=com", {filter_text: txt}, function(result){
		//alert(result);
		//var obj = result;
		//console.log(result);
		var obj = JSON.parse(result);
		if(!obj){
			$('#title').val('No Item found');
			return false;
		}
		//console.clear();
		clearArtForm();
		$('#article_code').val(obj.article_code);
		$('#ref_code').val(obj.ref_code);
		$('#title').val(obj.title);
		$('#packing').val(obj.packing);
		$('#cost_price').val(obj.cost_price);
		$('#sale_price').val(obj.sale_price);
		//$('#whole_sale_price').val(obj.whole_sale_price);
		$('#qty').val(obj.qty);
		//$('#margin').val(obj.sale_price-obj.cost_price);
		$('#batch_no').val(obj.batch_no);
		$('#mfg_date').val(obj.mfg_date);
		$('#expire_date').val(obj.expire_date);
	});

}

function saveArticle(){
	var frm_type = $('#form_type').val();
	var url = '?com=purchases&view=ajax&task=html&part=savePurchaseArt&tmpl=com';
	var frm = '#frm_pur_art';
	if(frm_type=='return_main'){
		url = '?com=purchases&view=ajax&task=html&part=saveReturnArt&tmpl=com';
		frm = '#frm_ret_art';
	}
	//console.log(frm_type);
	$.post(url, $(frm).serialize(), function(result){
		$(".table-responsive").html(result);
		//console.log(result);
	});
	clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}

	$(function () {
		//Initialize Select2 Elements
		//$('select').select2()
	})

function remPurItem(v_id, item, qty){
	$.post('?com=purchases&view=ajax&task=html&part=remPurItem&tmpl=com', {id: v_id, itm: item,remQty:qty}, function(result){
		$(".table-responsive").html(result);
		//console.log(result);
	});
	//clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}


function remRetItem(v_id, item, qty){
	$.post('?com=purchases&view=ajax&task=html&part=remRetItem&tmpl=com', {id: v_id, itm: item,remQty:qty}, function(result){
		$(".table-responsive").html(result);
		//console.log(result);
	});
	//clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}

function clearArtForm(){
	$("#article_code").val('');
	$('#ref_code').val('');
	$('#title').val('');
	$('#packing').val('');
	$('#cost_price').val('');
	$('#qty_scheme').val('');
	$('#sale_price').val('');
	//$('#whole_sale_price').val('');
	$('#qty').val('');
	$('#margin').val('');
	$('#batch_no').val('');
	$('#mfg_date').val('');
	$('#expire_date').val('');
}
	function close_window() {
		if (confirm("Close Window?")) {
			close();
		}
	}
$(document).ready(function(){

	currCell = $('.nav-able td').first();
	$('.nav-able td').focus();

	$("input.number").keypress(function(e){
		e.stopPropagation();
		if(!inputNumber(e)){e.preventDefault();}
	});

	$("#save_art").click(function(e){
		e.preventDefault();
	});
	$("input#article_code").keypress(function(e){
		e.stopPropagation();
		var key = e.keyCode || e.which;
		if (key==13){
			e.preventDefault();
			var txt = $("input#article_code").val();
			//console.log(txt);
			if(txt==""){return false;}
			txt = txt.toString();
			var pos = txt.substr(0,1);
			if(pos=="-"){
				artSearch(txt,'article_code','js_win');
				return false;
			}
			getArtDetails(txt,true);
			$('#qty_scheme').focus();
			$('#qty_scheme').select();
			return false;
		}
	});
	
	$("input#qty_scheme").keypress(function(e){
		e.stopPropagation();
		var key = e.keyCode || e.which;
		if (key==13){
			e.preventDefault();
			var txt = $("input#article_code").val();
			var qty = $("input#qty_scheme").val();
			if(!txt){return false;}
			if(!qty){return false;}
			saveArticle();
			$('#article_code').focus();
			$('#article_code').select();
	}
		//return false;
	});
	
	$("input#expire_date").keypress(function(e){
		e.stopPropagation();
		var key = e.keyCode || e.which;
		if (key==13){
			e.preventDefault();
			var txt = $("input#article_code").val();
			var qty = $("input#qty_scheme").val();
			if(!txt){return false;}
			if(!qty){return false;}
			saveArticle();
			$('#article_code').focus();
			$('#article_code').select();
	}
		//return false;
	});
	
$('.nav-able td').click(function () {
	currCell = $(this);

	var col = $(this).parent().children().index($(this)) + 1;
	var row = $(this).parent().parent().children().index($(this).parent()) + 1;
	//alert('Row: ' + row + ', Column: ' + col + ', Value: ' + currCell.html());

	//   edit();
});

	$('table.nav-able').keydown(function (e) {
		currCell = navigateTableCells(e, currCell)
	});

	// User can cancel edit by pressing escape
	$('#edit').keydown(function (e) {
	var key = e.keyCode || e.which;
	if (key == 27) {
	// close model form
	}
	});
	
	$('.nav-able td').keydown(function (e) {
	var key = e.keyCode || e.which;
	if (key == 13) {
	// close model form
	}
	});
	
	$('body').keydown(function (e) {
		var key = e.keyCode || e.which;
		//console.log(key);
		if (e.ctrlKey){
			if (key == 65){
				// close model form
				e.preventDefault();
				$('#save_art').trigger('click');
			}
		}
	});
	
	
	$('table.nav-able').keydown(function(e){
		var key = e.keyCode || e.which;
		if (key == 13) {
			// close model form
			//alert('entered');
			$('#article_code').val(currCell.html());
			$('.modal.in').modal('hide');
			getArtDetails(currCell.html(),true);
			$('#qty_scheme').focus();
			$('#qty_scheme').select();
			return false;
		}
		currCell = navigateTableCells(e, currCell);
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
	
	
	
	
	
});