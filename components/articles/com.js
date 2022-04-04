var invArts= [];
var multiQty=false;
var txt_article='';
var subTotal=0;
var invRowCount=0;
currCell = $('.nav-able td').first();

function removeArticle(id=0, msg='Confirm Action!!!') {
	//var r = prompt("","");
	if(!id){
		return false;
	}
	var r = confirm(msg);
	if(!r){
		return false;
	}
	
}

function remArticlePrice(v_id, item){
	$.post('?com=articles&view=ajax&task=html&part=remArticlePrice&tmpl=com', {id: v_id, itm: item}, function(result){
		$(".table-responsive").html(result);
		//console.log(result);
	});
	//clearArtForm();
	$("#article_code").focus();
	$("#article_code").select();
}

function clearPriceForm(){
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
function setLocalData(db_url, data){
	/*$.post(url, $('#invArts').serialize(), function(result){
		$('#sale_').val(eval(result));
		$('#sale_id').val(eval(result));
		$('#bill_status').val('Closed');
		//return false;
	});*/
	$.ajax({
		type:"POST",
		url:db_url,
		contentType:"application/json",
		data:JSON.stringify(data),
		dataType:"json",
		success:function(data){
			return data.id;
		}
		
	});
	//$( "#discount" ).prop( "readonly", true );
	return false;

}

function getData(){
	//var data = {};
	//if(use_local_storage){
		var url = br_dt_opt.host + 'items/_all_docs';
		var res=getLocalData(url);
		data = res;
		//data=getLocalData(br_dt_opt.host + 'items');
		//console.log( 'dataaaa...');
		console.log(data);
	//}
	
	//Live server url
	//?com=articles&view=branch_articles&task=json
	
	return data;

}

function getLocalData(db_url){
	jQuery.browser = {};
	(function () {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();
	return false;
	
}

function getArtInfo(txt,mQty = false){
	if(txt==''){return false;}
		multiQty = false;
		txt = txt.toString();
		//console.log(txt);
		$('#title').val('');
		//console.log(txt);
	$.post("?com=articles&view=article&task=json&tmpl=com", {article_code: txt}, function(result){
		//var obj = JSON.parse(result);
		//console.log(result+'ff');
		var obj = result;
		if(!obj){
			$('#title').val('No Item found');
			return false;
		}
		$('#title').val(obj.title);
		$('#qty1').val(obj.qty1);
		var qty1 = eval($('#qty1').val());
		$('#qty').val(obj.qty);
		$('#scheme').val(obj.scheme);
		$('#discount').val(obj.discount);
		$('#cost_price').val(obj.cost_price);
		$('#sale_price').val(obj.sale_price);
		$('#category').val(obj.category);
		$('#size').val(obj.art_size);
		$('#unit').val(obj.unit);
		return false;
	});
	
	
}

$(document).ready(function(){
	
	$("#article_code").focus();
	$("#article_code").select();
	$("input#article_code").keypress(function(e){
		//alert(txt_article);
		e.stopPropagation();
		txt_article = $("input#article_code").val();
		var key = e.keyCode || e.which;
		if (key==13){
			//return false;
			txt_article = txt_article.toString();
			var pos = txt_article.substr(0,1);
			if(pos=="-"){
				artSearch(txt_article);
				return false;
			}
			getArtInfo(txt_article);
			return false;
		
		}
	});

	

}); //document.ready()
	
	
	