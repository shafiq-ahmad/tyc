
<section class="footer_wrapper"><!--footer-->
<footer>
<div class="footer1"><?php
	echo $this->showModule('newsletter');
?></div>
<div class="footer2">
<h5><?php echo Localize::_('miscellaneous');?></h5>
<ul>
<li><a href="<?php echo Route::_('');?>"><?php echo Localize::_('menu_terms_conditions');?></a></li>
<li><a href="<?php echo Route::_('');?>"><?php echo Localize::_('menu_privacy');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=pages&view=faqs');?>"><?php echo Localize::_('menu_faqs');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=contactus&view=contact');?>"><?php echo Localize::_('menu_contact_us');?></a></li>
</ul>
</div>
<div class="footer3">
<h5><?php echo Localize::_('miscellaneous');?></h5>
<ul>
<li><a href="<?php echo Route::_('');?>"><?php echo Localize::_('menu_terms_conditions');?></a></li>
<li><a href="<?php echo Route::_('');?>"><?php echo Localize::_('menu_privacy');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=pages&view=faqs');?>"><?php echo Localize::_('menu_faqs');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=contactus&view=contact');?>"><?php echo Localize::_('menu_contact_us');?></a></li>
</ul>
</div>
<div class="footer4">
<h5><?php echo Localize::_('miscellaneous');?></h5>
<ul>
<li><a href="<?php echo Route::_('');?>"><?php echo Localize::_('menu_terms_conditions');?></a></li>
<li><a href="<?php echo Route::_('');?>"><?php echo Localize::_('menu_privacy');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=pages&view=faqs');?>"><?php echo Localize::_('menu_faqs');?></a></li>
<li><a href="<?php echo Route::_('index.php?com=contactus&view=contact');?>"><?php echo Localize::_('menu_contact_us');?></a></li>
</ul>
</div>
</footer>
<center>
<p class="copyright">&copy;<?php echo Localize::_('copyright');?> 2019 <?php echo Localize::_('business_name');?>
</p>
</center>
</section><!--end of footer warpper-->


<!-- Msg Modal -->
<div id="msgModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><?php echo Localize::_('message');?></h4>
	</div>
	<div class="modal-body">
	<p></p>
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Localize::_('close');?></button>
	</div>
	</div>

	</div>
</div>
</body>
<script src="templates/<?php echo $this->getTemplate();?>/js/script.js"></script>

<script src="components/<?php echo $com; ?>/com.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
	$('[data-toggle="popover"]').popover();  

});
</script>
<?php
echo $this->getFoot();
?>
</html>
