<?php
defined('_MEXEC') or die ('Restricted Access');

//print_r($row);exit;
$app=core::getApplication();

?>
<!-- Sparkline -->
<script src="templates/<?php echo $app->getTemplate();?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sale datewise
        <small>Last 30 days Chart</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
		
		

        <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header">

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body text-center">
              <div class="sparkline" data-type="bar" data-width="97%" data-height="100px" data-bar-Width="14" data-bar-Spacing="7" data-bar-Color="#f39c12">
               0,<?php echo implode($this->sale_total,","); ?>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		
		
		
		
		
		
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<!-- page script -->
<script>
  $(function () {
    //--
    //INITIALIZE SPARKLINE CHARTS
    $(".sparkline").each(function () {
      var $this = $(this);
      $this.sparkline('html', $this.data());
    });
    /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
    drawDocSparklines();

	
  });
  function drawDocSparklines() {

    // Bar + line composite charts
    $('#compositebar').sparkline('html', {type: 'bar', barColor: '#aaf'});
    $('#compositebar').sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {composite: true, fillColor: false, lineColor: 'red'});


    // Bar charts using inline values
    $('.sparkbar').sparkline('html', {type: 'bar'});

    $('.barformat').sparkline([1, 3, 5, 3, 8], {
      type: 'bar',
      tooltipFormat: '{{value:levels}} - {{value}}',
      tooltipValueLookups: {
        levels: $.range_map({':2': 'Low', '3:6': 'Medium', '7:': 'High'})
      }
    });


  }
</script>