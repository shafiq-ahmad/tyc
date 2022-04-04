
function inputNumber(e){
	if(e.which >=58){
		return false;
	}
	if(e.which <=45){
		return false;
	}
	if(e.which == 47){
		return false;
	}
	return true;
}

	function navigateTableCells(e, currCell) {
	//console.log(e.which);
	var c = "";
	if (e.which == 39) {
	// Right Arrow
	//c = currCell.next();
	} else if (e.which == 37) {
	// Left Arrow
	//c = currCell.prev();
	} else if (e.which == 38) {
	// Up Arrow
	c = currCell.closest('tr').prev().find('td:eq(' + currCell.index() + ')');
	} else if (e.which == 40) {
	// Down Arrow
	c = currCell.closest('tr').next().find('td:eq(' + currCell.index() + ')');
	} else if ((e.which == 13 || e.which == 32 || e.which == 113)) {
	// Enter, Spacebar, F2 - edit cell
	e.preventDefault();
	} else if ((e.which == 9 && !e.shiftKey)) {
	// Tab
	e.preventDefault();
	c = currCell.next();
	} else if ((e.which == 9 && e.shiftKey)) {
	// Shift + Tab
	e.preventDefault();
	c = currCell.prev();
	}
	//console.log(currCell.html());

	// If we didn't hit a boundary, update the current cell
	if (c.length > 0) {
		currCell = c;
		currCell.focus();
	}
	return currCell;
	}

function getOfflineArts() {
	var arts = localStorage.getItem('articles');
	//if(arts['today'] == today_date then return else return false;
	var d = new Date();
	var d2 = new Date(arts['today']);
	var dt = d.getFullYear() + '-' +d.getMonth() + '-' + d.getDay();
	var dt2 = d2.getFullYear() + '-' +d2.getMonth() + '-' + d2.getDay();
	console.log(dt);
	console.log(arts);
	console.log(dt2);
	return arts;
}

function removeOfflineArts(clearAll=null) {
	if(!clearAll){
		localStorage.removeItem('articles');
	}else{
		localStorage.clear();		//clear all items
	}
}

function setOfflineArts(txt) {
	var arr = [];
	var d = new Date();
	var dt = d.getFullYear() + '-' +d.getMonth() + '-' + d.getDay();
	arr['today'] = dt;
	arr['data'] =  txt;
	console.log(arr);
	localStorage.setItem('articles', arr);
}

function modalArtList(data,txt,return_id) {
	var html = '<tr class="">';
	var html = html + '<th class="article_code screen">Code#</th>';
	var html = html + '<th class="title screen">Title</th>';
	var html = html + '<th class="price screen">Price</th>';
	var html = html + '<th class="stock screen">Stock</th>';
	//var html = html + '<th class="category screen">Category</th>';
	var html = html + '</tr>';
	$("#myModal .modal-body").html(html);
	$.each(data, function(i, v) {
		var exp = new RegExp(txt,'i');
		var n = v.title.search(exp);
		if (n != -1) {
			html = '<tr onclick="$(' + "'#article_code'" + ').val(' + v.article_code + ');$(\'.modal.in\').modal(\'hide\');getArtInfo(' + v.article_code + ',true);return false;">';
			html = html + '<td class="article_code screen" tabindex="' + i + '">'+v.article_code+ '</td>';
			html = html + '<td class="title">'+v.title+'</td>';
			html = html + '<td class="price">'+v.sale_price+'</td>';
			html = html + '<td class="qty">'+v.qty+'</td>';
			//var category = '';
			//if(v.category_title){category += v.category_title}
			//if(v.sub_category_title){category += ' - ' + v.sub_category_title}
			//html = html + '<td class="category">'+category+'</td>';
			html = html + '</tr">';
			$("#myModal .modal-body").append(html);
		}
	});
	currCell = $('.nav-able td').first();
	$('#myModal').on('shown.bs.modal', function (){
		var modal = $(this);
		var ret = $(modal).find('#return-value').val('#'+return_id);
		$(currCell).focus().select();
	});
	$('#myModal').on('hidden.bs.modal', function (){
		var modal = $(this);
		//modal.my_var = 'shafique';
		var ret = $(modal).find('#return-value').val();
		$(ret).val(currCell.html());
		$(ret).focus().select();
		//console.log(currCell.html());
	});
	$("#myModal").modal();
	
}

function artSearch(txt_data,return_id) {
	txt_data = txt_data.substr(1);
	//setOfflineArts(braArts);
	//console.log(getOfflineArts());
	var r = return_id || 'article_code';
	//braArts='';
	if(!braArts){
		//console.log('empty');
		$.get('?com=articles&view=branch_articles&task=json', {txt: txt_data}, function(result){
			//var obj = JSON.parse(result);
			//console.log(result);
			braArts = result;
			modalArtList(braArts,txt_data,r);
			return true;
		});
	}else{
		modalArtList(braArts,txt_data,r);
	}
	return true;
	//console.log(braArts);

}


