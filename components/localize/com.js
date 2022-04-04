
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

	$(function () {
		//Initialize Select2 Elements
		$('select').select2()
	})
$(document).ready(function(){

	$("input.number").keypress(function(e){
		e.stopPropagation();
		if(!inputNumber(e)){return false;}
	});

	
	$("input#search_filter").keyup(function(e){
		var value = $(this).val().toLowerCase();
		$("#tblContentBody tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		//culculate values
		cals_reportItemsTotal();
	});
	
	
	
	
	
	
	
	
});