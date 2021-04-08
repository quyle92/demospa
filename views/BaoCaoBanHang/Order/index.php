<?php 
require_once realpath(dirname(__FILE__,4) . '/vendor/autoload.php');

$conn = DBConnect();
use Lib\clsKhachHang;

$sgDep = new clsKhachHang($conn);
@session_start(); //session_destroy();

date_default_timezone_set('Asia/Bangkok');
$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);

$_SESSION['NhapMon'] = 1;

$manv = isset($_SESSION['MaNV']) ? $_SESSION['MaNV'] : '';
$tennv = isset($_SESSION['TenNV']) ? $_SESSION['TenNV'] : '';
$matrungtam = isset($_SESSION['Matrungtam']) ? $_SESSION['MaTrungTam'] : '';
$tentrungtam = isset($_SESSION['Tentrungtam']) ? $_SESSION['TenTrungTam'] : '';

//
//----------------------lấy các thông tin post, get -------------------//
//
//----------------------mã lịch sử phiếu, mã bàn --------------------------------------//
//
$malichsuphieu = ""; $makhachhang = ""; $tenkhachhang = ""; $mathevip = ""; $sodienthoai = ""; $diachi= "";
if(isset($_GET['malichsuphieu']))   //---trường hợp xử lý theo link phân trang hoặc từ home
{
  $malichsuphieu= $_GET['malichsuphieu'];
}

if(isset($_POST['malichsuphieu']) && $malichsuphieu == "") //trường hợp xử lý theo submit form chọn món
{
  $malichsuphieu= $_POST['malichsuphieu'];

}

if(isset($_SESSION['MaLichSuPhieu']) && $malichsuphieu == "") //lấy session nếu chưa có mã lịch sử phiếu
{
  unset($_SESSION['SoLuong']);
  unset($_SESSION['TenHangBan']);
  unset($_SESSION['MaDVT']);
  unset($_SESSION['Gia']);

  $malichsuphieu = $_SESSION['MaLichSuPhieu'];
}

if($malichsuphieu != "")
{
  $_SESSION['MaLichSuPhieu']= $malichsuphieu;     //-----luu lai session mới nhất MaLichSuPhieu

  //echo $malichsuphieu; ok
  // $rskh = $sgDep->getClientInfo_LSPhieu($malichsuphieu);
  // if($rskh != false)
  // {
  //   foreach($rskh as $rkh)
  //   {
  //     $rkh['MaKhachHang'];
  //     $rkh['TenKhachHang'];
  //     $rkh['DienThoai'];
  //     $rkh['DiaChi'];
  //     $rkh['MaTheVip'];

  //     $makhachhang = $rkh['MaKhachHang'];
  //     $tenkhachhang = $rkh['TenKhachHang'];
  //     $mathevip = $rkh['MaTheVip'];
  //     $sodienthoai = $rkh['DienThoai'];
  //     $diachi = $rkh['DiaChi'];
  //     //echo $makhachhang;
  //   }
  // }
}
//
//
$maban = "";
if(isset($_GET['maban']))               //----get gia tri tu home.php
{
  $maban = $_GET['maban'];
}
if(isset($_POST['maban']) && $maban == "")        //----lấy từ submit form
{
  $maban = $_POST['maban'];
} 
if(isset($_SESSION['MaBan']) && $maban == "")       // lấy từ session nếu chưa có mã bàn
{
  $maban = $_SESSION['MaBan'];
}

if($maban != "")
{
  $_SESSION['MaBan'] = $maban;            //-----lưu lai session ma ban mới nhất
}

if($maban==null or $maban=="")
{ 
?> 
  <script> 
    alert('chưa có thông tin phòng');
    setTimeout('window.location="home.php"',0);
  </script>
<?php
}
//
//--------------mã nhóm hàng, hàng bán -----------------------//
//
$manhomhangbanmoi =  ""; $manhomhangbancu = ""; $mahangban = ""; $mahangban_xoa = ""; 
$setmenu = 0; $themmonsetmenu = 0;
if(isset($_SESSION['ThemMonSetMenu']))
{
  $themmonsetmenu = $_SESSION['ThemMonSetMenu'];
}
else
{
  $_SESSION['ThemMonSetMenu'] = $themmonsetmenu;
}
//echo $themmonsetmenu;
//
//
if(isset($_GET['manhomhangban']))
{
  $manhomhangbanmoi = $_GET['manhomhangban']; //có click chọn nhóm hàng bán
}
if(isset($_POST['manhomhangban']))
{
  $manhomhangbanmoi = $_POST['manhomhangban']; //có click chọn nhóm hàng bán
}
if(isset($_SESSION['MaNhomHangBan']))
{
  $manhomhangbancu = $_SESSION['MaNhomHangBan'];
}
if($manhomhangbanmoi != "")
{
  $_SESSION['MaNhomHangBan'] = $manhomhangbanmoi;
}
else
{
  $manhomhangbanmoi = $manhomhangbancu;   // không thay đổi mã nhóm hàng bán
}
//
//----------------check có hàng bán -------------------//
//
if(isset($_GET['mahangban']))     //-----lay ma hang ban bang phuong thuc get order.php
{
  $mahangban = $_GET['mahangban'];
  
  $l_sql = "Select * from tblDMHangBan WHERE MaHangBan = '$mahangban'";
  $rs = $conn->query($l_sql)->fetchAll(\PDO::FETCH_ASSOC);
  foreach($rs as $r7)
  {
    $manhomhangbanmoi = $r7['MaNhomHangBan'];
    $setmenu = $r7['SetMenu'];
  }
}

