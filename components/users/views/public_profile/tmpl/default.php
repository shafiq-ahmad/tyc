<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/
defined('_MEXEC') or die ('Restricted Access');

$user = $this->user;
$db = Core::getDBO();

$country_id = 0;
//var_dump($user);exit;
if($user){
$country_id = $user['country'];

//$user['photo'];
//echo HtmlForm::htmlSelect($this->countries, $country_id, 'country_id');

$seller = $this->id;

?>

<div class="site_contents" style="width:100%;">
<section class="profile_details_wrapper">
<div class="profile_top">
<h2><?php echo $user['full_name'];?></h2>
<div class="profile_logo">
<img src="media/images/user_logo.jpg"  width="116" height="33" alt="company_logo"/>
</div>
</div>
<div class="profile_space">
<div class="profile_pic">
<img src="<?php echo $user['file']; ?>" src="<?php echo $user['srcset']; ?>" alt="user">
</div>
<div class="whereabouts">
<ul>
<li>
<span class="main_heading"><?php echo Localize::_('location'); ?></span>
<span class="main_desc"><?php
$address = $user['address'] . ', ' . $user['country_name'];

echo $address;
?></span>
<span class=""></span>
</li>
<li><span class="main_heading">
<?php echo Localize::_('sales_hours'); ?></span>
<span class="main_desc"><?php echo $user['sale_hours'];?></span>
</li>
<li>
<span class="main_heading">
<?php echo Localize::_('phone'); ?></span>
<span class="main_desc">
<?php echo $user['phone'];?>
</span>
</li>
<li>
<span class="main_heading">
<?php echo Localize::_('email'); ?></span>
<span class="main_desc">
<?php echo $user['e_mail'];?>
</span>
</li>
<li>
<span class="main_heading">
<?php echo Localize::_('website'); ?></span>
<span class="main_desc">

</span>
</li>
</ul>
</div><!--profile details wrapper ends here-->
</div><!--public profile page end-->
<div class="profile_notes">
<h4 style="padding-top:1em;"><?php echo Localize::_('seller_notes'); ?> </h4>
<p>
<?php echo $user['notes'];?>

</p>
</div>
<div class="tab_navigation">
<ul class="nav nav-tabs custom_nav_tabs">
<li class="nav-item">
<a href="#inventory" class="nav-link active" role="tab" data-toggle="tab"><span style="padding-right:.5em"><i class="fas fa-car"></i></span><?php echo Localize::_('seller_inventory'); ?></a>
</li>
<li class="nav-item">
<a href="#review_report" class="nav-link" role="tab" data-toggle="tab"><span style="padding-right:.5em"><i class="fas fa-star"></i></span><?php echo Localize::_('seller_reviews'); ?></a>
</li>
<li class="nav-item">
<a href="#write_review" class="nav-link" role="tab" data-toggle="tab"><span style="padding-right:.5em"><i class="far fa-edit"></i></span><?php echo Localize::_('write_a_review'); ?></a>
</li>
</ul>
</div>
<div class="tab-content tab_navigation_content">
<div role="tabpanel" class="tab-pane active" id="inventory">
<?php //import('view_options');?>
<h4 class="veh_headings"><span class="inventory_headings">
<?php echo Localize::_('seller_inventory'); ?></span></h4>
<div class="vehicles_list all_vehicles grid_view_display">
<ul>
<?php
$sql = "SELECT v.* FROM vehicles_image_media AS vim ";
$sql .= "INNER JOIN vehicles AS v ON (vim.vehicle_id = v.id) ";
$sql .= "INNER JOIN media AS m ON (vim.media_id = m.id) ";
$sql .= "WHERE v.user_id={$user['id']} LIMIT 1";
$vehicles=$db->get_by_sqlRows($sql);
//check_count($vehicles);
foreach($vehicles as $value): ?>
<li>
<?php ?><div class="single_vehicle" id="single_vehicle<?php echo $value['id']?>">
<a href="index.php?com=vehicles&view=vehicle&id=<?php echo $value['id']?>"><?php
$sql = "SELECT m.img_pc FROM vehicles_image_media AS vim ";
$sql .= "INNER JOIN media AS m ON (vim.media_id = m.id) ";
$sql .= "WHERE vim.vehicle_id={$value['id']} LIMIT 1";
$vehicle_image=$db->get_by_sqlRow($sql);
foreach($vehicle_image as $veh_img){ ?>
<img class="cmpr" src="<?php echo $veh_img;?>">
</a>
<?php }  ?>
<div class="veh_info">
<div style="width:60%; float:left;">
<span class="veh_title"><?php echo $value['title']?></span>
<span class="veh_desc"><?php echo $value['model']?></span>
</div>
<div class="price_div">
<span class="price">$<?php echo $value['price']?></span>
</div>
</div>
<span class="digit_info"><?php echo $value['mileage']?></span>
<span class="transmission">
<?php //echo General::object_name($value['transmission'],'transmission','title')?></span>
<span class="comparison_link" id="<?php echo $value['id']?>"><?php echo Localize::_('compare'); ?></span>
</div>
</li>
<?php endforeach; ?>
</ul>
</div>
<div class="row_view_display">
<ul>
<?php
foreach($vehicles as $value): ?>
<li>
<div class="vehicle_view_row"> 
<a href="index.php?com=vehicles&view=view&id=<?php echo $value['id']?>"><?php

/*$sql = "SELECT m.* FROM vehicles_image_media AS vim ";
//$sql .= "INNER JOIN vehicles AS v ON (vim.vehicle_id = v.id) ";
$sql .= "INNER JOIN media AS m ON (vim.media_id = m.id) ";
$sql .= "WHERE vim.vehicle_id={$value['id']} LIMIT 1";*/
//echo $sql;exit;
//$vehicle_image=$db->get_by_sqlRows($sql);
foreach($vehicle_image as $veh_img){ ?>
<img class="row_view_main_vehicle cmpr" src="<?php echo $veh_img['img_thumb']?>" alt="vehicle">
</a>
<?php } ?>
<div class="vehicle_row_details">
        <a href="vehicle_details.php?vehicle_id=<?php echo $value['id']?>" class="vehicle_title"><?php echo $value['title'];?></a>
        <p class="vehicle_price_box">$<?php echo $value['price']?></p>
        <div class="clearfix"></div>
        <ul class="vehicle_view_params">
          <li>
            <div class="vparamsdetails"> <span class="attrib_icon"></span>
              <div class="two_spans"> <span class="attrib"><?php echo Localize::_('mileage'); ?></span><span class="value"><?php echo $value['mileage']?></span> </div>
            </div>
          </li>
          <li>
            <div class="vparamsdetails"> <span class="attrib_icon"></span>
              <div class="two_spans"> <span class="attrib"><?php echo Localize::_('fuel'); ?></span><span class="value">
<?php //echo capital_start(General::object_name($value['fuel_type'],'fuel_type','title'))?></span> </div>
            </div>
          </li>
          <li>
            <div class="vparamsdetails"> <span class="attrib_icon"></span>
              <div class="two_spans"> <span class="attrib"><?php echo Localize::_('year'); ?></span>
<span class="value"><?php //echo General::object_name($value['year'],'years','title')?></span> </div>
            </div>
          </li>
          <li>
            <div class="vparamsdetails"> <span class="attrib_icon"></span>
              <div class="two_spans"> <span class="attrib"><?php echo Localize::_('transmission'); ?></span><span class="value"><?php 
			  //echo capital_start(General::object_name($value['transmission'],'transmission','title'))?></span> </div>
            </div>
          </li>
          <li>
            <div class="vparamsdetails"> <span class="attrib_icon"></span>
              <div class="two_spans"> <span class="attrib"><?php echo Localize::_('drive'); ?></span><span class="value">
<?php //echo uppercase(General::object_name($value['drive'],'drive','title'))?></span> </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="options_list_wrapper">
        <ul>
          <li><a href="#" class="active_option hide">veh #71598</a></li>
          <li><a href="#"><?php echo Localize::_('add_to_compare'); ?></a></li>
          <li><a href="#"><?php echo Localize::_('share_this'); ?></a></li>

        </ul>
      </div>
    </div>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
<div role="tabpanel" class="tab-pane" id="review_report">
<div class="rating_report_wrapper">
<h4 style="text-shadow:1px 1px 1px silver; font-weight:bold; padding-top:1.5em"><?php echo Localize::_('dearlers_rating'); ?></h4>
<center><?php

?><div class="review_average">
<span class="avg_title">average rating</span><?php
$avg_r = round($this->avg_rating,2);
?>
<span class="avg_figure"><?php echo $avg_r;?></span><span class="slant">/5</span>
<ul><?php
$this->getStars($avg_r, 5);
?>
</ul><?php
$review_count = count($this->reviews);
?><span class="avg_gist">[ <?php echo Localize::_('based on '); ?> <?php echo $review_count;?> <?php echo Localize::_('ratings'); ?> ]</span>
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Service",
  "name": "<?php echo $user['full_name'];?>",
  "description": "",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo $avg_r;?>",
    "bestRating": "<?php echo $review_count*5;?>",
    "ratingCount": "<?php echo $review_count;?>"
  }
}
</script>
</div>
</center>
<div class="reviews_list"><?php
$sql='';


