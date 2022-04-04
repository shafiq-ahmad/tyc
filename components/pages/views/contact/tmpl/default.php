<?php
defined('_MEXEC') or die ('Restricted Access');
?>

<div class="site_contents">
<div class="signup_wrapper" style="width:100%;">
<form id="signup_form">
<legend>
Send us inquiry/message
</legend>
<div class="form-group">
<input type="text" class="form-control" name="full_name" placeholder="Full Name">
</div>
<div class="form-group">
<input type="email" class="form-control" name="email" placeholder="email@domain.com">
</div>
<div class="form-group">
<input type="phone" class="form-control" name="phone" placeholder="Phone">
</div>
<div class="form-group custom_state_control">
<select class="form-control">
<option value="#">--Select Your State--</option>
<option value="#">Abu Dhabi</option>
<option value="#">Dubai</option>
<option value="#">Sharjah</option>
</select>
</div>

<div class="form-group">
<textarea class="form-control" name="message" placeholder="Message" rows="6"></textarea>
</div>
<div class="form-group">
<input type="submit" value="Send Message" class="btn btn-md btn-primary float-right" name="send_message">
</div>
</form>
</div>
</div>
