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

?>

	<div id="main-wrapper">
		<div id="content"><br />
			<h2><span>Change Password</span></h2>
			<div id="message">
				<?php
					global $message;
					echo $message;
				?>
			</div>
			<div id="content">
				<div id="frm-ch-password">
					<form id="change-password" action="index.php?option=user&view=change_password" method="post">
						<p><label>Old Password: </label><input id="old-pass" class="inputbox" type="password" name="old_password" value="" size="15" /></p>
						<p><label>New Password: </label><input id="new-pass" class="inputbox" type="password" name="new_password" value="" size="15" /></p>
						<p><label>Confirm Password: </label><input id="confirm-pass" class="inputbox" type="password" name="confirm_password" value="" size="15" /></p>
						<p><input type="submit" name="change_password" value="Change" /></p>
					</form>
				</div>
			</div>
        </div>

	</div>
