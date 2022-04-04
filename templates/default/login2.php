<?php
//$pa =  $user->pageAccess(12);
//print_r ($_SESSION);exit;
//echo time();exit;
$messages=$this->getMessages();
$bArtsJSON = '';
$com = Application::$options->com;
$view = Application::$options->view;

if($com == 'sales' || $com == 'purchases'){
	if(!class_exists('View')){import('core.application.component.view');}
	$v_obj = new View();
	$model_art = $v_obj->getModel('articles.branch_articles');
	$bArts = $model_art->getBranchArticles();
	//echo count($bArts) . '\n';
	$bArtsJSON = json_encode($bArts);
}
//echo md5('abc123');exit;
//base_convert(number,frombase,tobase); // example: base2 to base10
//print_r($_POST);exit;
?><!DOCTYPE html>




<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<script src="media/system/js/jquery-3.3.1.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
	<?php /* ?><script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script><?php */?>
	<?php /* ?><link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" /><?php*/ ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" /><script src="components/<?php echo $com; ?>/com.js"></script>
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/skins/skin-blue.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Google Font 
  <link rel="stylesheet" href="./AdminLTE 2 _ Log in_files/css">-->
<style>
.login-page{}
</style>
	<title><?php echo $this->getTitle(); ?></title>
</head>

<body class="hold-transition login-page" style="margin-top:20px;">
<section>
<div id="messages"><?php 
foreach($messages as $m){
	echo '<div>' . $m . '</div>';
}
?></div>
<div class="login-box">
<div class="login-logo"><a href="#"><b>Login Here</b></a></div><?php
	echo $this->_com;
?></div>
</section>
</body>
<!-- jQuery 3 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- iCheck -->
<script src="templates/<?php echo $this->getTemplate();?>/plugins/iCheck/icheck.min.js"></script>
<script src="components/<?php echo $com; ?>/com.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

</html>