<?php
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
