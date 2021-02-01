<?php
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();	//session_destroy();
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('Asia/Bangkok');

$manv = "";
if(isset($_SESSION['MaNV']))
{
  $manv = $_SESSION['MaNV'];
}

$malichsuphieu = ""; $tongtien = 0; $tiengiamgia = 0; $tienthuctra = 0;
if(isset($_SESSION['MaLichSuPhieu']))
{
  $malichsuphieu = $_SESSION['MaLichSuPhieu'];
}

if($malichsuphieu==null or $malichsuphieu=="")
{
?> 
  <script> 
    alert('chưa có thông tin phiếu bán');
    setTimeout('window.location="home.php"',0);
  </script>
<?php
}
else
{
    func_TinhTienThucTra($conn, $malichsuphieu);
    //
    //----lay tien thuc tra
    //
    
    $sql = "Select TongTien, TienGiamGia, TienThucTra From tblLichSuPhieu Where MaLichSuPhieu like '$malichsuphieu'";
    $rs=sqlsrv_query($conn,$sql);
    if(sqlsrv_has_rows($rs) != false)
    {
      while ($r1 = sqlsrv_fetch_array($rs))
      {
        $r1['TongTien'];
        $r1['TienGiamGia'];
        $r1['TienThucTra'];
        $tongtien = $r1['TongTien'];
        $tiengiamgia = $r1['TienGiamGia'];
        $tienthuctra = $r1['TienThucTra'];
      }
    }
}
//
//
$ketthuc = 0;
if(isset($_GET['ketthuc']))
{
	$ketthuc = $_GET['ketthuc'];
	if($ketthuc == 1)
	{
    //
    //----xu ly in phieu
    //
		$sql = "Insert into tblOrder_InPhieuTinhTien(MaNV,ThoiGianIn,MaLichSuPhieu,TinhTrangIn, InTamTinh) values('$manv','".date('Y-m-d H:i:s')."','$malichsuphieu','0','0')";
		$rs=sqlsrv_query($conn,$sql);
    //
    //----xu ly ket thuc phieu
    //
    $httt = "tienmat";
    if(isset($_POST['optradio']))
    {
      $httt = $_POST['optradio'];
      //echo $httt; //ok
    }

    $l_sResult = "";
    $l_sResult = func_KetThucPhieu($conn, $malichsuphieu, $httt);

    unset($_SESSION['MaLichSuPhieu']);
    unset($_SESSION['MaBan']);
    unset($_SESSION['MaNhomHangBan']);
    unset($_SESSION['MaHangBan']);
?> 
  <script> 
    setTimeout('window.location="home.php"',0);
  </script>
<?php
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>ZinSpa-Quản lý Spa chuyên nghiệp</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />

<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script
src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<style> 
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 12px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/

#myDIV {
    margin: 10px; /*original: 25px */
    width: 100%; /*original: 550px */
    background: orange;
    position: relative;
    font-size: 20px; /*original: 20px */
    text-align: center;
    -webkit-animation: mymove 3s infinite; /* Chrome, Safari, Opera 4s */
    animation: mymove 3s infinite;
}

@media (min-width:768px){	
.titledieutour {
  font-size: 2em;
	}
}

/* Chrome, Safari, Opera from {top: 0px;}
    to {top: 200px;}*/
@-webkit-keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

@keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.nhomhb_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
	}

	.nhomhb {
    background: #A9FFD0; /*#0073aa;*/
    color: #000; /* #fff;*/
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
	}

.hangban_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

	.hangban {
    background: #0073aa;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

#page-wrapper {
	margin: 0 0 0 0px !important;
}

aside.floating {
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999999;
    background-color: #395ca3;
    -webkit-box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    -moz-box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    box-shadow: 0 -1px 0 rgba(0,0,0,.2);
    font-size: 1.2em;
}
.cover {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}
aside.floating section.chatus, aside.floating section.inside > a {
    float: left;
    border-right: 1px dotted #ccc;
    vertical-align: middle;
    color: #fff;
    text-align: center;
    width: 20%;
    padding: 15px 0;
    cursor: pointer;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    position: relative;
}
aside.floating section.inside > a {
    font-size: 1em;
}

