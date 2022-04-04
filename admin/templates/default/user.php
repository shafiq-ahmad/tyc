<?php
//$pa =  $user->pageAccess(12);
//print_r ($_SESSION);exit;
//echo time();exit;
$message=$this->getMessage();
$u=array();
$c=array();
$bArtsJSON = '';
if($this->com != 'user' && $this->view != 'login'){
	$u=$this->user->getUser();
	$c=$this->user->getCompany();
	//$bArts = getBranchArticles();
	//$bArtsJSON = json_encode($bArts);
}
//base_convert(number,frombase,tobase); // example: base2 to base10
//echo md5('401661');exit; //generate password
//print_r($u);exit;
//print_r($_POST);exit;
$this->loadPHPFile(SITE_PATH . DS . "components" . DS . $this->com . DS . "{$this->com}.php");
if($this->view=="ajax"){
	$this->loadPHPFile(SITE_PATH . DS . "components" . DS . $this->com . DS . "models" . DS . "{$this->com}.php");
}
$this->loadPHPFile(SITE_PATH . DS . "components" . DS . $this->com . DS . "models" . DS . "{$this->view}.php");


if($this->view != "ajax"){
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery-ui/jquery-ui.min.js"></script>
<script src="css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
	<script type="text/javascript">
	function WhichButton(event) {
		console.log("You pressed button: " + event.button)
	}
    // Popup window code 
    function newPopup(url) {
        popupWindow = window.open(url, '_blank', 'height=300,width=500,left=200,top=200,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
    }
	$(function(){
		$(".date").datepicker();
		$(".date-default").datepicker().datepicker("setDate", new Date());
	});
	<?php if($bArtsJSON){echo 'var braArts = ' . $bArtsJSON . ';';} ?>
	</script>
	<link rel="stylesheet" href="css/bootstrap-3.3.7-dist/css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.min.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
	<title>POS by webapplics.com</title>
</head>
	<body oncontextmenu="return false;">
	<?php /*?><body onmousedown="WhichButton(event);return false;">
	<body onmousedown="alert(event.button);return false;"><?php */?>
		<div id="main" class="container container-fluid">
			<div id="message"><?php
				if($message){
					echo '<span class="message ' . $message['class'] . '">' . $message['text'] . '</span>';
				}
			?></div>
			<div id="center">
				<div id="componant">
			<script src="components/<?php echo $this->com; ?>/com.js"></script>
			<link rel="stylesheet" type="text/css" href="components/<?php echo $this->com; ?>/com.css" media="all" /><?php
					$this->loadPHPFile(SITE_PATH . DS . "components" . DS . $this->com . DS . "views" . DS . $this->view . DS . "{$this->task}.php");
				?></div>
			</div>
			<?php  if($u){ ?><div id="left">
				<?php /* ?><div class="com-menu list-group"><?php
					//echo $this->getComMenu($this->com);
				?></div><?php */?>
				<div class="left-menu-item list-group">
				<a href="?com=articles&view=branch_articles" title="My Items" class="list-group-item" tabindex="-1">My Items</a>
					 <a href="?com=categories" title="Categories" class="list-group-item" tabindex="-1">Categories</a>
					<a href="?com=suppliers" title="Suppliers" class="list-group-item" tabindex="-1">Suppliers</a>
					<a href="?com=purchases&view=purchase" title="Purchases" class="list-group-item" tabindex="-1">&nbsp;&nbsp;New Purchase</a>
					<a href="?com=sales&view=pos" title="Point of Sale" class="list-group-item" tabindex="-1">&nbsp;&nbsp;Point of Sale</a>
				</div>
			</div>
			<div class="clear"></div>
			<div id="footer">
				<p>Powered by: webapplics.com</p>
			</div>
			<?php } ?>
			</div>
	</body>
</html><?php
}else{
	
	$this->loadPHPFile(SITE_PATH . DS . "components" . DS . $this->com . DS . "views" . DS . $this->view . DS . "{$this->task}.php");
}