<?php
defined('_MEXEC') or die ('Restricted Access');

$user = User::isLogin();
if($user){
	$user_name = $user['full_name'];



?>
<div class="left_sidebar">
<h4><?php echo Localize::_('menu_general_operations');?></h4>
<div class="admin_menus">
<ul>
<li><a href="<?php echo Route::_('index.php?com=users&view=profile');?>"><?php echo Localize::_('menu_my_profile');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=shipping&view=user_subscriptions');?>"><?php echo Localize::_('menu_my_subscriptions');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=vehicles&view=user_vehicles');?>"><?php echo Localize::_('menu_vehicle_inventory');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=vehicles&view=vehicle&task=edit');?>"><?php echo Localize::_('menu_upload_vehicle');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=sales&view=user_orders');?>"><?php echo Localize::_('menu_my_orders');?></a></li>
<li><a href="javascript:void(0);"><?php echo Localize::_('menu_my_invoices');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=users&logout=1');?>"><?php echo Localize::_('menu_sign_out');?></a></li>
</ul>
</div><?php
if($user && $user['group_id']==1){
?><h4><?php echo Localize::_('management');?></h4>
<div class="admin_menus">
<ul>
<li><a href="<?php echo Route::_('index.php?com=lists');?>"><?php echo Localize::_('menu_administrator');?></a></li>
</ul>
</div><?php
}
?></div><?php
}
?>