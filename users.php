<?php 
require('lib/db.php');
require('lib/ADMIN.php');
require('functions/lichsuphieu.php');
$sgDep = new Admin($conn);
@session_start(); 

date_default_timezone_set('Asia/Bangkok');


$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
//
//--------------------X? LÝ KHU, BÀN ----------------------//
//

?>
<!DOCTYPE HTML>
<html>
<head>
<title>ZinSpa-Quản lý Điều tour Massage</title> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Ph?n m?m qu?n lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />

<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">
<link href="css/style_from_home.css" rel="stylesheet">
<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style> 

</style>
</head>
<body>
<div id="wrapper">
  <?php include 'menukhu.php'; ?>
  <div id="page-wrapper">
  <div class="col-md-12 graphs">
  <div class="xs">
  <div class="row">
    <div class="col-md-12">
      <div class="grid">

        <div class="container" id="wrap"> 
			<div class="row"> 
				<div class="btn-toolbar" style="margin-bottom:10px"> 
					<button class="btn btn-primary"><a href="signup.php" style="text-decoration: none; color:#fff">Thêm User</a></button> 
				</div>

                <div class="well col-md-11" style="background:#fff; font-size: 1.2em;">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ID</th>
                          <th>Tên</th>
                          <th>Báo cáo được xem</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
                        $i = 1;
                        $users_list = $sgDep->layDanhSachUsers(); 
                        foreach ( $users_list as $r ) { ?>
                                                          
                        <tr>
                          <td><?=$i?></td>
                          <td><?=$r['TenSD']?></td>
                          <td><?=$r['TenNV']?></td>
                          <td><ul style="padding-left:0px">
                            <?php 
                                $bao_cao_duoc_xem_arr = ( !empty( $r['BaoCaoDuocXem'] )   ?  unserialize(str_replace('&quot;','"',$r['BaoCaoDuocXem'])) :"" );
                                $ten_bao_cao = "";
                                 $report_name = "";
                                if ( !empty($bao_cao_duoc_xem_arr ) )
                                foreach ($bao_cao_duoc_xem_arr as $bao_cao_duoc_xem) {
                                        $ten_bao_cao = $sgDep->layBaoCao($bao_cao_duoc_xem);
                                        $report_name .=  '<li>' .
                                                    $ten_bao_cao . 
                                                 '</li>'
                                            ;
                                }
                                echo $report_name;
                            ?>
                          </ul></td>
                          <td>
                              <a href="user-update.php?maNV=<?=$r['MaNV']?>"><i class="glyphicon glyphicon-pencil" style="font-size: 1.3em;"></i></a>
                              
                          </td>
                          <td>
                             
                              <a href="user-delete.php?maNV=<?=$r['MaNV']?>" onclick="return confirm('Are you sure you want to delete?');" role="button" data-toggle="modal"><i class="glyphicon glyphicon-remove-sign" style="color:#F44336; font-size: 1.3em;"></i></a>
                          </td>

                        </tr>

                         <?php $i++; } ?>
                      </tbody>
                    </table>
                </div>  
            </div>          
        </div>

  </div>   
  <!-- /div class="xs" -->
    </div>
  <!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Nav CSS -->
<!-- Metis Menu Plugin JavaScript -->

<script src="js/custom.js"></script>


</body>
</html>