if(isset($_POST['mahangban']))      //-----lay ma hang ban bang phuong thuc post order.php
{
  $mahangban = $_POST['mahangban'];
  
  $l_sql = "Select * from tblDMHangBan WHERE MaHangBan = '$mahangban'";
  $rs = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
  foreach($rs as $r7)
  {
    $manhomhangbanmoi = $r7['MaNhomHangBan'];
    $setmenu = $r7['SetMenu'];
  }
}
//
//  lưu lại session khi có click hang bán
//
if($mahangban != null && $mahangban != "")
{
  $_SESSION['MaNhomHangBan'] = $manhomhangbanmoi;
  $_SESSION['MaHangBan'] = $mahangban;
}
//
//------------xử lý mã hàng bán xóa khỏi danh sách: order_remove_selected.php ------------//
//
if(isset($_GET['mahangban_xoa']))
{
  $mahangban_xoa = $_GET['mahangban_xoa'];
}
//
//--------------xu ly action cho viec xu ly trong page order.php ------------//
//        action: add, update, delete
$action = "";
if(isset($_GET['action']))
{
  $action=$_GET['action'];
}

if ($action=="remove" && $mahangban_xoa != "") 
{
  unset($_SESSION['SoLuong'][$mahangban_xoa]);
  unset($_SESSION['TenHangBan'][$mahangban_xoa]);
  unset($_SESSION['MaDVT'][$mahangban_xoa]);
  unset($_SESSION['Gia'][$mahangban_xoa]);
}

