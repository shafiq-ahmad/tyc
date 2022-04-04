<?php
defined('_MEXEC') or die ('Restricted Access');


$data="Pellentesque sed nisl enim. Suspendisse viverra mauris non feugiat varius. Vivamus auctor rutrum tellus, vitae vestibulum nibh iaculis id. Ut a ligula nec quam congue hendrerit id nec orci. Nunc diam nibh, tempus ut dictum eget, adipiscing ac eros. Vivamus elementum volutpat mauris, eget aliquam massa. In vel rutrum nisl, ac faucibus massa. Nam interdum dolor id urna gravida, sed blandit risus iaculis.
Aliquam in arcu ac nibh euismod interdum quis sit amet odio. Donec cursus ac ipsum quis fermentum. Pellentesque vehicula, massa et volutpat cursus, massa est hendrerit odio, vitae tincidunt est ante vel elit. Vestibulum dui ";?>
<div class="slider-wrapper-front theme-default">
            <div id="slider" class="nivoSlider">
<img src="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/1.jpg" data-thumb="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/1.jpg" alt="" title="#htmlcaption2" />
<img src="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/2.jpg" data-thumb="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/2.jpg" alt=""  title="#htmlcaption3"  />
<img src="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/3.jpg" data-thumb="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/3.jpg" alt="" title="#htmlcaption4"  />
<img src="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/4.jpg" data-thumb="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/4.jpg" alt="" title="#htmlcaption1"  />
<img src="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/5.jpg" data-thumb="templates/<?php echo $this->getTemplate();?>/assets/images/slideshow/5.jpg" alt="" title="#htmlcaption1"  />
</div>
<div id="htmlcaption1" class="nivo-html-caption">
<p><?php //echo short_description($data,250)?></p><a href="vehicle_details.php?vehicle_id=<?php echo ""?>" class="btn btn-xss btn-danger float-right"><?php echo Localize::_('read_more');?></a>
</div>
<div id="htmlcaption2" class="nivo-html-caption">
<p><?php //echo short_description($data,250)?></p>
<a href="vehicle_details.php?vehicle_id=<?php echo ""?>" class="btn btn-xss btn-danger float-right"><?php echo Localize::_('read_more');?></a> 
</div>
<div id="htmlcaption3" class="nivo-html-caption">
<p><?php //echo short_description($data,250)?></p><a href="vehicle_details.php?vehicle_id=<?php echo ""?>" class="btn btn-xss btn-danger float-right"><?php echo Localize::_('read_more');?></a>
</div>
<div id="htmlcaption4" class="nivo-html-caption">
<p><?php //echo short_description($data,250)?></p><a href="vehicle_details.php?vehicle_id=<?php echo ""?>" class="btn btn-xss btn-danger float-right"><?php echo Localize::_('read_more');?></a>
</div>
</div>

<script type="text/javascript">
    $(window).load(function() {
    $('#slider').nivoSlider({
    effect: 'fade',               // Specify sets like: 'fold,fade,sliceDown',
    slices: 15,                     // For slice animations
    boxCols: 14,                     // For box animations
    boxRows: 16,                     // For box animations
    animSpeed: 1000,                 // Slide transition speed
    pauseTime: 4500,                // How long each slide will show
    startSlide: 0,                  // Set starting Slide (0 index)
    directionNav: false,             // Next & Prev navigation
    controlNav: true,               // 1,2,3... navigation
    controlNavThumbs:false,        // Use thumbnails for Control Nav
    pauseOnHover: true,             // Stop animation while hovering
    manualAdvance: false,           // Force manual transitions
    prevText: 'Prev',               // Prev directionNav text
    nextText: 'Next',               // Next directionNav text
    randomStart: false,             // Start on a random slide
    beforeChange: function(){},     // Triggers before a slide transition
    afterChange: function(){},      // Triggers after a slide transition
    slideshowEnd: function(){},     // Triggers after all slides have been shown
    lastSlide: function(){},        // Triggers when last slide is shown
    afterLoad: function(){}         // Triggers when slider has loaded
});
});
    </script>