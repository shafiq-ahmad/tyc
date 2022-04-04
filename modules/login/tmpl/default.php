<?php
defined('_MEXEC') or die ('Restricted Access');
global $session;
global $login;

?>
<?php
if(!$login){
?>
<dl class="sideBoxTop">
<dd class="sideBoxCont">
	<h3 class="loginIcon">Login Now</h3>
	<form action="index.php?option=user&view=user" class="loginFrm" method="post">
		<p><label>User name</label><input id="username" type="text" class="typeInput" name="username" /></p>
		<p><label>Password</label><input id="password" type="password" class="typeInput" name="password" /></p>
		<p><a href="index.php?option=user&view=user" class="forgetTxt">Forget password?</a></p>
		<p><input type="submit" class="subBotton" value="Login" name="login" /></p>
	</form>
</dd>
</dl>

<?php
	}else{
?>
	<h3>Member Area</h3> 
	<p><strong>Welcome <?php echo $session->full_name; ?></strong> </p>
	<ul class="menu widgetCont">
		<li><a href="index.php?option=onlinejobs&view=registered" >Client Area</a>
		<li><a href="index.php?option=onlinejobs&view=registered" >Current Assignments</a></li>
		<li><a href="index.php?option=onlinejobs&view=registered&task=submit" >Submit Assignment</a></li>
		<li><a href="index.php?option=onlinejobs&view=registered&task=withdraw" >Withdraw Funds</a></li>
		<li><a href="index.php?option=onlinejobs&view=registered&task=history" >History</a></li>
		<li><a href="index.php?option=onlinejobs&view=registered&task=yourLink" >Your Referral Link</a></li>
		<li><a href="index.php?option=user&view=change_password" >Change Password</a></li>
		</li>
		<li><a href="index.php?option=user&task=logout">Log out</a></li>
	</ul>
<?php } ?>