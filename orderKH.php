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
   //setTimeout('window.location="order.php"',0);
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
    alert('Bạn cần xác nhận để mở phiếu trước !');
   //setTimeout('window.location="order.php"',0);
  </script>
<?php
}

$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
$tencashier = $_SESSION['TenNV'];

$ngay = date("d");
$thang = date("m");
$nam = date("Y");

$makhmoi = ""; $tenkhmoi = ""; $mathevip = ""; $manhomkh = ""; $ghichu = ""; 

$chon = 0; 
if(isset($_GET['chon'])) //----------lấy từ orderKH.php
{
  $chon = $_GET['chon']; $makhmoi = $_GET['makh'];
  if($chon == 1)
  {
    if($makhmoi != "")
    {
      //-------------lấy thông tin khách hàng --------------//
      $sql = "Select a.*, b.MaTheVip, b.NgayApDung, b.NgayKetThuc, b.NgungThe, b.IsGhiNoDV, b.IsGhiNoTT from tblDMKHNCC a left join tblKhachHang_TheVip b On a.MaDoiTuong = b.MaKhachHang Where a.MaDoiTuong like '$makhmoi'";
      $rs=sqlsrv_query($conn,$sql);
      if($rs != false)
      {
        while($r=sqlsrv_fetch_array($rs))
        {
            $r['MaDoiTuong'];
            $r['TenDoiTuong'];
            $r['MaNhomKH'];
            $r['MaTheVip'];
            $r['NgayApDung'];
            $r['NgungThe'];

            $tenkhmoi = $r['TenDoiTuong'];
            $manhomkh = $r['MaNhomKH'];
            $mathevip = $r['MaTheVip'];
        }
      }
    }
    //
    //-----update lại lịch sử phiếu thông tin dịch vụ và tour - ok
    //
    $sql = "Update tblLichSuPhieu set MaKhachHang = '$makhmoi',TenKhachHang = N'$tenkhmoi', NhomKH = '$manhomkh',MaTheVip = '$mathevip' Where MaLichSuPhieu like '$malichsuphieu'";
    $rs=sqlsrv_query($conn,$sql);
    //echo "update ktv".$sql;
?> 
  <script> 
    alert('Đã chọn Khách hàng thành công !');
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
<title>ZinSpa - Tablet</title> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa chuyên nghiệp - ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />

<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- DataTable plugin --> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
  $.noConflict();
    $('#order_KH').DataTable({
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });
} );
</script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style> 
  .dataTables_wrapper #order_KH_filter {
  width:100%;
  text-align:center;
  float: none;
}

.dataTables_wrapper #order_KH_filter input{
  width: 21em;
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
    width: 25%;
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
    <h1>HÌNH KH <?php echo $maktvcu;?></h1>
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
if(isset($zoom) && $zoom == "1")  // co thong tin nhập típ
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
                <table class="table" id="order_KH">
                <thead>
                  <tr>
                    <th>Mã</th>           
                    <th>Tên</th>    
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>          
                    <th>Nhóm KH</th>          
                    <th>Mã thẻ VIP</th>          
                    <th>Loại thẻ VIP</th>          
                    <th>Chọn</th>            
                  </tr>
            </thead>
            <tbody>
<?php 
  $l_sql="select a.*, b.MaTheVip, b.TenLoaiThe from tblDMKHNCC a left join (Select MaKhachHang, MaTheVip, TenLoaiThe from tblKhachHang_TheVip e, tblDMLoaiTheVip f where e.LoaiTheVip = f.MaLoaiThe) b On a.MaDoiTuong = b.MaKhachHang Order by a.MaDoiTuong";
  $makhtemp = "";  
  try
  {
    $rs=sqlsrv_query($conn,$l_sql);
    if($rs != false)
    {
      while($r=sqlsrv_fetch_array($rs))
      {
        $r['MaDoiTuong'];
        $makhtemp = $r['MaDoiTuong'];

?>
          <tr class="success">
              <td><?php echo $r['MaDoiTuong'];?></td>            
              <td><?php echo $r['TenDoiTuong'];?></td>      
              <td><?php echo $r['DienThoai'];?></td>
              <td><?php echo $r['DiaChi'];?></td>
              <td><?php echo $r['MaNhomKH'];?></td>
              <td><?php echo $r['MaTheVip'];?></td>
              <td><?php echo $r['TenLoaiThe'];?></td>
              <td><b><a href="orderKH.php?malichsuphieu=<?php echo $malichsuphieu;?>&makh=<?php echo $makhtemp;?>&chon=1">Chọn</a></b></td>
          </tr>
 <?php
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
        <a href="orderKTV.php?malichsuphieu=<?php echo $malichsuphieu;?>&madichvu=<?php echo $madichvu;?>" class="data-pa data-attr-content_600 hide_900" data-content_600="KD HCM">
        Chọn KTV Vào Làm</a>
        <a href="" class="data-pa data-attr-content_600 hide_800" data-content_600="KD HN" title="Email" onclick=" alert('Cần chọn phòng để In phiếu!'); return event.preventDefault();">
        In Phiếu</a>
        <a href="cart.php" class="data-pa data-attr-content_600 hide_800" data-content_600="KD HN" title="Email" onclick=" alert('Liên hệ thu ngân thu tiền!'); return event.preventDefault();">
        Thu tiền</a>
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
