<?php
defined('_MEXEC') or die ('Restricted Access');


?>
<style>
div.home-btn{
	min-width:140px;
	max-height:150px;
	height:115px;
	padding:10px;
	margin:5px;
	border:1px solid $ccc;
	border-radius:3px;
	box-shaddow:0 4px 3px -3px grey;
	text-align:center;
	display:inline-block;
	background:#fff;
	
	
}

div.home-btn img{
	max-width:120px;
	height:60px;
	margin:5px;
}
div.home-btn p{
	color:black;
}

</style>
<a href="?com=messages"><div class="home-btn wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
<img src="templates/default/images/icon/messages.png" alt="users Managment">
<p>Messages</p>
</div></a>

<a href="?com=articles&view=stock_alerts"><div class="home-btn wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
<img src="templates/default/images/icon/alert.png" alt="users Managment">
<p>Stock Alerts</p>
</div></a>

<a href="?com=articles&view=expiry_alerts"><div class="home-btn wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
<img src="templates/default/images/icon/expire.png" alt="users Managment">
<p>Expiry Alerts</p>
</div></a>

<a href="?com=articles&view=branch_articles"><div class="home-btn wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
<img src="templates/default/images/icon/list.png" alt="users Managment">
<p>Items List</p>
</div></a>

<a href="?com=customers&view=customers"><div class="home-btn wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
<img src="templates/default/images/icon/clist.png" alt="users Managment">
<p>Customer's List</p>
</div></a>

<a href="?com=suppliers&view=suppliers"><div class="home-btn wow zoomIn animated" style="visibility: visible; animation-name: zoomIn;">
<img src="templates/default/images/icon/clist.png" alt="users Managment">
<p>Supplier's List</p>
</div></a>