if ($action=="remove-all") 
{ 
  unset($_SESSION['SoLuong']);
  unset($_SESSION['TenHangBan']);
  unset($_SESSION['MaDVT']);
  unset($_SESSION['Gia']);
}
//-------------------xu ly in phieu tu dong order.php ------------------//
$inphieu = 0;
if(isset($_GET['inphieu']))
{
  $inphieu=$_GET['inphieu']; $idorder = "";
  if($inphieu == 1)
  {
    if($malichsuphieu != "")
    {
      $coorder = 0;
      $inbep_mahangban = ""; $inbep_mabep = ""; $inbep_orderid = ""; $inbep_soluong = 1;
      $inbep_tenhangban = ""; $inbep_madvt = ""; $inbep_sophut = 0; $inbep_dongia = 0;
      $inbep_ktv = "";
      //
      //----lay thong tin order có mã bếp
      //
      $sql = "Select a.*, b.MaBep, b.ThoiGianLam, c.NVPhucVu from tblOrderChiTiet a Inner join (select MaBep, f.MaHangBan, ISNULL(f.ThoiGianLam,0) as ThoiGianLam from tblDMKhu_Kho e, tblDMHangBan f Where e.NhomHang = f.MaNhomHangBan and e.NhomHang in ('NN001','NN001B') Group by MaBep,f.MaHangBan,f.ThoiGianLam) b On a.MaHangBan = b.MaHangBan Inner join (Select g.OrderID, h.NVPhucVu from tblLSPhieu_HangBan g, tblLichSuPhieu h where g.MaLichSuPhieu = h.MaLichSuPhieu and g.MaLichSuPhieu like '$malichsuphieu') c On a.OrderID = c.OrderID Order by a.OrderID desc";
      try
        {
        $rs = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
            if($rs != false)
            {
              foreach($rs as $r)
              {
                $coorder = 1;

                  $r['MaHangBan'];
                  $r['MaBep'];
                  $r['OrderID'];
                  $r['SoLuong'];
                  $r['TenHangBan'];
                  $r['MaDVT'];
                  $r['ThoiGianLam'];
                  $r['DonGia'];
                  $r['NVPhucVu'];

                  $idorder = $malichsuphieu."-".$r['OrderID']."-".$r['MaHangBan']."-".$r['MaBep'];
                  $inbep_mahangban = $r['MaHangBan'];
                  $inbep_mabep = $r['MaBep'];
                  $inbep_orderid = $r['OrderID'];
                  $inbep_soluong = $r['SoLuong'];
                  $inbep_tenhangban = $r['TenHangBan'];
                  $inbep_madvt = $r['MaDVT'];
                  $inbep_sophut = $r['ThoiGianLam'];
                  $inbep_dongia = $r['DonGia'];
                  $inbep_ktv = $r['NVPhucVu'];

                  $timestamptemp = date('Y-m-d H:i');
              $timestemptemp1 = $timestamptemp." + ".$inbep_sophut." minute"; 
              $inbep_thoigianketthuc = strtotime($timestemptemp1);

                  $sql1 = "Insert into tblYeuCauBep(ID,MaBep,MaLichSuPhieu,MaHangBan,SoLuong,NgayGio,TinhTrang,TenHangBan,MaDVT,OrderID,DaIn,SoLanIn,ThoiGianLamXong) values('$idorder','$inbep_mabep','$malichsuphieu','$inbep_mahangban','$inbep_soluong','".date('Y-m-d H:i:s')."','1',N'$inbep_tenhangban','$inbep_madvt','$inbep_orderid','0','0','".date('Y-m-d H:i:s',$inbep_thoigianketthuc)."')";
                  // echo "sql1:".$sql1; -> insert ok
                  $rs_1 = $conn->query($sql1);

                  $sql2 = "Insert into tblYeuCauBepIn_Pocket(ID,MaLichSuPhieu,MaBan,MaHangBan,TenHangBan,SoLuong,MaDVT,MaBep,YeuCauThem,NgayGio,OrderID,DonGia) values('$idorder','$malichsuphieu','$maban','$inbep_mahangban',N'$inbep_tenhangban','$inbep_soluong','$inbep_madvt','$inbep_mabep','$inbep_ktv','".date('Y-d-m H:i:s')."','$inbep_orderid','$inbep_dongia')";
                  //echo "sql2:".$sql2; -> insert ok
                  $rs_2 = $conn->query($sql2);
              }
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        //
        //--------ko có order và mã hàng bán --------//
        //
        if($coorder == 0 && $mahangban != "")
        {
          
        }
      //
      //----xu ly update gio lam
      //
      if($inbep_sophut > 0 && $inbep_mahangban != "")
      {
        $sql = "Update tblLichSuPhieu set MaDichVuDieuTour = '$inbep_mahangban',DichVuDieuTour=N'$inbep_tenhangban',ThoiGianLam = '$inbep_sophut',GioVao = '".date('Y-m-d H:i:s')."',GioTra='".date('Y-m-d H:i:s',$inbep_thoigianketthuc)."' Where MaLichSuPhieu = '$malichsuphieu'";
        $rs_1 = $conn->query($sql);
      }
    }//end if co ma lich su phieu
  }
}

//-------------------xu ly in phieu tu dong order.php ------------------//
$inbill = 0;
if(isset($_GET['inbill']))
{
  $inbill=$_GET['inbill']; 
  if($inbill == 1)
  {
    if($malichsuphieu != "")
    {
      $sql = "Insert into tblOrder_InPhieuTinhTien(MaNV, ThoiGianIn, MaLichSuPhieu, TinhTrangIn) values('$manv','".date('Y-m-d H:i:s')."','$malichsuphieu','0')";
      $rs_1 = $conn->query($sql);
    }
  }
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Điều tour KTV</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa-Clinic ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- Custom CSS -->
<link href="<?=BASE_URL?>css/style1.css" rel='stylesheet' type='text/css' />
<link href="<?=BASE_URL?>css/q_style.css" rel='stylesheet' type='text/css' />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet"> 
<link href="<?=BASE_URL?>css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="<?=BASE_URL?>css/custom.css" rel="stylesheet">

<!-- Font-awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet"> 

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<!-- Custom JavaScript -->
<script src="<?=BASE_URL?>js/custom.js"></script>

<!-- Bootstrap Core JavaScript -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<!--  ChartJS   -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<!-- DataLabels plugin --> 
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script> 

<!-- DataTable --> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


<!-- iOS toggle -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>

<!-- Boostrap Datetimepicker CSS + JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css">

<!-- Boostrap Timepicker CSS + JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg==" crossorigin="anonymous" />
<script>
  $(document).ready(function () {
    // $.noConflict();
    //   $('select').selectize({
    //       sortField: 'text'
    //   });

  });
</script>
<style> 
.form-group label[for="vip"] + div {
  left: 80px;
}
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
/*.active {
  background-color: green;
  color: white;
}*/

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

/*quy css*/
@media (min-width:1024px){
  .col-md-8 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr !important;
    box-sizing: border-box;
    grid-row-gap: 7px;
  }
}

@media (min-width:600px) and (max-width: 1024px) {
   .col-md-8 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr !important;
    box-sizing: border-box;
    grid-row-gap: 7px;
  }
}

@media (max-width:600px){
   .col-md-8 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr !important;
    box-sizing: border-box;
    grid-row-gap: 5px;
  }
}

</style>
</head>
<body>
<div id="wrapper">
  <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand"><?php echo $tentrungtam; ?></a> 
    </div>
  </nav>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
  <div class="xs">
        <div class="row">
          <div class="col-sm-6 col-md-8" style="margin-bottom:5px">
