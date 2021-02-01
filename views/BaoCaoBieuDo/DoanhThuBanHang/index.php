<?php
require_once('./helper/security.php');
require_once('./lib/BaoCaoBieuDo.php');
$chartReport = new BaoCaoBieuDo($conn);
?>
<script>
var title = "Doanh Thu Theo Năm";
</script>
<div class="panel with-nav-tabs panel-primary ">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1primary" data-toggle="tab">Năm này</a></li>
            <li><a href="#tab2primary" data-toggle="tab">Năm trước</a></li>
			<li><a href="#tab3primary" data-toggle="tab">Khác</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1primary">
              <div class="col-xs-12 col-sm-12 table-responsive">
              	<?php require('this_year.php'); ?>	
               </div>
	        </div>
            <div class="tab-pane fade" id="tab2primary">	
              <div class="col-xs-12 col-sm-12 table-responsive">
              	<?php require('last_year.php'); ?>	
              </div>
            </div>
            <div class="tab-pane fade" id="tab3primary">
              <div class="col-xs-12 col-sm-12 table-responsive">
              	<?php require('another_year.php');  ?>	
              </div>
            </div>
        </div>
    </div>
</div>