?><h4 style="padding-top:1em; font-weight:bold;"><?php echo Localize::_('reviews'); ?> ( <?php echo count($this->reviews);?> )</h4><?php 

foreach($this->reviews as $r){ ?>
<hr>
<div class="each_review">
<ul>
<li>
<span style=" display:inline-block; font-weight:bold; font-size:1.8em; padding-right:.5em"><?php echo $r['rating'];?></span><?php
$this->getStars($r['rating'], 5);
?></li>
</ul>
<?php /*?><h5>Bestas and furious</h5><?php */?>
<p><?php
echo $r['content'];

?></p>
<span style="display:inline-block; font-weight:bold; color:black; padding-right:1em;">
<span style="color:grey; font-size:1.2em"><?php echo Localize::_('by');?></span> <?php echo $r['full_name'];?></span>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Review",
  "itemReviewed": {
    "@type": "Service",
    "image": "<?php echo addslashes($user['file']); ?>",
    "name": "<?php echo $user['full_name'];?>"
  },
  "reviewRating": {
    "@type": "Rating",
    "ratingValue": "<?php echo $r['rating'];?>"
  },
  "name": "<?php echo $user['full_name'];?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo $r['full_name'];?>"
  },
  "reviewBody": "<?php echo $r['content'];?>",
  "publisher": {
    "@type": "Organization",
    "name": "tycontrader.com"
  }
}
</script>
<?php } ?> 

