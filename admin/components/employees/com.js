var invArts= [];
var multiQty=false;
var txt_article='';
var subTotal=0;
var invRowCount=0;
currCell = $('.nav-able td').first();

function cals_subTotal(){
	$('#invArticles .row .total').each(function( index, element ){
		// element == this
		//$( element ).css( "backgroundColor", "yellow" );
		$("#sub_total").val((eval($("#sub_total").val()) + eval($(element).text())).toFixed(2));
	});

}

function cals_reportItemsTotal(){
	var subTotal =0;
	var subTotalMargin =0;
	$('#tblContentBody tr td').each(function( index, element ){
		var style = $( element ).parent().css( "display");
		if(style != 'none'){
			var cellTotal = $(element).hasClass('total');
			var cellMargin = $(element).hasClass('margin');
			
			if(cellTotal==true){
				subTotal += eval($(this).text());
			}
			if(cellMargin==true){
				subTotalMargin += eval($(this).text());
			}
		}
	});
}


function setPostData(){
	$.post('?com=sales&view=ajax&task=html&part=setInvArticle&tmpl=com', $('#invArts').serialize(), function(result){
		//var obj = JSON.parse(result);
		//console.log(obj.id);
		//console.log(result);
		//console.log(typeof(result));
		$('#sale_').val(eval(result));
		$('#sale_id').val(eval(result));
		$('#bill_status').val('Closed');
		//return false;
	});
	$( "#cash" ).prop( "readonly", true );
	$( "#credit" ).prop( "readonly", true );
	$( "#bank_card" ).prop( "readonly", true );
	$( "#bank_check" ).prop( "readonly", true );
	$( "#discount" ).prop( "readonly", true );
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
		//var r = JSON.stringify(result)
		//var obj = JSON.parse(result);
		//console.log(result+'ff');
		var obj = result;
		if(!obj){
			$('#title').val('No Item found');
			return false;
		}
		//window.location.assign("https://www.w3schools.com"); //load this location
		//console.log(result);
		//var loc_txt = window.location.search;
		
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

function clearArtForm(){
	$("#article_code").val('');
	$("#qty").val('');
	$("#qty1").val('');
	$("#scheme").val('');
	$("#title").val('');
	$("#sale_price").val('');
	var loc_txt = window.location.search;
	if(loc_txt=='?com=sales&view=distributor'){
		$("#retail").val('');
	}
	$("#cost_total").val('');
	$("#discount-item").val('');
	$("#article_code").focus();
	$("#article_code").select();
}

function updateJSONTable(ts){
	var json_box = $(ts).closest(".json-box");
	//console.log($(json_box).html());
	var frm_json = $(json_box).find(".json-form-el-list");
	var tbl_body = $(frm_json).find('table tbody').find('tr');
	var json_data = $(json_box).find("input.json-data");
	var rs = [];
	var x =0;
	$(tbl_body).each(function(i,tr){
			var t ={};
		$(tr).find('td').each(function(i,td){
			var k = $(td).data().keyName;
			if(k){
				var datatype = $(td).data().datatype;
				//console.log(datatype);
				if(datatype=='date'){
					var dt = new Date($(td).text());
					t[k] = dt.toJSON();
					rs[x] = t;
				}else{
					//console.log(k);
					t[k] = $(td).text();
					rs[x] = t;
				}
			}
		});
		x++;
	});
	rs = JSON.stringify({term:rs});
	$(json_data).val(rs);
}

function removeJSONRow(ts){
	//var json_box = $(ts).closest(".json-box");
	var json_box = $(ts).closest(".json-box");
	//console.log($(json_box).html());
	var frm_json = $(json_box).find(".json-form-el-list");
	var tbl_body = $(frm_json).find('table tbody');
	var json_data = $(json_box).find("input.json-data");
	var rs = [];
	var x =0;
	//console.log($(tbl_body).html());
	$(ts).closest("tr").remove();
	$(tbl_body).find('tr').each(function(i,tr){
		var t ={};
		$(tr).find('td').each(function(i,td){
			var k = $(td).data().keyName;
			if(k){
				//console.log(k);
				t[k] = $(td).text();
				rs[x] = t;
			}
		});
		x++;
	});
	rs = JSON.stringify({term:rs});
	$(json_data).val(rs);
	return false;
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

	$('table.nav-able').keydown(function(e){
		var key = e.keyCode || e.which;
		if (key == 13) {
			// close model form
			//alert('entered');
			$('#article_code').val(currCell.html());$('.modal.in').modal('hide');getArtInfo(currCell.html(),true);return false;
		}
		currCell = navigateTableCells(e, currCell)
	});

	$("input#search_filter").keyup(function(e){
		var value = $(this).val().toLowerCase();
		$("#tblContentBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		//culculate values
		cals_reportItemsTotal();
	});
	
	
	$(".json-form-el-list .json-form-add input").keydown(function(e){
		var key = e.keyCode || e.which;
		if(key==13){
			var parent_div = $(this).closest(".json-form-add");
			var txt_filled=true;
			var js_input = $(parent_div).find('input').each(function(i, el){
				if($(el).val()){
					var js_button = $(parent_div).find('button');
					//var json_box = $(this).parent().parent().hide(); //working
					$(js_button).trigger('click');
				}
				
			});
			
			return false;
		}
	});
	$(".json-form-el-list .json-form-add button").click(function(e){
		e.preventDefault();
		//console.log($(this).text());
		//var json_box = $(this).closest(".json-box");
		var frm_json = $(this).closest(".json-form-el-list");
		//var frm_json = $(json_box).find(".json-form-el-list");
		var frm_btns = $(this).closest(".json-form-add");
		var inputs = $(frm_btns).find('.data-fields input');
		var tbl_body = $(frm_json).find('table tbody');
		var first_element = null;
		var html='';
		var d = [];
		var false_val=false;
		html += '<tr>';
		$(inputs).each(function (i, el){
			var key = $(el).data().keyName;
			var datatype = $(el).data().datatype;
			if(!first_element){
				first_element = el;
			}
			
			if(!$(el).val()){false_val=true;}
			d[key] = $(el).val();
			if(datatype=='date'){
				var dt= new Date($(el).val());
				var strDay=dt.getDate();
				if(strDay<10){
					strDay = '0'+strDay;
				}
				var strMonth=dt.getMonth()+1;
				if(strMonth<10){
					strMonth = '0'+strMonth;
				}
				var strDate=dt.getFullYear()+'/'+strMonth+'/'+strDay;
				
				html += '<td data-datatype="'+datatype+'" data-key-name="' + key + '">' + strDate + '</td>';
			}else{
				html += '<td data-datatype="'+datatype+'" data-key-name="' + key + '">' + $(el).val() + '</td>';
			}
			$(el).val('');
		});
		if(!false_val){
			html += '<td class="delete"><a onclick="removeJSONRow(this);return false;"> X </a></td>';
			html += '</tr>';
			//console.log(html);
			$(tbl_body).append(html);
			//d = JSON.stringify(d);
			if(first_element){
				$(first_element).focus();
			}
			updateJSONTable(this);
		}
		
	});
			
		
	}); //document.ready()
	
	
	