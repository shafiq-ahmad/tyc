<?php

$messages=$this->getMessages();
$com = Application::$options->com;
$view = Application::$options->view;
$task = Application::$options->task;
$app = Core::getApplication();

$app->secure();
$user = Core::getUser()->getUser();
if($user['group_id']!=1 && $task!='json'){die ('Not Autherise!');}
//echo $user['group_id'];exit;

//var_dump($user);

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
		<?php 
			/*if($this->u['options']){
				echo "\n";
				echo 'user_opt = ' . $this->u['options'] . ';'; 
			}*/
		?>
		var auto_multiQty=true;
		var use_local_storage=true;
		if(user_opt[0]){
			user_opt = user_opt[0];
		}
		if(user_opt.auto_multiQty){
			auto_multiQty = user_opt.auto_multiQty;
		}
	</script>
<?php/*?><script src="media/system/js/vue.js"></script><?php*/?>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.9/vue.js"></script>
<script src="media/system/js/webapplics.js"></script>
<!-- jQuery 3 -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="media/system/js/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" />
  <!-- Bootstrap 4.3 -->
  <link rel="stylesheet" href="media/system/css/common.css">
  <link rel="stylesheet" href="media/system/bootstrap4/css/bootstrap.min.css">
  <link rel="stylesheet" href="media/system/mdbootstrap/css/mdb.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="media/system/DataTables/datatables.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="templates/<?php echo $this->getTemplate();?>/dist/css/skins/skin-blue-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/general.css" media="all" />
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/style-lte.css" media="screen" />
	<?php /* ?><link rel="stylesheet" type="text/css" href="media/system/js/jquery-ui/jquery-ui.min.css" media="all" /><?php*/ ?>
	<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->getTemplate();?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="components/<?php echo $com; ?>/com.css" media="all" />
  

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<title><?php echo $this->getTitle(); ?></title>
</head>

<body class="hold-transition skin-blue-light">
<div class="wrapper">


  <header class="main-header">

    <!-- Logo -->
    <a href="?" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>W</b>AP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php //echo $this->branch_title; ?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="templates/<?php echo $this->getTemplate();?>/dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php //echo $this->title ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="templates/<?php echo $this->getTemplate();?>/dist/img/avatar5.png" class="img-circle" alt="User Image">
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?com=users&view=profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="?com=users&logout=1" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>

		<aside class="main-sidebar">
		
		
		
		
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		<!-- Sidebar user panel -->
		<ul class="sidebar-menu">
		<li><a href="index.php?com=users&view=profile"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
		<li>
		<li><a href="index.php?com=shipping&view=prices_list" title="Manage Shipping Prices" tabindex="-1"><i class="fa fa-dollar"></i>Shipping Prices</a></li>
		</li>
		</ul>
		<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu" data-widget="tree">
	<li class="header">MAIN NAVIGATION</li>
	<li class="treeview">
		<a href="#"><i class="fa fa-map-marker"></i> <span>Manage Locations</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=lists&view=countries" title="Manage Countries" tabindex="-1"><i class="fa fa-globe"></i>Countries</a></li>
		<li><a href="index.php?com=lists&view=cities" title="Manage Cities" tabindex="-1"><i class="fa fa-circle-o"></i>Cities</a></li>
		<li><a href="index.php?com=shipping&view=ports" title="Manage Ports" tabindex="-1"><i class="fa fa-ship"></i>Ports</a></li>
		
		</ul>
	</li>

	<li class="treeview">
		<a href="#"><i class="fa fa-car"></i> <span>Manage Vehicles</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=vehicles&view=makes" title="Manage Manufacturers" tabindex="-1"><i class="fa fa-circle-o"></i>Manufacturers</a></li>
		<li><a href="index.php?com=vehicles&view=vehicles_admin" title="Admin Approval" tabindex="-1"><i class="fa fa-circle-o"></i>Admin Approval Awaiting</a></li>
		</ul>
	</li>

	<li class="treeview">
		<a href="#"><i class="fa fa-users"></i> <span>Manage Users</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=users&view=users" title="Users" tabindex="-1"><i class="fa fa-users"></i>Users</a></li>
		<li><a href="index.php?com=users&view=users_approval" title="Users" tabindex="-1"><i class="fa fa-check"></i>Pending Approvals</a></li>
		</ul>
	</li>


	<li class="treeview">
		<a href="#"><i class="fa fa-shopping-cart"></i> <span>Manage Sales</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=sales&view=sales" title="Sales" tabindex="-1"><i class="fa fa-circle-o"></i>Sales</a></li>
		<li class="hide"><a href="index.php?com=sales&view=pos" title="Point of sale" tabindex="-1"><i class="fa fa-circle-o"></i>POS</a></li>
		<li><a href="index.php?com=sales&view=sale_orders" title="Orders" tabindex="-1"><i class="fa fa-first-order"></i>Orders</a></li>
		<li class="hide"><a href="index.php?com=sales&view=sale_trash" title="Trash sale" tabindex="-1"><i class="fa fa-trash"></i>Trash</a></li>
		</ul>
	</li>

	<li class="treeview">
		<a href="#"><i class="fa fa-circle-o"></i> <span>Manage Subscriptions</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=shipping&view=subscriptions" title="Manage Subscriptions" tabindex="-1"><i class="fa fa-circle-o"></i>Subscriptions</a></li>
		<li><a href="index.php?com=shipping&view=user_subscriptions_admin" title="User Subscriptions" tabindex="-1"><i class="fa fa-circle-o"></i>User Subscriptions</a></li>
		</ul>
	</li>

	<li class="treeview">
		<a href="#"><i class="fa fa-user"></i> <span>Read Messages</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=contactus&view=admin" title="Manage Subscriptions" tabindex="-1"><i class="fa fa-circle-o"></i>Messages</a></li>
		</ul>
	</li>
	<li class="treeview">
		<a href="#"><i class="fa fa-cog"></i> <span>Settings</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
		<ul class="treeview-menu">
		<li><a href="index.php?com=localize&view=translate" title="Manage Subscriptions" tabindex="-1"><i class="fa fa-circle-o"></i>Translate</a></li>
		</ul>
	</li>

      </ul>

    </section>
    <!-- /.sidebar -->

	
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
	<div id="messages"><?php 
	foreach($messages as $m){
		echo '<div>' . $m . '</div>';
	}
	?></div>
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
	<?php /* ?><strong>Copyright &copy; 2014-2016 <a href="http://webapplics.com">Webapplics Studio</a>.</strong> All rights reserved.<?php */?>
	</footer>

  
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
    <!-- Tab panes -->
    <div class="tab-content">
    </div>
  </aside>
  <div class="control-sidebar-bg"></div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    <input type="hidden" id="return-value" value="" />
      <!-- Modal content--><div id=msg_modal"></div>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose an item</h4>
        </div>
        <table class="modal-body nav-able"></table>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<!-- Msg Modal -->
