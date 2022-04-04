<?php

$message=$this->getMessage();
$com = Application::$options->com;
$view = Application::$options->view;

//echo md5('abc123');exit;
//base_convert(number,frombase,tobase); // example: base2 to base10
//print_r($this->c);exit;
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php /* ?><script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script><?php */?>
	<script type="text/javascript">
		var user_opt = '';
		var br_dt_opt = '';
		<?php 
			if($this->u['options']){
				echo "\n";
				echo 'user_opt = ' . $this->u['options'] . ';'; 
			}
		?>
		<?php 
			if($this->c['local_data_opt']){
				echo "\n";
				echo 'br_dt_opt = ' . $this->c['local_data_opt'] . ';'; 
			}
		?>
		var auto_multiQty=true;
		var use_local_storage=false;
		if(br_dt_opt[0]){
			br_dt_opt = br_dt_opt[0];
		}
		console.log(br_dt_opt);
		if(user_opt[0]){
			user_opt = user_opt[0];
		}
		if(user_opt.auto_multiQty){
			auto_multiQty = user_opt.auto_multiQty;
		}
		if(br_dt_opt.use_local_storage){
			use_local_storage = br_dt_opt.use_local_storage;
		}
	</script>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/style-lte.css" media="screen" />
	<?php /* ?><link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" /><?php*/ ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />
  
<!-- jQuery 3 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/skins/skin-blue-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<title><?php echo $this->getTitle(); ?></title>
</head>

<body class="hold-transition skin-blue-light sidebar-collapse sidebar-mini">
<div class="wrapper">



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
	  
			<div id="center">
				<div id="componant"><?php
					echo $this->_com;
				?></div>
			</div>
	  
	  
    </section>
    <!-- /.content -->
  </div>
  
	<footer class="main-footer">
	<div class="pull-right hidden-xs"><b>Version</b> 1.0</div>
	<strong>Copyright &copy; 2014-2016 <a href="http://webapplics.com">Webapplics Studio</a>.</strong> All rights reserved.
	</footer>


  
  
  
  
</body>

</html>