<?php
if( isset($_GET['select_ktv']))
{
	$maktv = $_GET['select_ktv'];
	$ten_KTV = $order_ktv->getTenKTV( $maktv );
	$maban = "";
	if(isset($_SESSION['MaBan']))
	{
		$maban = $_SESSION['MaBan'];
	}
	//$malichsuphieu = '20201027195237-0001';
	$order_ktv->updateKTVtoOrderID( $maktv, $ten_KTV, $maban, $malichsuphieu  );
?>
<script>
	setTimeout('window.location="home.php"',0);
</script>
<?php
}
?>

<h4 style="margin: 20px 0;">KỸ THUẬT VIÊN</h4> 
			<form action="" method="get">
			<div class="grid" style="margin-left: -10px;">	  
<?php
$maktv = "";
if(isset($_SESSION['MaKTV']))
{
	$maktv = $_SESSION['MaKTV'];
}
//echo $maktv;
//
//
	if (isset($_GET['pageno'])) 
	{
	   $pageno = $_GET['pageno'];
	} 
	else 
	{
		$pageno = 1;
	}
	
	$no_of_records_per_page = 20;// 12;//6;
	$startRowHB = ($pageno-1) * $no_of_records_per_page;
	$endpoint = $startRowHB + $no_of_records_per_page;
					
	$total_pages_sql = "select COUNT(*) from tblDMNhanVien  Where NhomNhanVien = '$manhomktvmoi'";
	try
	{
		$rs_total=sqlsrv_query($conn,$total_pages_sql);
		$total_rows=sqlsrv_fetch_array($rs_total)[0];
		$total_pages = ceil($total_rows / $no_of_records_per_page);
	}
	catch (Exception $e) 
	{
		echo $e->getMessage();
	}
	//		   
	 $sql="select MaNV, TenNV,NhomNhanVien, SourceHinhAnh from (SELECT *, ROW_NUMBER() OVER (ORDER BY TenNV) as rowNum FROM tblDMNhanVien Where NhomNhanVien = '$manhomktvmoi' and SourceHinhAnh is not null and SourceHinhAnh <> '') sub WHERE rowNum >  '$startRowHB' and rowNum <= '$endpoint'";
	try
	{
		$rs=sqlsrv_query($conn,$sql);
		$i=1;
		while($r2=sqlsrv_fetch_array($rs))
		{	
			$staff_pics = unserialize( $r2['SourceHinhAnh'] );
			if($maktv == $r2['MaNV'])
			{ 	
?>				
	            <button type="button" name="maktv" value="<?php echo $r2['MaNV']; ?>" class="hangban_active" data-toggle="modal" data-target="#product_view_active">
	            	<?php
	            	echo $maktv."<br>";
	            	?>
	            	<img src="<?=$staff_pics[0]?>" class="img-responsive" style="margin: auto;">
	        	</button>
	            <!-- Popup Img -->
				<div class="modal fade product_view" id="product_view_active">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div style="padding:5px">
				                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				                <h3>KTV: <?php echo $r2['TenNV']; ?></h3>
				            </div>
				            <div class="modal-body">
				                <div class="row">
				                    <div class="col-md-12 product_img">
				                        <div id="myCarousel_active" class="carousel slide" data-ride="carousel">
											  <!-- Indicators -->
											  <ol class="carousel-indicators">
											  	<?php
											  	
											  	for ($i = 0; $i <count($staff_pics); $i++)
											  	{ ?>
											    <li data-target="#myCarousel_active" data-slide-to="<?=$i?>" class="<?=($i == 0) ? 'active' : ''?>"></li>
											    <?php
												}
											    ?>
											    <!-- <li data-target="#myCarousel" data-slide-to="1"></li>
											    <li data-target="#myCarousel" data-slide-to="2"></li> -->
											  </ol>

											  <!-- Wrapper for slides -->
											  <div class="carousel-inner">
											  	<?php
											  	$i = 0;
											  	foreach ($staff_pics as $pic)
											  	{ ?>
											    <div class="item <?=($i == 0) ? 'active' : ''?>">
											      <img src="<?=$pic?>" >
											    </div>
											    <?php 
												$i++;}
											    ?>
											   <!--  <div class="item">
											      <img src="chicago.jpg" alt="Chicago">
											    </div>

											    <div class="item">
											      <img src="ny.jpg" alt="New York">
											    </div> -->
											  </div>

											  <!-- Left and right controls -->
											  <a class="left carousel-control" href="#myCarousel_active" data-slide="prev">
											    <span class="glyphicon glyphicon-chevron-left"></span>
											    <span class="sr-only">Previous</span>
											  </a>
											  <a class="right carousel-control" href="#myCarousel_active" data-slide="next">
											    <span class="glyphicon glyphicon-chevron-right"></span>
											    <span class="sr-only">Next</span>
											  </a>
										</div>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="col-md-6 product_content">
				                        <div class="row">
				                            
				                        </div>
				                        <div class="space-ten"></div>
				                        <div class="btn-ground">
				                            <div class="col-md-3 col-md-offset-12 col-xs-3 col-xs-offset-4">
					                        	<button type="submit" class="btn btn-warning" name="select_ktv" value="<?php echo $r2['MaNV']; ?>"  data-toggle="modal" data-target="#product_view">Chọn
					                            </button>
				                        	</div>
				                        </div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				<!-- End Popup Img -->
			    				
<?php
			}
			else
			{	
?>
				<button type="button" name="maktv" value="<?php echo $r2['MaNV']; ?>" class="hangban" data-toggle="modal" data-target="#product_view_<?=$r2['MaNV']?>" data-toggle="modal" data-target="#product_view">
					<?php
	            	echo $r2['MaNV']."<br>";
	            	?>
					<img src="<?=$staff_pics[0]?>" class="img-responsive" style="margin: auto;">
				</button>
				<!-- Popup Img -->
				<div class="modal fade product_view" id="product_view_<?=$r2['MaNV']?>">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				                <h3 class="modal-title">KTV: <?php echo $r2['TenNV']; ?></h3>
				            </div>
				            <div class="modal-body">
				                <div class="row">
				                    <div class="col-md-12 product_img">
				                        <div id="myCarousel_<?=$r2['MaNV']?>" class="carousel slide" data-ride="carousel">
											  <!-- Indicators -->
											  <ol class="carousel-indicators">
											  	<?php
											  	
											  	for ($i = 0; $i <count($staff_pics); $i++)
											  	{ ?>
											    <li data-target="#myCarousel_<?=$r2['MaNV']?>" data-slide-to="<?=$i?>" class="<?=($i == 0) ? 'active' : ''?>"></li>
											    <?php
												}
											    ?>
											    <!-- <li data-target="#myCarousel" data-slide-to="1"></li>
											    <li data-target="#myCarousel" data-slide-to="2"></li> -->
											  </ol>

											  <!-- Wrapper for slides -->
											  <div class="carousel-inner">
											  	<?php
											  	$i = 0;
											  	foreach ($staff_pics as $pic)
											  	{ ?>
											    <div class="item <?=($i == 0) ? 'active' : ''?>">
											      <img src="<?=$pic?>" >
											    </div>
											    <?php 
												$i++;}
											    ?>
											   <!--  <div class="item">
											      <img src="chicago.jpg" alt="Chicago">
											    </div>

											    <div class="item">
											      <img src="ny.jpg" alt="New York">
											    </div> -->
											  </div>

											  <!-- Left and right controls -->
											  <a class="left carousel-control" href="#myCarousel_<?=$r2['MaNV']?>" data-slide="prev">
											    <span class="glyphicon glyphicon-chevron-left"></span>
											    <span class="sr-only">Previous</span>
											  </a>
											  <a class="right carousel-control" href="#myCarousel_<?=$r2['MaNV']?>" data-slide="next">
											    <span class="glyphicon glyphicon-chevron-right"></span>
											    <span class="sr-only">Next</span>
											  </a>
										</div>
				                    </div>
				                </div>
				                <div class="row">
				                    <div class="col-md-6 product_content">
				                        <div class="row">
				                            
				                        </div>
				                        <div class="space-ten"></div>
				                        <div class="btn-ground">
				                            <div class="col-md-3 col-md-offset-12 col-xs-3 col-xs-offset-4">
					                        	<button type="submit" class="btn btn-warning" name="select_ktv" value="<?php echo $r2['MaNV']; ?>"  data-toggle="modal" data-target="#product_view">Chọn
					                            </button>
				                        	</div>
				                          
				                        </div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				<!-- End Popup Img -->
<?php
			}
		}//end while duyet danh sach hang ban
		
		sqlsrv_free_stmt( $rs);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}				
