<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();

date_default_timezone_set('Asia/Bangkok');

$maban = "";
if(isset($_SESSION['MaBan']))
{
  $maban = $_SESSION['MaBan'];
}

if($maban==null or $maban=="")
{
?> 
  <script> 
    alert('chưa có thông tin phòng');
    setTimeout('window.location="order.php"',0);
  </script>
<?php
}
//
//
$malichsuphieu = "";
if(isset($_GET['malichsuphieu'])) //------lấy giá trị từ order.php
{
  $malichsuphieu = $_SESSION['MaLichSuPhieu'];
}

if($malichsuphieu == "")
{
?> 
  <script> 
    alert('Bạn cần xác nhận dịch vụ để điều tour !');
    setTimeout('window.location="order.php"',0);
  </script>
<?php
}
//
//
$madichvu = "";
$sql = "Select MaHangBan from tblLSPhieu_HangBan where MaLichSuPhieu like '$malichsuphieu' group by MaHangBan having sum(SoLuong) > 0";
try
{
      $rs=sqlsrv_query($conn,$sql);
      if($rs != false)
      {
        while($r=sqlsrv_fetch_array($rs))
        {
            $r['MaHangBan'];
            $madichvu = $r['MaHangBan'];
        }
      }
}
catch (Exception $e) {
        echo $e->getMessage();
}

if(isset($_SESSION['MaHangBan'])) //-----lay từ order.php
{
  if($_SESSION['MaHangBan'] != "" && $_SESSION['MaHangBan'] != null)
  {
    $madichvu = $_SESSION['MaHangBan'];
  }
}
else if(isset($_GET['madichvu'])) //------lấy giá trị chính orderKTV.php
{
  $madichvu = $_GET['madichvu'];
}

if($madichvu==null or $madichvu=="")
{
?> 
  <script> 
    alert('Bạn cần chọn dịch vụ để điều tour !');
    setTimeout('window.location="order.php"',0);
  </script>
<?php
}

$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
$tencashier = $_SESSION['TenNV'];

$ngay = date("d");
$thang = date("m");
$nam = date("Y");

$zoom = "0"; $maktvmoi = ""; $tenktvmoi = ""; $tenktvcu = ""; $ghichu = ""; $tenhinh = ""; $sourcehinh = "";
$tendichvu = "";
if(@$_GET['zoom'] != null)
{
  $zoom = @$_GET['zoom'];
}
else 
{
  $zoom = "0";
}

