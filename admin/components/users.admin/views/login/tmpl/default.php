<?php
defined('_MEXEC') or die ('Restricted Access');

?><div id="login">
	<div class="login-head">
		<h2>Please Login...</h2>
	</div>
	<div class="login-body">
		<fieldset>
			<legend>Form</legend>
			<form action="?com=users&view=login" method="post">
				<div class="row well-sm"><div class="col-sm-3"><label class="control-label" for="login_name">Login Name:</label> </div><div class="col-sm-5"><input name="login_name" class="inputbox form-control" value="" /></div></div>
				<div class="row well-sm"><div class="col-sm-3"><label class="control-label" for="password">Password:</label> </div><div class="col-sm-5"><input name="password" type="password" class="inputbox form-control" value="" /></div></div>

				<ul class="form-buttons">
					<li>
						<span><input class="btn btn-default" type="reset" name="reset" value="Reset" /></span>
						<span><input type="submit" name="login" id="login" class="btn btn-success" value="Login" /></span>
					</li>
					<li></li>
				</ul>
			</form>
		</fieldset>
	</div>
</div>