?>
			</div>	

			</form>
<!-- ----------------------Begin Pagination cho hang ban ---------------------->
		<ul class="pagination">
        	<li><a href="?pageno=1&manhomnv=<?=$manhomktvmoi?>">First</a></li>
        	<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo '?pageno='.($pageno - 1).'&manhomnv='.$manhomktvmoi; } ?>">Prev</a>
        	</li>
<?php
	$from=$pageno-3;
	$to=$pageno+3;
	if ($from<=0) $from=1;  $to=3*5;
	if ($to>$total_pages)	$to=$total_pages;
	for ($j=$from;$j<=$to;$j++) 
	{
		if ($j==$pageno) 
		{ 
?>
			<li class='active'><a href='order.php?pageno=<?=$j?>&manhomnv=<?=$manhomktvmoi?>'><?=$j?></a></li>
<?php 
		} 
		else 
		{ 
?>
			<li class=''><a href='order.php?pageno=<?=$j?>&manhomnv=<?=$manhomktvmoi?>'><?=$j?></a></li>
<?php 
		}
	}//end for duyet paging
?>
        	<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).'&manhomnv='.$manhomktvmoi; } ?>">Next</a>
        	</li>
        	<li><a href="?pageno=<?php echo $total_pages.'&manhomnv='.$manhomktvmoi ?>">Last</a></li>
    	</ul>
<!-- ------End Pagination cho hang ban ------------------------------------>