if(@$_GET['maktv'] != null)
{
  $maktvmoi = @$_GET['maktv'];
  if($maktvmoi != "")
  {
    $l_sql="select * from tblDMNhanVien Where MaNV like '$maktvmoi'";
    try
    {
      $rs=sqlsrv_query($conn,$l_sql);
      if($rs != false)
      {
        while($r=sqlsrv_fetch_array($rs))
        {
            $r['MaNV'];
            $r['TenNV'];
            $r['GhiChuNV'];
            $r['HinhAnhTemp'];
            $r['SourceHinhAnh'];

            $tenktvmoi = $r['TenNV'];
            $ghichu = $r['GhiChuNV'];
            $tenhinh = $r['HinhAnhTemp'];
            $sourcehinh = $r['SourceHinhAnh'];
        }
      }
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
  }
}
else 
{
  $maktvmoi = "";
}
    //
    //
    $sophut = 0; $tendichvu = "";
    $sql = "Select * from tblDMHangBan Where MaHangBan like '$madichvu'";
    try
    {
      $rs=sqlsrv_query($conn,$sql);
      if($rs != false)
      {
        while($r=sqlsrv_fetch_array($rs))
        {
            $r['MaHangBan']; 
            $r['TenHangBan'];
            $r['ThoiGianLam'];
            $tendichvu = $r['TenHangBan'];
            $sophut = $r['ThoiGianLam'];
        }
      }
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

$chon = 0; $maktvcu = "";
if(isset($_GET['chon']) && $maktvmoi != "")
{
  $chon = $_GET['chon']; $flagDoiKTV = 0; 
  if($chon == 1)
  {
    //xu ly dieu tour
    // kiem tra phong hien tai co ktv ko ? 
    $sql = "Select * from tblTheoDoiPhucVuSpa_ChiTiet Where MaBanPhong like '$maban' and MaPhieuDieuTour in (Select MaLichSuPhieu from tblLichSuPhieu Where DangNgoi = 1 and DaTinhTien = 0 and ThoiGianDongPhieu is null)";
    try
    {
      $rs=sqlsrv_query($conn,$sql);
      if($rs != false)
      {
        while($r=sqlsrv_fetch_array($rs))
        {
            $r['MaNV']; 
            $r['TenNV'];
            $maktvcu = $r['MaNV'];
            $tenktvcu = $r['TenNV'];

            if($maktvmoi == $maktvcu)
            {
              $flagDoiKTV = 0; //không đổi ktv
            }
            else
            {
              $flagDoiKTV = 1; //có đổi ktv
            }
        }
      }
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    //
    //
    $ngaydieutour = date('Y-m-d');
    $thoigianbatdau = date('H:i:s');
    $timestamptemp = date('Y-m-d H:i');
    $timestemptemp1 = $timestamptemp." + ".$sophut." minute"; 
    //echo "time stamp: ".$timestemptemp1;
    $thoigianketthuc = strtotime($timestemptemp1);
    //echo "gio ket thuc ".date('Y-m-d H:i:s',$thoigianketthuc);  ok
    //
    //-----xử lý update ktv vào lịch sử phiếu
    //
    if($maktvcu == "")
    {
      // ----trường hợp chưa có thông tin điều tour -> insert vào bảng tour
      $sql = "Insert into tblTheoDoiPhucVuSpa_ChiTiet(Ngay,MaCaThucHien, GioThucHien, GioKetThuc,MaNV, TenNV, MaBanPhong, MaHangBan, TenHangBan, LuotPhucVu, MaNVLapPhieu, MaPhieuDieuTour, SoLuongHangBan, ThoiGianLam, IsDaXuLy) values('$ngaydieutour','','$thoigianbatdau','".date('Y-m-d H:i:s',$thoigianketthuc)."','$maktvmoi',N'$tenktvmoi','$maban','$madichvu',N'$tendichvu','1','$tencashier','$malichsuphieu','1','$sophut','0')";
      //echo "them moi".$sql;
      $rs=sqlsrv_query($conn,$sql);
    }
    else if($flagDoiKTV == 1 && $maktvcu != "")
    {
      //-----trường hợp có thông tin tour nhưng có đổi ktv
      $sql = "Update tblTheoDoiPhucVuSpa_ChiTiet Set MaNV = '$maktvmoi', TenNV = '$tenktvmoi' Where MaNV like '$maktvcu' and MaPhieuDieuTour in (Select MaLichSuPhieu from tblLichSuPhieu Where DangNgoi = 1 and DaTinhTien = 0 and ThoiGianDongPhieu is null) and MaBanPhong like '$maban'";
      //echo "sua cu".$sql;
      $rs=sqlsrv_query($conn,$sql);
    }
    //
    //-----update lại lịch sử phiếu thông tin dịch vụ và tour - ok
    //
    $sql = "Update tblLichSuPhieu set GioVao = '$thoigianbatdau',GioTra = '".date('Y-m-d H:i:s',$thoigianketthuc)."', NVPhucVu = N'$maktvmoi',MaDichVuDieuTour = '$madichvu', DichVuDieuTour = N'$tendichvu', GhiChu = N'KTV: ' + '$maktvmoi' Where MaLichSuPhieu like '$malichsuphieu'";
    $rs=sqlsrv_query($conn,$sql);
    //echo "update ktv".$sql;
?> 
  <script> 
    alert('Đã chọn KTV thành công !');
    setTimeout('window.location="order.php"',0);
  </script>
<?php
  }
  //--------------END IF XU LY CHON KTV ------------------//
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>ZinSpa-Quản lý Spa Chuyên nghiệp</title> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />

<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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

.khu_active {
    background: #F9B703;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.khu {
    background: #0073aa;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.ban_dangchon {
    background: #F9B703;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 150px;
    height: 140px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.ban_cokhach {
	background: #F9B703; /*#FFFF99;  /*#DAFFC0; #DAFFC0;*/
    color: #000;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 150px;
    height: 140px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.ban_trong {
    background: #0073aa;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 150px;
    height: 140px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}
	
/*quy css*/
@media (min-width:1024px){
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 7px;
  }
}

@media (min-width:600px) and (max-width: 1024px) {
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 7px;
  }
}

@media (max-width:600px){
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 5px;
  }
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
<div id="wrapper">
    <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <a class="navbar-brand"><?php echo $tentrungtam; ?></a> 
    </div>
  </nav>
    <div id="page-wrapper">
      <div class="col-md-12 graphs">
	       <div class="xs">

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1>HÌNH KTV <?php echo $maktvcu;?></h1>
    <form action="orderKTV_update.php" method="post" >
      <p><input type="hidden" name="maktvcu" value="<?php echo @$maktvcu; ?>" style="width:100%;">
      </p>
      <img src="images/ktv/<?php echo $tenhinh.".jpg";?>" width="400" height="500" style="margin: auto;">
      <p style="padding-top:20px;"></p>
      <input type="submit" name="btn_update" value="Chọn">
    </form>
  </div>
</div>

<?php
if($zoom == "1")  // co thong tin nhập típ
{
  $zoom = "0"; // tắt cờ nhập típ
?>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//btn.onclick = function() {
    modal.style.display = "block";
//}

span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<?php
}//end if co danh gia -> hien modal
?>
	         <div class="row">
		          <div class="col-md-12">
                <table class="table">
                <thead>
                  <tr>
                    <th>Mã KTV</th>           
                    <th>KTV</th>    
                    <th>Thông tin</th>
                    <th>Hình</th>          
                    <th>Tình trạng</th>          
                    <th>Phòng</th>          
                    <th>Kết thúc</th>          
                    <th>Chọn</th>            
                  </tr>
            </thead>
            <tbody>
<?php 
   $codichvu = 0; 
  $l_sql="select a.*, ISNULL(b.ThuTuDieuTour,0) as ThuTuDieuTour, ISNULL(c.MaBanPhong,'') as MaBanPhong, c.GioTra from tblDMNhanVien a inner join (Select MaNV, Ngay, Thang, Nam, ThuTuDieuTour from tblHR_LichDieuTour Where Ngay = '$ngay' and Thang = '$thang' and Nam = '$nam') b on a.MaNV = b.MaNV and ISNULL(b.ThuTuDieuTour,0) > 0 left join (Select e.MaNV, e.MaBanPhong, f.GioTra from tblTheoDoiPhucVuSpa_ChiTiet e, tblLichSuPhieu f Where e.MaPhieuDieuTour = f.MaLichSuPhieu and f.DangNgoi = 1 and f.DaTinhTien = 0 and f.ThoiGianDongPhieu is null) c On a.MaNV = c.MaNV Where DaNghiViec = 0 and NhomNhanVien in (Select Ma from tblDMNhomNhanVien Where IsDieuTour = 1) Order by a.MaNV";
  
  try
  {
    $giotra = ""; $maphong = ""; $ghichudichvu = "";
    $rs=sqlsrv_query($conn,$l_sql);
    if($rs != false)
    {
      while($r=sqlsrv_fetch_array($rs))
      {
        $giotra = ""; $maphong = "";
        if($r['GioTra'] != null)
        {
          $giotra = strval(date_format($r['GioTra'],'Y-m-d H:m'));
        }
        $maphong = $r['MaBanPhong'];
        $ghichudichvu = $r['GhiChuDichVu'];
        
        if($tendichvu != "" && $ghichudichvu != "")
        {
          if(strpos($tendichvu,$ghichudichvu) !== false)
            $codichvu = 1;
        }

        //echo "ten dich vu".$tendichvu;
        //echo "ghi chu dich vu".$ghichudichvu;

        if($codichvu ==1 || $ghichudichvu == "")
        {
?>
          <tr class="success">
              <td><?php echo $r['MaNV'];?></td>            
              <td><?php echo $r['TenNV'];?></td>      
              <td><?php echo $r['GhiChuNV'];?></td>
              <td><a href="orderKTV.php?malichsuphieu=<?php echo $malichsuphieu;?>&madichvu=<?php echo $madichvu;?>&maktv=<?php echo $r['MaNV']; ?>&zoom=1"><img src="images/ktv/<?php echo $r['HinhAnhTemp'].".jpg";?>" width="200" height="300" style="margin: auto;"></a></td>
              <td><?php if($maphong == "") { ?><b>Rảnh</b><?php } else {?><b style="#FF0000">Bận</b><?php } ?></td>
              <td><?php echo $maphong;?></td>
              <td><?php echo $giotra;?></td>
              <td><?php if($maphong == "") { ?> <b><a href="orderKTV.php?malichsuphieu=<?php echo $malichsuphieu;?>&madichvu=<?php echo $madichvu;?>&maktv=<?php echo $r['MaNV']; ?>&chon=1">Chọn</a></b><?php } ?></td>
          </tr>
 <?php
        }
      }
    }
  }
  catch (Exception $e) {
    echo $e->getMessage();
  }       
?>
              </tbody>
              </table> 
		          </div>
		          <!-- /#col-md-12 -->
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
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" /> 
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
