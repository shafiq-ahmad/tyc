<?php
defined('_MEXEC') or die ('Restricted Access');

$url = 'media/images/makes/';
$db = Core::getDBO();

//logo

?><div id="manufacturers" class="manufacturers">
<center>
<a href="#" target="_blank"><img src="media/images/makes/bmw.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/ford.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/mer.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/audi.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/skoda.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/toyota.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/nissan.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/chev.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/buick.png"></a>
<a href="#" target="_blank"><img src="media/images/makes/volks.png"></a>
</center>
</div>

<script type="text/javascript">
$(window).load(function () {
	$("#manufacturers").endlessScroll({ width: '80%', height: '150px', steps: -2, speed: 40, mousestop: true });
});
</script>
