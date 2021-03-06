<?php
include('./lib/BaoCaoBieuDo.php');
$dophu = new BaoCaoBieuDo($conn);
?>
<style>
.table.doanhthu > tbody > tr:first-child > td {
	color: green;
	font-weight: 700;
}

[id^="chart_legends"] ul{
   list-style: none;
   white-space: nowrap;
   margin-top: 10px;
   padding-left: 0;
	font-size: 18px;
}

[id^="chart_legends"] li span{
   width: 62px;
   height: 20px;
   display: inline-block;
   margin: 0 5px 8px 0;
   vertical-align: -9.4px;
}

.seperator {
	border-top: 8px dotted #bbb;
  	border-radius: 1px;
  	margin: 20px 0
}

@media all and (min-width:769px){
	
	[id^="chart_legends"] ul{
	   margin-top: 100px;
	   font-size: 1.3vw;
	}
 }

	
@media all and (max-width:667px){
	
	[id^="chart_legends"] ul {
	   	margin-top: 100px;
		font-size: 1.3vw;
		font-weight: 700;
	}
	
	[id^="chart_legends"] li span {
		width: 7em;
		height: 3em;
	}

	.loop_start > div:nth-child(1), .loop_start > div:nth-child(2){
		background: #F0F8FF;
		min-height: 250px;
	}

	
}	

@media all and (max-width:375px) {

	[id^="chart_legends"] ul {
	    margin-top: 18vh;
	    font-size: 1.8vw;
	    font-weight: 700;
		position: relative;
		right: 1em;
	}

	[id^="chart_legends"] li span {
    	width: 5em;
    	height: 2em;
	}

	.dophu_baygio, .dophu_khac{
		height: 235px!important;
	}

}


</style>
<div class="panel with-nav-tabs panel-primary ">
        <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1primary" data-toggle="tab">Hôm nay</a></li>
                    <li><a href="#tab2primary" data-toggle="tab">Khác</a></li>
                </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1primary">
                    <div class="col-xs-12 col-sm-12">
                        <div class="container-fluid">
                           	<?php
                          	$khu = $general->getKhu();//echo sqlsrv_num_rows($khu);
							//var_dump( $count );
							$i = 0;
							foreach ( $khu as $r ) 
							{ 	
								
								$ma_khu = $r['MaKhu'];
								$ten_khu_raw = $r['MoTa'];
								$ten_khu = stripSpecial(stripUnicode(($r['MoTa'])));

								$file_name = __DIR__ . '/KhuList/' . $ten_khu . '.php';
								
								if( file_exists($file_name)  )
							    {
							      unlink($file_name);
							    }

								if( !( file_exists($file_name) ) ){
		                            $file_contents = file_get_contents(__DIR__ ."/template.php");
		                            file_put_contents( $file_name , $file_contents );
		                        }

		                         if( $r['count'] != 1 && $i % 2 === 0 )
								{ ?>
									 <div class="row loop_start" >
								<?php }
								
								ob_start();
								include($file_name);
								echo ob_get_clean();

								if( $i % 2 !== 0)
								{ ?>
									</div>
									<div class="seperator"></div>
								<?php }
								
								$i++;
							} 
	                        ?>
						</div>
                   	</div>
                </div>
                <div class="tab-pane fade" id="tab2primary">
                  <div class="col-xs-12 col-sm-12">
                    <?php include("time_filter.php")?>
                  </div>
                </div>

            </div>
        </div>
    </div>