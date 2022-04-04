<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

defined('_MEXEC') or die ('Restricted Access');

?><div class="login-box-body">
	<p class="login-box-msg">Sign in to start your session</p>

	<form action="?com=users&view=login" method="post">
	<div class="form-group has-feedback">
	<input name="login_name" class="form-control" placeholder="Login name" autofocus <?php
		if(isset($_COOKIE['user_name'])) {
			echo $_COOKIE['user_name'];
		}
	?> />
	<span class="glyphicon glyphicon-user form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
	<input type="password" name="password" class="form-control" placeholder="Password">
	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="row">
	<div class="col-xs-8">
		<div class="checkbox icheck">
		<label>
		<input name="remember_me" type="checkbox" <?php 
		if(isset($_COOKIE['remember_me'])) {
			echo 'checked';
		}
	?>> Remember Me
		</label>
		</div>
	</div>
	<!-- /.col -->
	<div class="col-xs-4">
	<button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
	</div>
	<!-- /.col -->
	</div>
	</form>

	
	
	<?php /*?><div class="social-auth-links text-center">
	<p>- OR -</p>
	<a href="https://adminlte.io/themes/AdminLTE/pages/examples/login.html#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
	Facebook</a>
	<a href="https://adminlte.io/themes/AdminLTE/pages/examples/login.html#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
	Google+</a>
	</div>
	<!-- /.social-auth-links --><?php */?>

	<a href="#">I forgot my password</a><br>
	<a href="#" class="text-center">Register a new membership</a>

	</div>