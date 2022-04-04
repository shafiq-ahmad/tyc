<?php
defined('_MEXEC') or die ('Restricted Access');


?><div class="newsletter_block">
<h5><?php echo Localize::_('newsletters');?></h5>
<form id="subscribe" method="POST" action="index.php?com=alert_subscribers&view=subscribe">
<input type="hidden" name="action" value="add" />
<div class="form-group">
<input class="form-control custom-control title" name="title" placeholder="<?php echo Localize::_('full_name_');?>"> 
</div>
<div class="form-group">
<input class="form-control custom-control email" name="e_mail" placeholder="<?php echo Localize::_('email');?>">
<input id="btn_subscribe" class="btn btn-warning btn-block custom-btn custom-btn-subs submit" type="submit" value="<?php echo Localize::_('subscribe');?>">
</div>
</form> 
</div>

<script>

$("#btn_subscribe").click(function(e){
	e.preventDefault();
	var b = $('#subscribe .submit');
	var title = $('#subscribe .title').val();
	var email = $('#subscribe .email').val();
	var msg = $('#messages');
	var cl_btn = $(this).closest('td').find(".btn-retract");

	if(!email || !title){
		return false;
	}
	
	$.ajax({
		url:'index.php?com=alert_subscribers&view=subscribe',
		data:{title:title, e_mail:email,action:'add'},
		type:'POST',
		success: function(data){
			console.log(data);
			$(msg).show();
			$(msg).css('opacity',1);
			if(data.error){
				$(msg).html('<div class="alert alert-danger">' + data.error.msg + '</div>').stop().fadeOut(8000);
			}else if(data.data && data.data.updated){
				//console.log(data);
				$(msg).html('<div class="alert alert-success">You are subscribed</div>').stop().fadeOut(8000);
				$(cl_btn).attr("disabled",false);
				$(b).attr("disabled", true);
				$('#subscribe .title').val('');
				$('#subscribe .email').val('');
			}else{
				$(msg).html('<div class="alert alert-warning">You are not subscribed</div>').stop().fadeOut(8000);
			}
		}
		});




});

</script>