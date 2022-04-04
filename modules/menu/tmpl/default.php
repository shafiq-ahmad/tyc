<?php
defined('_MEXEC') or die ('Restricted Access');

$user = User::isLogin();
if($user){
	$user_name = $user['full_name'];
	$group_id = $user['group_id'];
	//$user_photo = $user['file'];
}

//var_dump($user);exit;
?>
<h5><?php echo Localize::_('main_navigation');?></h5>
<menu class="main_menu">
<ul>
<li><a href="<?php echo Route::_('index.php"><span class="nav_icons');?>"><i class="fas fa-home"></i></span><?php echo Localize::_('menu_home');?></a></li>
<li><a href="#"><?php echo Localize::_('menu_services');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=pages&view=faqs');?>"><?php echo Localize::_('menu_faqs');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=contactus&view=contact');?>"><?php echo Localize::_('menu_contact_us');?></a></li>
<?php if(!$user){?> 
<li><a href="<?php echo Route::_('index.php?com=users&view=login');?>" rel="nofollow"><?php echo Localize::_('menu_login_register');?></a></li>
<?php }else{ ?>
<?php /* ?><li><a href="<?php echo Route::_('index.php?com=users&view=public_profile');?>"><?php echo Localize::_('menu_public_profile');?></a></li><?php */ ?>
<li><a href="<?php echo Route::_('index.php?com=users&view=profile');?>" rel="nofollow"><?php echo $user_name ?></a></li><?php
	if($group_id==1){
	/*	?><li><a href="index.php?com=lists">Administration</a></li><?php */
	}
?><li><a href="<?php echo Route::_('index.php?com=users&logout=1');?>" rel="nofollow"><?php echo Localize::_('menu_sign_out');?></a></li><?php
} ?>
</ul>
</menu>