<?php
      if($malichsuphieu != null && $malichsuphieu != "")
      {
?>      
      <h4>Bàn: <?=$maban?> - Hóa đơn: <?=$malichsuphieu?></h4>
<?php
      }
      else
      {
?>
      <h4>NHÓM HÀNG BÁN</h4>
<?php 
      }
?>
      <form action="order.php" method="post">
        <div class="grid">
<?php 
/*code để lấy total page*/
  if (isset($_GET['pageno_nhb'])) {
     $pageno_nhb = $_GET['pageno_nhb'];
  } else {
    $pageno_nhb = 1;
  }
  $no_of_records_per_page = 12;//6;
  $startRowNhomHB = ($pageno_nhb-1) * $no_of_records_per_page;
  $endpoint = $startRowNhomHB + $no_of_records_per_page;
  $total_pages = 3;
/*End code để lấy total page*/
  //
  //------------------------------danh sách nhóm hàng ----------------------//
  //
  $l_sql="select * from (SELECT *, ROW_NUMBER() OVER (ORDER BY ThuTuTrinhBay) as rowNum FROM tblDMNhomHangBan Where Ma in ('NN001','NN001B')) sub WHERE rowNum >  '$startRowNhomHB' and rowNum <= '$endpoint'"; 
  try
  {
    $rs = $conn->query($l_sql)->fetchAll(\PDO::FETCH_ASSOC);
    if(($rs) != false)
    {
      foreach($rs as $r1)
      {
        if($manhomhangbanmoi == "")
          $manhomhangbanmoi = $r1['Ma'];

        if($manhomhangbanmoi == $r1['Ma'])
        {
?>    
          <button type="submit" name="manhomhangban" value="<?php echo $r1['Ma']; ?>" class="nhomhb_active"><?php echo $r1['Ten']; ?></button>
<?php
        }
        else
        {
?>        
          <button type="submit" name="manhomhangban" value="<?php echo $r1['Ma']; ?>" class="nhomhb"><?php echo $r1['Ten']; ?></button>
<?php
        }
      }
    }//end if co ds nhom hang ban
  }
  catch (Exception $e) {
    echo $e->getMessage();
  }
?>
        </div>
        </form>

<!----------------------HÀNG BÁN ---------------------------------------------->
    <h4 style="margin: 20px 0;">HÀNG BÁN</h4> 
      <form action="order.php" method="get">
      <div class="grid" style="margin-left: -10px;">    
<?php
  if (isset($_GET['pageno'])) 
  {
     $pageno = $_GET['pageno'];
  } 
  else 
  {
    $pageno = 1;
  }
  
  $no_of_records_per_page = 25;// 12;//6;
  $startRowHB = ($pageno-1) * $no_of_records_per_page;
  $endpoint = $startRowHB + $no_of_records_per_page;
          
  $total_pages_sql = "select  COUNT(*) from tblDMHangBan  Where MaNhomHangBan = '$manhomhangbanmoi'";
  try
  {
    $total_rows=$conn->query($total_pages_sql)->fetchColumn();
    $total_pages = ceil($total_rows / $no_of_records_per_page);
  }
  catch (Exception $e) 
  {
    echo $e->getMessage();
  }
  //       
  $sql="select MaHangBan, TenHangBan,MaNhomHangBan from (SELECT *, ROW_NUMBER() OVER (ORDER BY ThuTuTrinhBay) as rowNum FROM tblDMHangBan   Where MaNhomHangBan = '$manhomhangbanmoi') sub WHERE rowNum > '$startRowHB' and rowNum <= '$endpoint'";
  try
  {
    $rs = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    $i = 1;
    foreach($rs as $r2)
    {
      if($mahangban == $r2['MaHangBan'])
      { 
?>
        <button type="submit" name="mahangban" value="<?php echo $r2['MaHangBan']; ?>" class="hangban_active"><span><?php echo $r2['TenHangBan']; ?></span></button>
<?php
      }
      else
      { 
?>
        <button type="submit" name="mahangban" value="<?php echo $r2['MaHangBan']; ?>" class="hangban"><span><?php echo $r2['TenHangBan']; ?></span></button>
<?php
      }
    }//end while duyet danh sach hang ban
    

  }
  catch (Exception $e) {
    echo $e->getMessage();
  }       
?>
      </div>  
      </form>
<!-- ----------------------Begin Pagination cho hang ban ---------------------->
    <ul class="pagination">
          <li><a href="?pageno=1&manhomhangban=<?=$manhomhangbanmoi?>">First</a></li>
          <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo '?pageno='.($pageno - 1).'&manhomhangban='.$manhomhangbanmoi; } ?>">Prev</a>
          </li>
