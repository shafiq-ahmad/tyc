<?php


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
			<div id="center">
				<div id="componant"><?php
					echo $this->_com;
				?></div>
			</div>
			<div class="clear"></div>
			<div id="footer">
				<p>Powered by: webapplics.com</p>
			</div>
			</div>
	</body>
</html>