</style>
</head>
<body>
	<form method="post" action="checkout.php?ketthuc=1">
	<div class='container-fluid'>
	    <div class='row' style='padding-top:25px; padding-bottom:25px;'>
	        <div class='col-xs-12 col-xs-12 col-md-6 col-md-offset-3'>
	            <div id='mainContentWrapper'>
	               		<div class="btn btn-info" style="width : 100%;"><h2 style="text-align: left;"><a href="cart.php" style="color:#fff"><i class="fa fa-arrow-left"></i></a> Thanh Toán</h2></div>
	                    <hr/>

	                    <div class="panel-group" id="accordion">
	                        <div class="panel panel-default">
	                            <div class="panel-heading">
	                                <h4 class="panel-title">
	                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Chi tiết:</a>
	                                </h4>
	                            </div>
	                            <div id="collapseOne" class="panel-collapse collapse in">
	                                <div class="panel-body">

	                                    <div class="items">
	                                    	<div class="form-group">
		                                    	<div class="row ">
			                                        <div class="col-xs-12 col-md-6">
			                                            
			                                                          <b>  Phương thức</b>
			                                        </div>
			                                        <div class="col-xs-12 col-md-6" style="margin-top:10px">
			                                          	
	                                                      <form>
														    <label class="radio-inline">
														      <input type="radio" name="optradio" value="tienmat" checked >Tiền mặt
														    </label>
														    <label class="radio-inline">
														      <input type="radio" name="optradio" value="credit">Visa/CK
														    </label>
														  </form>
			                                                   
			                                        </div>
		                                    	</div>
	                                    	</div>
	                                    </div>

	                                    <div class="items">
	                                    	<div class="form-group">
		                                    	<div class="row">
				                                        <div class="col-xs-9 col-md-9">
		                                        			<b>Tồng tiền</b>
				                                        </div>
				                                        <div class="col-xs-3 col-md-3">
				                                          	 <span class="pull-right">
				                                                <?= number_format($tongtien);?></span>
				                                    	</div>
		                                    	</div>
		                                    </div>
		                                </div>

	                                    <div class="items">
											<div class="form-group">
		                                    	<div class="row" style="padding-bottom:5px;">
		                                       		<div class="col-xs-9 col-md-9">
			                                        	<b>
			                                            Giảm giá</b>
		                                        	</div>
			                                        <div class="col-xs-3 col-md-3 "style="border-bottom:2px solid #D4D0C8">
														<span class="pull-right">
			                                                           <?= number_format($tiengiamgia);?>
			                                            </span>
			                                        </div>

		                                    	</div>
	                                    	</div>
	                                    </div>
	                                	
	                                    <div class="items">
											<div class="form-group">
		                                    	<div class="row">
		                                       		<div class="col-xs-9 col-md-9">
			                                        	<b>
			                                           Khách cần trả</b>
		                                        	</div>
			                                        <div class="col-xs-3 col-md-3">
														<span class="pull-right">
				                                                <?= number_format($tienthuctra);?>
			                                            </span>
			                                        </div>
		                                    	</div>
	                                    	</div>
	                                    </div>
	                                    <div class="items ">
											<div class="form-group">
		                                    	<div class="row">
		                                       		<div class="col-xs-9 col-md-9">
			                                        	<b>
			                                           Tiền khách đưa</b>
		                                        	</div>
			                                        <div class="col-xs-3 col-md-3" style="border-bottom:2px solid #D4D0C8">
														<span class="pull-right">
				                                                <?= number_format($tienthuctra);?>
			                                            </span>
			                                        </div>
		                                    	</div>
	                                    	</div>
	                                    </div>
	         							<div class="items" align="center">
	         								<span><button type="submit" class="btn" style="color:red" name ="dongy" value="<?=$malichsuphieu?>">In & kết thúc</button></span>
	         							</div>
	                                    </div>
	                                </div>
	                            </div>
	                            
	                        </div>
	                    </div>
	   			</div>
	   		</div>
	   	</div>	
	</div>
</form>
<aside class="floating">
  <section class="inside cover">
        <a href="home.php" >
         Bán hàng</a>
        <a href="order.php" class="data-pa data-attr-content_600 hide_800" data-content_600="KD HN">
        Order món</a>
        <a href="orderKTV.php?malichsuphieu=<?php echo $malichsuphieu; ?>" class="data-pa data-attr-content_600 hide_900" data-content_600="KD HCM" >
        Chọn KTV</a>
        <a href="cart.php" class="data-pa data-attr-content_600 hide_800" data-content_600="KD HN">
        Hóa đơn</a>
        <a href="checkout.php" class="data-pa data-attr-content_600 hide_800" data-content_600="KD HN" title="Email">
        Thanh toán</a>
    </section>
</aside>
</body>