<?php
  $from=$pageno-3;
  $to=$pageno+3;
  if ($from<=0) $from=1;  $to=3*5;
  if ($to>$total_pages) $to=$total_pages;
  for ($j=$from;$j<=$to;$j++) 
  {
    if ($j==$pageno) 
    { 
?>
      <li class='active'><a href='order.php?pageno=<?=$j?>&manhomhangban=<?=$manhomhangbanmoi?>'><?=$j?></a></li>
<?php 
    } 
    else 
    { 
?>
      <li class=''><a href='order.php?pageno=<?=$j?>&manhomhangban=<?=$manhomhangbanmoi?>'><?=$j?></a></li>
<?php 
    }
  }//end for duyet paging
?>
          <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).'&manhomhangban='.$manhomhangbanmoi; } ?>">Next</a>
          </li>
          <li><a href="?pageno=<?php echo $total_pages.'&manhomhangban='.$manhomhangbanmoi ?>">Last</a></li>
      </ul>
<!-- ------End Pagination cho hang ban ------------------------------------>
    </div>
<!-------------------Xu ly form Order Review ------------------------------>
    
    <div class="col-sm-6 col-md-4" style="margin-bottom:5px">
<!-----------------------------SHIPPING METHOD ---------------------------->
<?php require('../Order/order/tab_client_card.php'); ?>
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          <h4>Danh sách dịch vụ</h4>
        </div>
        <div class="panel-body" style="padding: 2px;">
            <table class="table borderless">
          <form method="post" action="order.php?action=update">
            <tbody>
            <tr>
              <td class="text-center">
                <button type="submit" class="btn btn-warning"  formaction="order_remove_selected.php" name="malichsuphieu" value="<?=$malichsuphieu?>">
                  <i class="fa fa-trash-o"></i>
                  <input type="hidden" name="maban" value="<?=$maban;?>" />
                </button>
                <input type="checkbox" id="checkAll">
              </td>
              <td class="col-md-12">Sản Phẩm</td>
              <td class="text-center soluong">SL</td>
              <td class="text-center"></td>
              <td class="text-right"></td>
            </tr>