</div><!--reviews list ends here-->
</div><!--rating report wrapper ends-->
</div>
<div role="tabpanel" class="tab-pane" id="write_review">
<div class="rating_report_wrapper">
<div class="review_form">
<form method="post" action="?com=users&view=public_profile&task=json&seller=<?php echo $seller;?>">
<input type="hidden" name="user_id" value="<?php echo $seller;?>" />
<input type="hidden" name="action" value="add_review" />
<div class="form-group">
<label><?php echo Localize::_('rating'); ?>:</label>
<select class="form-control" name="rating" required>
<option value=""><?php echo Localize::_('select_');?></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>
</select>
</div>
<div class="form-group">
<label><?php echo Localize::_('your_review'); ?></label>
<textarea class="form-control" name="content" rows="8" required></textarea>
</div>
<div class="form-group">
<button type="submit" class="btn btn-warning"
 style="text-shadow:1px 1px 1px black; font-size:.9em;"><?php echo Localize::_('submit_review'); ?></button>
</div>
</form>
</div>

</div>
</div>
</section>
<aside class="profile_widgets">
<div class="seller_geo"><?php
/*$url = "http://maps.google.com/maps/api/geocode/json?address=West+Bridgford&sensor=false&region=UK";
$response = file_get_contents($url);
$response = json_decode($response, true);
var_dump($response);exit;
$lat = $response['results'][0]['geometry']['location']['lat'];
$long = $response['results'][0]['geometry']['location']['lng'];

echo "<h3>latitude: " . $lat . " longitude: " . $long . '</h3>';*/
?>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
    var myMap;
    var myLatlng = new google.maps.LatLng(52.518903284520796,-1.450427753967233);
    function initialize() {
        var mapOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP  ,
            scrollwheel: false
        }
        myMap = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: myMap,
            title: '<?php echo $user['full_name'];?>',
            icon: 'http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png'
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="map" style="width:255px; height: 255px;">

</div>

</div>
<div class="seller_contact_form">
<h5><?php echo Localize::_('contact_seller'); ?></h5>
<form action="#" method="POST">
<div class="form-group">
<textarea class="form-control" name="message" placeholder="<?php echo Localize::_('your_message'); ?>"></textarea>
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="<?php echo Localize::_('your_name'); ?>">
</div>
<div class="form-group">
<input type="email" class="form-control" placeholder="<?php echo Localize::_('your_email'); ?>">
</div>
<div class="form-group">
<input type="text" class="form-control" placeholder="<?php echo Localize::_('your_phone'); ?>">
</div>
<div class="form-group">
<button type="submit" class="btn btn-sm btn-primary"><?php echo Localize::_('send_message'); ?></button>
</div>
</form>
</div>
<div class="small_ad">
<a href="#">
<img src="media/images/ad.jpg">
</a>
</div>
</aside>
</div><!--site contents end-->
</div><!--end-->

<?php //endforeach; 
}
?>

<script>
$(function(){
	$('span.rating').click(function(){
		var total=$(this).attr('id');/*Getting the nth number of clicked item*/
		var rating_order=$(this).parent('li').attr('id');/*Finding the selector id*/
		var selection=$('span.selected_rating');/*Making selection for class/existing Removal*/
		$('li#'+rating_order).find(selection).removeClass('selected_rating');
		/*Resetting/Removing the existing selected*/
		$(this).toggleClass('selected_rating');/*Applying the desired class*/
		for(i=0;i<=total;i++) /*Applying the desired class to selection*/
		{
			$('li#'+rating_order+' span.rating:nth-child('+i+')').addClass('selected_rating');
		}
		$('li#'+rating_order+' span.rating_score').text(total + ' Out of 5');/*Visible Aid/Text*/
		});
	});
</script>
