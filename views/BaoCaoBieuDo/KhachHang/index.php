<?php
require_once('helper/security.php');
require_once('lib/BaoCaoBieuDo.php');
$clientDev = new BaoCaoBieuDo($conn);

?>
<script type="text/javascript">
  var title = "Biểu đồ phát triển khách hàng";
</script>
<div class="panel with-nav-tabs panel-primary ">
    <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1primary" data-toggle="tab">Theo tuần</a></li>
                <li><a href="#tab2primary" data-toggle="tab">Theo tháng</a></li>
                <li><a href="#tab3primary" data-toggle="tab">Theo năm</a></li>
            </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1primary">
              <div class="col-xs-12 col-sm-12">
              	<?php require('by_week.php'); ?>
               </div>
          </div>
          <div class="tab-pane fade" id="tab2primary">
            <div class="col-xs-12 col-sm-12">
            	<?php require('by_month.php'); ?>
            </div>
          </div>
          <div class="tab-pane fade" id="tab3primary">
            <div class="col-xs-12 col-sm-12">
            	<?php require('by_year.php');  ?>
            </div>
          </div>
                    
            
        </div>
    </div>
</div>