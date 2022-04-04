<?php
defined('_MEXEC') or die ('Restricted Access');
$messages=$this->getMessages();
$com = Application::$options->com;
$view = Application::$options->view;
$user = User::isLogin();
if($user){
	$user_name = $user['full_name'];
}

$db=Core::getDBO();
//echo md5('abc123');exit;
//base_convert(number,frombase,tobase); // example: base2 to base10
//print_r($this->c);exit;
?><!DOCTYPE html>
<html lang="<?php echo Localize::getLang();?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><?php
echo $this->getHead();
?><title><?php echo $this->getTitle(); ?></title>
<script type="application/ld+json">{"@context":"http:\/\/schema.org","publisher":{"@type":"Organization","name":"<?php echo Localize::_('business_name');?>"},"@type":"WebPage","mainEntityOfPage":"http:\/\/<?php echo Localize::_('business_url');?>\/","headline":"Home","datePublished":"2019-05-06T06:13:58+00:00","dateModified":"2018-10-06T12:30:25+00:00","author":{"@type":"Person","name":"Shafique Ahmad"}}</script>
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/assets/themes/default/default.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/assets/css/styles.css">
<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/assets/css/responsive.css">
<?php /*?><link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /><?php */?>

<link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/assets/css/nivo-slider.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="media/system/js/webapplics.js"></script>
<!-- jQuery 3 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery/dist/jquery.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/assets/js/jquery_2.2.4_jquery.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/assets/js/endless_scroll_min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/assets/js/jquery.nivo.slider.js"></script>
<?php /*?>
<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/assets/css/buttons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
<?php */ ?>
<style>
	#messages{position:absolute;top:100px;left:50%;margin-left:-150px;z-index:9999;}
	#messages div span{min-height:100px;width:300px;}
</style>
<script src="templates/<?php echo $this->getTemplate();?>/assets/js/scripts.js"></script>
<script>
/*$(function(){
$('span.row_view').click(function(){
	$('.grid_view_display').hide();
	$('.row_view_display').show(300);
	});
$('span.grid_view').click(function(){
	$('.row_view_display').hide();
	$('.grid_view_display').show(300);
	});
	});*/
</script>
</head>

<body>
<div class="top_block">
<div class="top_content">
<?php
echo $this->showModule('logo'); 
echo $this->showModule('address');
?><div class="help_languages">
<ul>
<!--<li><a href="compare.php" class="compre_vehicle_link">compare<span class="dynamic_comp_ref"></span></a></li>-->
<li>
<a href="index.php?com=vehicles&view=compare" class="compre_vehicle_link" rel="nofollow"><?php echo Localize::_('menu_compare');?> &nbsp;
<span class="dynamic_comp_ref"></span>
<span>
<i class="fas fa-tachometer-alt"></i>
</span></a></li>
<?php if($user){?>
<li><a href="#"><?php echo $user_name; ?></a>
<?php /*?><ul>
<li><a href="user_profile.php">My Profile</a></li>
<li><a href="user_inventory.php">My Inventory</a></li>
<li><a href="upload_vehicle.php">Upload Vehicle</a></li>
<li><a href="signout.php">Sign Out</a></li>
</ul><?php */?>
</li>
<?php } ?><?php ?>
<li><a href="javascrip:void(0);"><?php echo Localize::_('menu_help');?></a></li>
<li>
<a href="index.php?setLang=ar" class="set-lang"><img class="uae" src="media/images/uae.png" width="24" height="24"></a>
<a href="index.php?setLang=en" class="set-lang"><img class="usa" src="media/images/usa.png" width="24" height="24"></a>
<a href="index.php?setLang=tr" class="set-lang"><img class="usa" src="media/images/turkey.png" width="24" height="24"></a>
</li>
</ul>
</div>
</div>
</div>
<div class="main_menu_wrapper"><?php
	echo $this->showModule('menu');
?></div>


