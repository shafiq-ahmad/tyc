<?php
//$pa =  $user->pageAccess(12);
//print_r ($_SESSION);exit;
//echo time();exit;
$message=$this->getMessage();
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="media/system/js/jquery-3.3.1.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
<script src="media/system/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>
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
	<link rel="stylesheet" href="media/system/css/bootstrap-3.3.7-dist/css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" /><script src="components/<?php echo $com; ?>/com.js"></script>
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />

	<title>POS by webapplics.com</title>
</head>
	<body oncontextmenu="">
	<?php /*?><body onmousedown="WhichButton(event);return false;">
	<body onmousedown="alert(event.button);return false;"><?php */?>
		<div id="main" class="container container-fluid">
			<?php if($this->u){ ?><div id="header">
				<div id="logo-section">
					<div id="logo"></div>
					<div id="company">
						<div class="title"><?php echo $this->branch_title; ?></div>
						<div class="address"><?php echo $this->branch_address; ?></div><?php
						if($com=='sales' && ($view == 'pos' || $view == 'distributor')){ 
						?><div class="doc-title print">Sales invoice</div><?php }
					?></div>
					<div class="clear"></div>
				</div><div class="clear"></div>
				<div id="user">
					<p class="left">
					<?php echo date('d / m /Y       h:i:sa'); ?>
					</p><p class="right"><a href="?com=user&view=profile" tabindex="-1"><?php echo $this->full_name ?></a>
					&nbsp;&nbsp;|&nbsp;&nbsp;<a class="screen logout" href="?com=user&logout=1" tabindex="-1">(Logout)</a>
					</p>
					</div><div class="clear"></div>
			</div>
			<div id="top-menu" class="list-group">
	<div class="navbar screen">
	<div class="dropdown">
	<button class="dropbtn">Primary<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=users" title="Users" class="list-group-item" tabindex="-1">Users</a><?php /* ?>
			<a href="?com=users&view=user&task=new" title="New User" class="list-group-item" tabindex="-1">New User</a><hr/><?php */ ?>
		</div>
	</div>
	<div class="dropdown">
	<button class="dropbtn">Utilities<i class="fa fa-caret-down"></i></button>
		<div class="dropdown-content">
			<a href="?com=inventories&view=inventories" title="Store Audit" class="list-group-item" tabindex="-1">Store Audits</a>
			<a href="?com=inventories&view=inventory" title="Store Audit" class="list-group-item" tabindex="-1">New Store Audit</a>
		</div>
	</div>
	</div>
			
<div class="clear"></div>
			</div><div class="clear"></div><?php } ?>
			<div id="message"><?php
				if($message){
					//echo '<span class="message ' . $message['class'] . '">' . $message['text'] . '</span>';
				}
			?></div>
			<div id="center">
				<div id="componant"><?php
					echo $this->_com;
				?></div>
			</div>
			<?php  if($this->u){ ?>
            <div id="left">
				<?php /* ?><div class="com-menu list-group"><?php
					//echo $this->getComMenu($this->com);
				?></div>
				<div class="left-menu-item list-group">
					<a href="?com=sales&view=pos" title="Point of Sale" class="list-group-item primary" tabindex="-1">Point of Sale</a>
				</div><?php */?>
                <div id="left-article-search" class="">
                    <h4>Search Item</h4>
                    <form class="search"  action="?com=articles&view=article&tmpl=com&task=json" method="post">
                        <input id="left-article_code" name="article_code" placeholder="Search..." class="inputbox form-control input-sm" value="" tabindex="-1" />
                        <?php /* ?><input type="button" class="btn btn-success" value="Go" /><?php */ ?>
                    </form>
                    <div class="results">
                        <div class="title"><b>Title: </b><div class="value"></div></div>
                        <div class="article_code"><b>ID: </b><span class="value"></span></div>
                        <div class="qty"><b>Stock: </b><span class="value"></span></div>
                        <div class="scheme"><b>Scheme: </b><span class="value"></span></div>
                        <div class="discount"><b>Discount: </b><span class="value"></span></div>
                        <div class="sale_price"><b>Price: </b><span class="value"></span></div>
                        
                    </div>
                </div>
			</div>
			<?php } ?>
			<div class="clear"></div>
			<div id="footer">
				<p>Powered by: webapplics.com</p>
			</div>
	</body>
    <script type="text/javascript">
    
function getArticleInfo(txt){
	if(txt==''){return false;}
		txt = txt.toString();
		//console.log(txt);
		$('#left-article-search .results .article_code .value').text('');
		$('#left-article-search .results .title .value').text('');
		$('#left-article-search .qty .value').text('');
		$('#left-article-search .scheme .value').text('');
		$('#left-article-search .discount .value').text('');
        $('#left-article-search .sale_price .value').text('');
        $.post("?com=articles&view=article&task=json&tmpl=com", {article_code: txt}, function(result,status,xhr, dataType){
            //var r = JSON.stringify(result)
            //console.log(result);
            //console.log(status);
            //var ct = xhr.getResponseHeader("content-type") || "";
            //console.log(ct);
            //console.log(dataType);
            //console.log(typeof(result));
            //try{
            //var obj = JSON.parse(result);
            //}catch(e){}
            var obj = result;
            //console.log(obj);
            if(!obj){
            $('#left-article-search .results .title .value').text('No Item found');
                return false;
            }

            $('#left-article-search .results .article_code .value').text(obj.article_code);
            $('#left-article-search .results .title .value').text(obj.title);
            $('#left-article-search .qty .value').text(obj.qty);
            $('#left-article-search .scheme .value').text(obj.scheme);
            $('#left-article-search .discount .value').text(obj.discount);
            $('#left-article-search .sale_price .value').text(obj.sale_price);

            return false;
	},'json').done(function() { /*console.log('Request done!');*/ })
        .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });
	//},dataType);
	
	
}

	$("input#left-article_code").keypress(function(e){
		e.stopPropagation();
		//alert(e.which);
		txt_article = $("input#left-article_code").val();
		if (e.which==13){
			//return false;
			txt_article = txt_article.toString();
			getArticleInfo(txt_article);
            $(this).val('');
            $(this).focus();
			return false;
		} //end keyCode
	});
    $(window).keydown(function(e){
        if(e.ctrlKey){
            e.preventDefault();
            var key = e.keyCode || e.which;
            //console.clear();
            //console.log(key);
            //console.log(e.shiftKey);
            //console.log(e.ctrlKey);
            //console.log(e.altKey);
            var vFind = '';

            if (e.shiftKey && key==73){
                vFind = $("input#left-article_code");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }else if (key==73){
                vFind = $("input#article_code");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
            if (key==70){
                vFind = $("input#search_filter");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        }else{return;}
    });

</script>
</html>