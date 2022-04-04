
$(document).ready(function(){

	$("input.number").keypress(function(e){
		e.stopPropagation();
		if(!inputNumber(e)){return false;}
	});


	
	
});