<!-- ---------------hien thi danh sach hang ban trong lich su phieu ---------------- -->
<?php
  $tenhangban = ""; $giaban = 0; $soluong = 1;
  //
  /*loại bỏ null array element*/
  //if(isset($_SESSION['Gia']))
  //{
  //  foreach ($_SESSION['Gia'] as $mahangban => $gia) 
  //  {
  //    if ( $gia == null) 
  //    {
    //      unset ($_SESSION['TenHangBan'][$mahangban]);
    //      unset ($_SESSION['MaDVT'][$mahangban]);
    //      unset ($_SESSION['SoLuong'][$mahangban]);
  //      unset ($_SESSION['Gia'][$mahangban]);
  //    }
  //  }
  //}
  /*End loại bỏ null array element*/

  if(!isset($_SESSION['TenHangBan'])) 
  {
    $_SESSION['TenHangBan']=array(); 
  }
  
  if(!isset($_SESSION['MaDVT'])) 
  {
    $_SESSION['MaDVT']=array(); 
  }

  if(!isset($_SESSION['Gia']))
  {
    $_SESSION['Gia']=array();
  }
    
  if(!isset($_SESSION['SoLuong']))
  {
    $_SESSION['SoLuong']=array();
  }
  //
  //--------xử lý truon hợp thêm sản phẩm----------//
  //
  if(isset($_SESSION['MaHangBan']))
  {
    $mahangban = $_SESSION['MaHangBan'];
  }
  //echo $mahangban;
  $mahangbantemp = "";
  if ($mahangban != "" && $action!="update" and $action!="remove")//-- dang chon mon ok
  {
    if (!array_key_exists($mahangban,$_SESSION['TenHangBan']))//---kiểm tra có key chưa ?
    {
      $l_sql = "Select a.*, b.Gia from tblDMHangBan a, tblGiaBanHang b Where a.MaHangBan = b.MaHangBan and a.MaHangBan = '$mahangban'";
      $rs = $conn->query($sql);
      $r3 = $rs->fetch(\PDO::FETCH_ASSOC);
      
      if($themmonsetmenu == 0)
      {
        $_SESSION['TenHangBan'][$mahangban]=$r3['TenHangBan'];
      }
      else
      {
        $_SESSION['TenHangBan'][$mahangban]="#Set#".$r3['TenHangBan'];
      }
      $_SESSION['MaDVT'][$mahangban]=$r3['MaDVTCoBan'];
      $_SESSION['Gia'][$mahangban]=$r3['Gia'];
      $_SESSION['SoLuong'][$mahangban]=1;
      $setmenu = $r3['SetMenu'];
      
      if($setmenu == 1)
      {
        $l_sql = "Select a.*,b.TenHangBan, b.MaDVTCoBan from tblDMHangBan_Setmenu a, tblDMHangBan b where a.MaHangBan = b.MaHangBan and a.MaHangBanSetMenu = '$mahangban' and a.MacDinh = 1";
        $rs = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        if(($rs) !== false)
        {
          foreach($rs as $r3)
          {
            $r3["SoLuong"];

            $mahangbantemp = $r3['MaHangBan'];
      
            $_SESSION['TenHangBan'][$mahangbantemp]="#Set#".$r3['TenHangBan'];
            $_SESSION['MaDVT'][$mahangbantemp]=$r3['MaDVTCoBan'];
            $_SESSION['Gia'][$mahangbantemp]=0;
            $_SESSION['SoLuong'][$mahangbantemp]=intval($r3['SoLuong']);
          }
        }

      }//end if co set menu
    }
  }
  //
  //--------xử lý action update giỏ hàng: not use ----------------------//
  //
  if ($action=="update") 
  {
    ( $soluong_arr =$_POST['soluong_arr'] );
    ( $mahangban_arr=$_POST['mahangban_arr'] ); 

    count($_POST['mahangban_arr']);
    echo "sl hang update:".count($_POST['mahangban_arr']);
    
    for ($i=0;$i<count($_POST['mahangban_arr']);$i++) 
    {
      "<br>".$soluong=$soluong_arr[$i];
      settype($soluong,'int'); 
      if ($soluong==0) continue;
      "<br>".$mahangban=$mahangban_arr[$i];
      settype($mahangban,'int');
      if ($mahangban<=0) continue;
        
      $l_sql_update = "Select a.*, b.Gia from tblDMHangBan a, tblGiaBanHang b Where a.MaHangBan = b.MaHangBan and a.MaHangBan = '$mahangban'";
      $r4 = $conn->query($sql)->fetch();
        
      $_SESSION['TenHangBan'][$mahangban]=$r4['TenHangBan'];
      $_SESSION['MaDVT'][$mahangban]=$r4['MaDVTCoBan'];
      ($_SESSION['Gia'][$mahangban]=$r4['Gia']);
      ($_SESSION['SoLuong'][$mahangban]=$soluong); 

    }
  }
  ////////////////////////////////////////////////////////////
  //
  //-------trường hợp không có chọn hoặc remove món: load từ danh sách lịch sử phiếu //
  //
  if ($mahangban == "" && $mahangban_xoa == "" && $malichsuphieu!= null && $malichsuphieu!= "")
  {
    $sql="SELECT MaLichSuPhieu, MaHangBan, TenHangBan, MaDVT, DonGia, Sum(SoLuong) as SoLuong, Sum(ThanhTien) as ThanhTien from [tblLSPhieu_HangBan] Where Malichsuphieu like '$malichsuphieu' group by MaLichsuphieu, MaHangBan, TenHangBan, MaDVT, DonGia having sum(SoLuong) > 0 Order by Min(ThoiGianBan)";
    //echo $sql;
    $rs = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    foreach($rs as $r)
    {
      $r["SoLuong"];
      $r["ThanhTien"];

      $mahangban=$r['MaHangBan'];
      
      $_SESSION['TenHangBan'][$mahangban]=$r['TenHangBan'];
      $_SESSION['MaDVT'][$mahangban]=$r['MaDVT'];
      $_SESSION['Gia'][$mahangban]=$r['DonGia'];
      $_SESSION['SoLuong'][$mahangban]=intval($r['SoLuong']);
    }
  }
    
  /*this is to avoid empty arra element*/
  if (array_key_exists("",$_SESSION['TenHangBan'])) 
  {
    unset($_SESSION['TenHangBan'][""]);
  }

  if (array_key_exists("",$_SESSION['MaDVT'])) 
  {
    unset($_SESSION['MaDVT'][""]);
  }

  if (array_key_exists("",$_SESSION['SoLuong'])) 
  {
    unset($_SESSION['SoLuong'][""]);
  }
    
  if (array_key_exists("",$_SESSION['Gia'])) 
  {
    unset($_SESSION['Gia'][""]);
  }
  /*end of this is to avoid empty arra element*/
    
  ($_SESSION['TenHangBan']);
  ($_SESSION['MaDVT']);
  ($_SESSION['SoLuong']);
  ($_SESSION['Gia']);
  
  reset($_SESSION['TenHangBan']);
  reset($_SESSION['MaDVT']);
  reset($_SESSION['Gia']);
  reset($_SESSION['SoLuong']);  

  $tien = 0; $tongtien = 0; $tongsoluong = 0;
  for ($i = 0; $i< count($_SESSION['TenHangBan']) ; $i++)
  { 
    ($mahangban=key($_SESSION['TenHangBan']) ); //echo $mahangban; hiện mã hàng bán ok nè
    ($madvt=current($_SESSION['MaDVT']) );
    ($tenHB=current($_SESSION['TenHangBan']) );
    ($giaHB=current($_SESSION['Gia']));
    $soluong=current($_SESSION['SoLuong']);
    //
    //
    $tien = $soluong*$giaHB;
    $tongtien = $tongtien + $tien;
    $tongsoluong = $tongsoluong + $soluong;
      
    if ($tenHB!="")
    {
?>
        <tr>
          <td class="text-center">
            <input type="checkbox" name="id_arr[]" id="idhangban" value="<?=$mahangban?>" />
          </td>
          <td class="col-md-12">
            <div class="media">
           <!--<a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://lorempixel.com/460/250/" style="width: 72px; height: 72px;"> </a>-->
              <div class="media-body">
                <h5 class="media-heading"><?=$tenHB?></h5>
                <!--<h5 class="media-heading">-<?=$mahangban?></h5> -->
              </div>
            </div>
          </td>
          <td class="text-right soluong">
              <div class="numbers-row" style="display: flex;">
              <button type="button" class="btn btn-danger btn-number" value="-" style="height: 34px;">
                <i class="fa fa-minus" aria-hidden="true"></i>
              </button>
              <input type="text" name="soluong_arr[]" class="form-control input-number" value="<?=$soluong?>" oninput="validity.valid||(value='1');" style="border:1px solid #808080!important; border-radius:0px!important;width:40px"/>
        
              <button type="button" class="btn btn-success btn-number"  value="+"  style="height: 34px;">
                <i class="fa fa-plus" aria-hidden="true"></i>
              </button>
              <input type="text" name="thanhtien_arr[]" class="form-control input-thanhtien-number" value="<?=number_format($tien,0,",",".")?>" oninput="validity.valid||(value='0');" style="border:0px solid #808080!important; border-radius:0px!important;width:80px"/>
              <input type="hidden" value="<?=$mahangban?>" name="mahangban_arr[]" class="input-mahangban" />
            </div>
          </td>
          <td class="text-left"></td>
          <td class="text-left"></td>
        </tr>
<?php 
    }//end if co hang ban

    next($_SESSION['TenHangBan']);
    next($_SESSION['MaDVT']);
    next($_SESSION['Gia']);
    next($_SESSION['SoLuong']);
  }//end for duyet danh sach ten hang ban
