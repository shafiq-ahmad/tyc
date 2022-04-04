<?php
//$pa =  $user->pageAccess(12);
$u=array();
if(self::$options->com != 'user' && self::$options->view != 'login'){
	$u=$this->user->getUser();
}
?>
<style>
#modal-body{padding:20px;}
</style>
<div id="modal-body"><?php
echo $this->_com;
?>
</div><script>
<?php echo $this->getScript(); ?>
</script>

