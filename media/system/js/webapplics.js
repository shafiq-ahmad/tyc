var online = window.navigator.onLine;
if (!online){
    //console.log("Application is offline...");
}

function publishItem(id, published, action, msg){
	msg = msg || 'Please confirm change of status';
	published = published || 0;
	var r = confirm(msg);
	if (r != true){
		return false;
	}
	var submit_form = document.createElement('form');
	submit_form.method = 'POST';
	submit_form.action = action;
	submit_form.display =  'hidden';

	var input_action = document.createElement('input');
	input_action.name = 'action';
	input_action.type = 'HIDDEN';
	input_action.value = 'publish';
	submit_form.appendChild(input_action);

	var input_id = document.createElement('input');
	input_id.name = 'id';
	input_id.type = 'HIDDEN';
	input_id.value = id;
	submit_form.appendChild(input_id);

	var input_published = document.createElement('input');
	input_published.name = 'published';
	input_published.type = 'HIDDEN';
	input_published.value = published;
	submit_form.appendChild(input_published);

	// submit btn
	var btnSubmit = document.createElement('input');
	btnSubmit.type = 'SUBMIT';
	btnSubmit.value = 'Submit';
	submit_form.appendChild(btnSubmit);

	// Add to form and submit
	document.body.appendChild(submit_form).submit();
	return false;
}

function removeItem(id, action, msg){
	msg = msg || "Please confirm deletion! this action might not be reverse.";
	var r = confirm(msg);
	if (r != true){
		return false;
	}
	var submit_form = document.createElement('form');
	submit_form.method = 'POST';
	submit_form.action = action;
	submit_form.display =  'hidden';

	var input_action = document.createElement('input');
	input_action.name = 'action';
	input_action.type = 'HIDDEN';
	input_action.value = 'remove';
	submit_form.appendChild(input_action);

	var input_id = document.createElement('input');
	input_id.name = 'id';
	input_id.type = 'HIDDEN';
	input_id.value = id;
	submit_form.appendChild(input_id);

	// submit btn
	var btnSubmit = document.createElement('input');
	btnSubmit.type = 'SUBMIT';
	btnSubmit.value = 'Submit';
	submit_form.appendChild(btnSubmit);

	// Add to form and submit
	document.body.appendChild(submit_form).submit();
	return false;
}

function sumFields(source_class, res_class){
	source_class = source_class || 'sum';
	res_class = res_class || 'result';
	var total = 0;
	var inputs = document.getElementsByClassName(source_class);
	//document.getElementById("myP").addEventListener("click", myFunction, true)
	
	for (i = 0; i < inputs.length; i++) {
		if(!isNaN(inputs[i].value)){
			total += eval(inputs[i].value);
		}else{
			total=0;
			return 0;
		}
	}
	return total;
	//document.getElementsByClassName(res_class).value=total;
}

function multiplyFields(source_class, res_class){
	source_class = source_class || 'multiply';
	res_class = res_class || 'result';
	var total = 0;
	var inputs = document.getElementsByClassName(source_class);
	//document.getElementById("myP").addEventListener("click", myFunction, true)
	
	for (i = 0; i < inputs.length; i++) {
		if(!isNaN(inputs[i].value)){
			total *= eval(inputs[i].value);
		}else{
			total=0;
			return false;
		}
	}
	return total;
	//document.getElementsByClassName(res_class).value=total;
}


function showMsg(msg,target,ms){
	//$("messages").show();
	target = target || 'messages';
	ms = ms || 10000;
	var id_name = '#'+target;
	$(id_name).html(msg);
	var id_name_inn = id_name + ' div'
	$(id_name_inn).fadeOut( ms, function() {
		//$("#messages div").hide();
		$(id_name).html('');
	});
}