?>
        <tr>
          <td class="text-center"></td>
          <td class="col-md-12">
            <div class="media">
              <div class="media-body">
                <h5 class="media-heading">Tổng cộng</h5>
              </div>
            </div>
          </td>
<?php
  /*this is to avoid empty array element*/
  if (array_key_exists("",$_SESSION['SoLuong'])) 
  {
    unset($_SESSION['SoLuong'][""]);
  }
  
  if (array_key_exists("",$_SESSION['TenHangBan'])) 
  {
    unset($_SESSION['TenHangBan'][""]);
  }

  if (array_key_exists("",$_SESSION['MaDVT'])) 
  {
    unset($_SESSION['MaDVT'][""]);
  }
  
  if (array_key_exists("",$_SESSION['Gia'])) 
  {
    unset($_SESSION['Gia'][""]);
  }
  
  foreach ( $_SESSION['TenHangBan'] as $id => $ten )
  {
      if ( $ten ==null)
      {
          unset($_SESSION['TenHangBan'][$id]);
          unset($_SESSION['MaDVT'][$id]);
          unset ($_SESSION['SoLuong'][$id]);
          unset($_SESSION['Gia'][$id]);
      }
  }
?>
          <td class="text-center">
            <div class="numbers-row"  style="display: flex;">
              <input type="text" id="tongsoluong" name="tongsoluong" class="form-control input-tongsoluong-number" value="<?=number_format($tongsoluong,0,",",".")?>" oninput="validity.valid||(value='0');" style="border:0px solid #808080!important; border-radius:0px!important;width:60px"/>
              <input type="text" id="tongtien" name="tongtien" class="form-control input-tongtien-number" value="<?=number_format($tongtien,0,",",".")?>" oninput="validity.valid||(value='0');" style="border:0px solid #808080!important; border-radius:0px!important;width:80px"/>
            </div>
          </td>
          <td class="text-center tien"></td>
          <td class="text-right"></td>
        </tr>
        <tr>
          <td class="text-right"></td>
          <td class="text-center"></td>
          <td class="text-center">
            <div class="numbers-row"  style="display: flex; letter-spacing: 5px !important;">
              <span><button type="submit" class="btn" style="color:red" name ="xacnhan" value="<?=$malichsuphieu?>" formaction="order_confirm.php?malichsuphieu=<?=$malichsuphieu?>&order=1">Xác nhận</button></span>
              <span style="margin-left: 10px !important;"><button type="submit" class="btn btn-info" name="malichsuphieu" value="<?=$malichsuphieu;?>"><i class="fa fa-refresh"></i>
              </button></span>
            </div>
          </td>
          <td class="text-center"></td>
          <td class="text-right"></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td><div id="ketqua"></div></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
      </form>
      </table>
    </div>
    </div>
<!----------------------END SHIPPING METHOD END-------------------------->
    </div>