<div id="msgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Message</h4>
	</div>
	<div class="modal-body">
	<p></p>
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
	</div>

	</div>
</div>
  
</body>
  <!-- Bootstrap 4.3 -->
<script src="media/system/bootstrap4/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="templates/<?php echo $this->getTemplate();?>/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="templates/<?php echo $this->getTemplate();?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- DataTables -->
<script src="media/system/DataTables/datatables.min.js"></script>


<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jszip/dist/jszip.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/pdfmake/build/pdfmake.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/pdfmake/build/vfs_fonts.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>-->


<?php /*?><!-- SlimScroll -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/chart.js/Chart.js"></script>
<script src="templates/<?php echo $this->getTemplate();?>/bower_components/jquery.couch/jquery.couch.js"></script><?php */ ?>
	<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>
	<script src="components/<?php echo $com; ?>/com.js"></script>
    <script type="text/javascript">
	<?php echo $this->getScript(); ?>

	
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

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
            //console.log('safafsdf');
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


            return true;
	},'json')
		.done(function(obj) { 
		//console.log('Request done!');
            $('#left-article-search .results .article_code .value').text(obj.article_code);
            $('#left-article-search .results .title .value').text(obj.title);
            $('#left-article-search .qty .value').text(obj.qty);
            $('#left-article-search .scheme .value').text(obj.scheme);
            $('#left-article-search .discount .value').text(obj.discount);
            $('#left-article-search .sale_price .value').text(obj.sale_price);
            $('#left-article-search .cost_price .value').text(obj.cost_price);
			return true;
		})
        .fail(function(jqxhr, settings, ex) { console.log('failed, ' + ex); });
	//},dataType);
	
	
}



//$("#items-list").autocomplete({
$("#article_code").autocomplete({
    source:function(request,response){
        $.ajax({
          type: "GET",
          data:{txt: request.term},
          url: "?com=articles&view=articles&task=json&comboList=1",
          dataType: "json",
          success:function(data){
			var list= [];
			$.each(data,function (i,e){
				list.push({value:e.article_code, label:e.label});
			});
			response($.map(list, function (value, key) {
                return {label: value.label,value: value.value};
            }));
			
           }
         });
    },      
    minLength:2,
    delay: 100
});



	$("table.nav-able").keydown(function(e){
		var key = e.keyCode || e.which;
		if (key == 13) {
			// close model form
			//alert("entered");
			var cur_cell = currCell.html().toString();
			$("#article_code").val(cur_cell);$(".modal.in").modal("hide");return false;
		}
		currCell = navigateTableCells(e, currCell)
	});		




	$("input#left-article_code").keypress(function(e){
		e.stopPropagation();
		txt_article = $("input#left-article_code").val();
		var key = e.keyCode || e.which;
		if (key==13){
			//return false;
			txt_article = txt_article.toString();
			txt_article = txt_article.toString();
			var pos = txt_article.substr(0,1);
			if(pos=="-"){
				artSearch(txt_article,'left-article_code');
				return false;
			}
			
			var a = getArticleInfo(txt_article);
			if(a){
				$(this).val('');
				$(this).focus();
			}
			return false;
		}
	});
    $(window).keydown(function(e){
            var key = e.keyCode || e.which;
            var vFind = '';
			//e.preventDefault();
            //console.clear();
            //console.log(key);
			if (key==36){
                vFind = $("input#article_code");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        if(e.ctrlKey){
            //console.log(e.shiftKey);
            //console.log(e.ctrlKey);
            //console.log(e.altKey);
            //console.log(key);

            if (key==73){
				e.preventDefault();
                vFind = $("input#left-article_code");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }else if (key==83){
				e.preventDefault();
				/*if (typeof submitForm == 'function') { 
					submitForm(); 
				}*/
				if($('#save').length){
					$('#save').trigger('click');
				}
            }else if (key==70){
				e.preventDefault();
                vFind = $("[type=search]");
                if(vFind.length){
                    vFind.focus();
                    vFind.select();
                }
            }
        }else{return;}
    });

	
//Form load in modal
$("#myModal").on("show.bs.modal", function(e) {
    var link = $(e.relatedTarget);
    $(this).find(".modal-body").load(link.attr("href"));
});

(function(){
	$("#messages div").fadeOut( 30000, function() {
		//$("#messages div").hide();
		$("#messages").html('');
	});
})();

	
</script>

</html>