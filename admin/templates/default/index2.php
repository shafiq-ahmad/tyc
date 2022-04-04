<?php
defined('_MEXEC') or die ('Restricted Access');

?>
	
	
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{page_title}</title>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<meta name="description" content="Standard Online Jobs is online data entry jobs , ads pasting jobs , freelancer jobs , seo services , online web surfing jobs , seo jobs and online advertising jobs providers. we have a wide variety of services for our clients and advertisers. "/> 
<meta name="keywords" content="online data entry jobs , ads pasting jobs , freelancer jobs , seo services , online web surfing jobs , seo jobs , online advertising jobs providers, data entry jobs in usa , data entry jobs in pakistan , data entry jobs in uk , data entry jobs in india , data entry jobs in canada , online work at home jobs , work at home , work from home , work at home jobs india , work at home jobs uk , work at home jobs pakistan , work at home jobs canada, web surfing jobs, seo services , link building jobs" /> 
<link href="templates/system/css/global.css" rel="stylesheet" type="text/css" />
{page_head}

<!--[if lte IE 6]>
	<script type="text/javascript" src="js/ie6PngFix.js" ></script>
<![endif]-->  
<script type="text/javascript" src="templates/system/js/accordian.pack.js"></script>
    <script src="templates/system/js/jquery.js" type="text/javascript"></script>
	<script src="templates/system/js/settings.js" type="text/javascript"></script>
	<SCRIPT type="text/javascript">
    pic1 = new Image(16, 16); 
    pic1.src = "loader.gif";
    
    $(document).ready(function(){
    
    $("#username").change(function() { 
    
    var usr = $("#username").val();
    
    if(usr.length >= 0)
    {
    $("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');
    
        $.ajax({  
        type: "POST",  
        url: "check.php",  
        data: "username="+ usr,  
        success: function(msg){  
       
       $("#status").ajaxComplete(function(event, request, settings){ 
    
        if(msg == 'OK')
        { 
            $("#username").removeClass('object_error'); // if necessary
            $("#username").addClass("object_ok");
            $(this).html('&nbsp; <font color="red"> Referal ID Not Found</font>  ');
        }  
        else  
        {  
            $("#username").removeClass('object_ok'); // if necessary
            $("#username").addClass("object_error");
            $(this).html(msg);
        }  
       
       });
    
     } 
       
      }); 
    
    }
    else
        {
        $("#status").html('<font color="red">The username should have at least <strong>0</strong> characters.</font>');
        $("#username").removeClass('object_ok'); // if necessary
        $("#username").addClass("object_error");
        }
    
    });
    
    });
    
    //-->
    </SCRIPT>
</head>
<body onload="new Accordian('basic-accordian',5,'header_highlight');"> 
<div id="outerWrap"><!--Start Outerwrap-->
	<div id="wrap"><!--Start wrap-->
<div id="wrap"><!--Start Wrap-->
	<div id="navPnlBg"><div id="navPnlRgt"><div id="navPnlCont">
    	<div id="access" role="navigation">
        	<div class="skip-link hide">
                <a href="#content" title="Skip to content">Skip to content</a>
            </div>
            <div class="menu">
				{menu}
            </div> 
        </div>
        <div id="languageSelector">
			{language}
        </div>
    </div></div></div>
	{slider}
    <div id="bodyArea"><!--Start body-->
    <div id="container">
        <div id="sidebar"><!--Start Sidebar-->
        	<div class="sideBox">				
				<div id="login" class="sideBox" >
				<dl class="sideBoxTop"><dd class="sideBoxCont">
						{login}
					</dd></dl>
				</div>
			</div>
			<div class="sideBox">
				{payments}
			</div>
            
            <div class="sideBox">
				{news}
			</div>
        </div><!--End Sidebar-->  
	<div id="content">
		<div id="content"><!--Start Content-->
			{message}
			{component}
		</div><!--End Content-->  
	</div>
    </div>
    </div><!--End body-->
    </div><!--End wrap-->
<div id="footer"><!--Start Footer-->
    	<div id="ftrCont">
			{footer}
        </div>
    </div><!--End Footer-->
	</div>
	</div><!--End Outerwrap-->
</body>
</html>	
	