<!----------------------End of Order Review Form------------------------->
      </div>
  </div>   
  <!-- /div class="xs" -->
    </div>
  <!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
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
<!-- Metis Menu Plugin JavaScript -->

<script src="js/custom.js"></script>

<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
});
</script>
<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
  $(".btn-number").on("click", function() {

    var $button = $(this);
    var mahangban = $button.parent().find(".input-mahangban").val();
    //alert("ma hang" + mahangban); //ok
    var soluong_oldValue =  $button.parent().find(".input-number").val();
    var thanhtien_oldValue_str = $button.parent().find(".input-thanhtien-number").val();
    thanhtien_oldValue_str = thanhtien_oldValue_str.replace('.','');
    var thanhtien_oldValue = parseFloat(thanhtien_oldValue_str);

    if  ($button.val() == "+" ) {
      var soluong_newVal = parseFloat(soluong_oldValue) + 1;
    } else {
     
        var soluong_newVal = parseFloat(soluong_oldValue) - 1;
     
   }
  if(soluong_newVal < 1)
      var soluong_newVal = 1;

    var dongia = parseFloat(thanhtien_oldValue/soluong_oldValue);
    var thanhtien_newVal = parseFloat(soluong_newVal)*dongia;
    var thanhtien_newVal_str = thanhtien_newVal.toString();
    //
    // ---------convert to string with thousand seperator
    //var len = newVal_ThanhTien_str.length; 
    //var c = parseInt(len/3);
    //if(c == 1)
    //  newVal_ThanhTien_str = newVal_ThanhTien_str.substring(0,len-3) + '.' + newVal_ThanhTien_str.substring(len-3,3);
    //----------tong tien--------//
    var tongtienObj = document.getElementById("tongtien");
    var tongtien_oldvalue_str = document.getElementById("tongtien").value; //--ok
    var tongtien_oldvalue = parseFloat(tongtien_oldvalue_str.replace('.',''));
    var tongTien_newvalue = tongtien_oldvalue + thanhtien_newVal - thanhtien_oldValue;
    //alert(newTongTien); //--ok
    //----------so luong --------//
    var tongsoluongObj = document.getElementById("tongsoluong");
    var tongsoluong_oldvalue_str = document.getElementById("tongsoluong").value; //--ok
    var tongsoluong_oldvalue = parseFloat(tongsoluong_oldvalue_str.replace('.',''));
    var tongsoluong_newvalue = tongsoluong_oldvalue + soluong_newVal - soluong_oldValue;

    //
    //----------set value to html object ----------//
    //
    $button.parent().find(".input-number").val(soluong_newVal);
    $button.parent().find(".input-thanhtien-number").val(thanhtien_newVal);
    tongtienObj.value = tongTien_newvalue;  //--ok
    tongsoluongObj.value = tongsoluong_newvalue;
    //
    // ajax: ok
    //
    var ajaxurl = 'order_update.php',
        data =  {'mahangban': mahangban, 'soluong': soluong_newVal};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            document.getElementById("ketqua").innerHTML=response;
            //alert("Cap nhat Order Thanh Cong !");
        });
  });
</script>
<script>
    $("#checkAll").click(function () {
     $('input:checkbox').prop('checked', this.checked);
     var selectitem = 0;
    //if($('input:checkbox').is(':checked'))
    //{
    //  selectitem = 1;
      alert("checked"); //ok
    //}
    //else
    //{
    //  selectitem =0;
    //  alert("uncheck"); //ok
    //}
    //
    // ajax: ok
    //
    //var ajaxurl = 'order_setmenu.php',
    //    data =  {'themsetmenu': themsetmenu};
    //    $.post(ajaxurl, data, function (response) {
    //    });
 });
</script>
<script>
  $('input:checkbox').click(function () {
    var checkedValues = [];
    var selectitem = 0;
  if($('input:checkbox').is(':checked'))
  {
    checkedValues.push($(this).val());
    selectitem = 1;
  }
    //
    // ajax: ok
    //
    if(selectitem == 1)
    {
      //alert(checkedValues[0]); //ok
      var ajaxurl = 'orderKTV_item.php',
        data =  {'danhsachhangban': checkedValues};
        $.post(ajaxurl, data, function (response) {
        });
  }
 });
</script>
<script>
  $("#checkThemMonSetMenu").click(function () {
    var themsetmenu = 0;
    //var $themmon = document.getElementById("checkThemMonSetMenu"); //--on
    if($('input:checkbox').is(':checked'))
    {
      themsetmenu = 1;
      //alert("checked"); //ok
    }
    else
    {
      themsetmenu =0;
      //alert("uncheck"); //ok
    }
    //
    // ajax: ok
    //
    var ajaxurl = 'order_setmenu.php',
        data =  {'themsetmenu': themsetmenu};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            //document.getElementById("ketqua").innerHTML=response;
            //alert("Cap nhat Order Thanh Cong !");
        });
 });
</script>
<script>
  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */

</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
</body>
</html>
