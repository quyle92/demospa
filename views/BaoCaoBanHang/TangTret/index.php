<?php 

use Lib\clsKhachHang;
$page_name = "BaoCaoBanHang";
//require_once('helper/security.php');

require('functions/lichsuphieu.php');
$sgDep = new clsKhachHang($conn);
@session_start();	

date_default_timezone_set('Asia/Bangkok');
if (isset($_SESSION['MaLichSuPhieu'])) 
{
   //if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) 
   //{
   // unset($_SESSION['SoLuong']);
	 //unset($_SESSION['TenHangBan']);
		//unset($_SESSION['MaDVT']);
		//unset($_SESSION['Gia']);
		//unset($_SESSION['MaLichSuPhieu']);
		//unset($_SESSION['NhapMon']);
        ### or alternatively, you can use this for specific variables:
        ### unset($_SESSION['varname']); 

   //}
    unset($_SESSION['MaLichSuPhieu']);
    unset($_SESSION['MaBan']);
    unset($_SESSION['MaHangBan']);
    unset($_SESSION['TenHangBan']);
    unset($_SESSION['NhapMon']);
    unset($_SESSION['ThemMonSetMenu']);
    unset($_SESSION['SoLuong']);
    unset($_SESSION['TenHangBan']);
    unset($_SESSION['MaDVT']);
    unset($_SESSION['Gia']);
}

if(!isset($_SESSION['TenSD'])) //------check session nhân viên, ko có thoát ra dang nh?p l?i
{
?>
<script>
	//setTimeout('window.location="login.php"',0);
</script>
<?php
}

$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
//
//--------------------X? LÝ KHU, BÀN ----------------------//
//
$makhu = isset($_SESSION['MaKhu']) ? $_SESSION['MaKhu'] : "01-SPA1"; 
if(isset($_GET['makhu']))
{
	$makhu = $_GET['makhu']; //---check ok
}
//
//var_dump ($_SESSION['makhu'] = $makhu);
$maban = "";
if(isset($_GET['maban']))
{
	$maban = $_GET['maban'];
} 
//
//	luu l?i session khi click khu
//
if($makhu != "")
{
	$_SESSION['MaKhu'] = $makhu;
	
}
if($maban != "")
{
  $_SESSION['MaBan'] = $maban;
}

if(isset($_SESSION['MaBan'])) 
{
	$maban = $_SESSION['MaBan'];
	//
	//	lay cac gia tri tu lich su phieus
	//
	$l_sql = "Select * from tblLichSuPhieu Where MaBan = '$maban' and DaTinhTien = 0 and PhieuHuy = 0 and ThoiGianDongPhieu is null";
	$rs =  $conn->query($l_sql)->fetchAll(\PDO::FETCH_ASSOC);
	foreach($rs as $r3)
	{
		$malichsuphieu = $r3['MaLichSuPhieu'];
		$makhachhang = $r3['MaKhachHang'];
		$tenkhachhang = $r3['TenKhachHang'];
	}

}
//
//
$malichsuphieu = ""; $tenkhachhang = "";
if(isset($_GET['malichsuphieu']))
{
	$malichsuphieu = $_GET['malichsuphieu'];
}
//
//------------set tr?ng thái c? d? refresh trang ---------//
//
$nhapmon = 0;
if(isset($_SESSION['NhapMon']))
{
	$nhapmon = $_SESSION['NhapMon'];
}
else 
{
	$nhapmon = 0;
}

?>

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




	<div class="row">
		<div class="col-md-12">
			<div class="grid">
<?php 
	if (isset($_GET['pageno'])) {
	   $pageno = $_GET['pageno'];
	} else {
		$pageno = 1;
	}
	$no_of_records_per_page = 20; //18
	$startRow = ($pageno-1) * $no_of_records_per_page;
	$endpoint = $startRow + $no_of_records_per_page;
	
	$total_pages_sql = "select  COUNT(*) from [tblDMBan]  Where MaKhu = '$makhu' and MaBan in (Select MaBan from tblLichSuPhieu where ThoiGianDongPhieu is null and DangNgoi = 1 and DaTinhTien = 0)";
	try
	{
		$total_rows = $conn->query($total_pages_sql)->fetchColumn();
		$total_pages = ceil($total_rows / $no_of_records_per_page);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
  //echo $makhu;
	//
	//----------------danh sach ban ------------------------//
	//
  $sql="select * from (SELECT *, ROW_NUMBER() OVER (ORDER BY MaBan) as rowNum FROM [tblDMBan] Where MaKhu = '$makhu') sub WHERE rowNum >  '$startRow' and rowNum <= '$endpoint'";
	try
	{
		$mabantemp = ""; $giovao = ""; $thoigianconlai = ""; $tendv = ""; $malichsuphieutemp = ""; $ghichu = ""; $tongtien = 0; $tenkhachhang = "";

		$rs=$conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		foreach($rs as $r2)	//-----duyet danh sach ban
		{
			$r2['MaBan'];
			$mabantemp = ""; $giovao = ""; $tendv = ""; $malichsuphieutemp = "";
			$mabantemp = $r2['MaBan'];
			//
			//
			if($maban == "")
					$maban = $r2['MaBan']; 	//-----neu chua co ban chon thi chon ban dau tien
?>				
			<form action="../Order/index.php" method="get">
<?php
			$sql="SELECT *, case 
        when GioVao <= getdate() and (ISNULL(ThoiGianLam,0) - Cast(datediff(mi,GioVao,getdate()) as decimal(18,0))) < 0 
        then 'Còn: ' + cast(0 as varchar(5)) + ' p' 
        when GioVao <= getdate() and (ISNULL(ThoiGianLam,0) - Cast(datediff(mi,GioVao,getdate()) as decimal(18,0))) >= 0 
        then 'Còn: ' + cast((ISNULL(ThoiGianLam,0) - Cast(datediff(mi,GioVao,getdate()) as decimal(18,0))) as varchar(10)) + ' p' 
        else 'Còn: ' + cast(ISNULL(ThoiGianLam,0) as varchar(10)) + ' p' end as ThoiGianConLai FROM tblLichSuPhieu WHERE MaBan like '$mabantemp' and DaTinhTien = 0 and ThoiGianDongPhieu is null";

			$result = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			try	
			{
				if(($result) != false) 
				{
					foreach($result as $r1)
					{//2020-12-07 13:53:20.69
						$r1['GioVao']; 
						$r1['MaLichSuPhieu'];
						$r1['GhiChu'];
            $r1['TongTien'];

						$giovao = substr($r1['GioVao'],11,5);
            $thoigianconlai = $r1['ThoiGianConLai'];
						$tendv = $r1['DichVuDieuTour'];
						$malichsuphieutemp = $r1['MaLichSuPhieu'];	
						$ghichu = $r1['GhiChu'];
            $tongtien = $r1['TongTien'];
            //$tenkhachhang = mb_convert_encoding($r1['TenKhachHang'],'UTF-8', 'UTF-8');
            $tenkhachhang =$r1['TenKhachHang']  ;
					}
				}
			}
			catch (Exception $e) {
				echo $e->getMessage();
			}
			
			if($malichsuphieutemp != "")
			{
				//echo $malichsuphieutemp; ok
?>
				<button type="submit" name="maban" value="<?php echo $mabantemp; ?>" class="ban_cokhach">
<?php
          echo "<b>".$mabantemp."</b><br>"; 
          echo $thoigianconlai."<br>";
          echo $tendv ."<br>";
          echo $tenkhachhang."<br>";
          echo $tongtien." VNÐ<br>";

		?> </button> <?php	} 
    else
			{
?>
				<button type="submit" name="maban" value="<?php echo $mabantemp; ?>" class="ban_trong">
<?php
          echo "<b>".$mabantemp."</b><br>"; 
		?> </button> <?php	}
?>      
				<input type="hidden" name="malichsuphieu" value="<?php echo $malichsuphieutemp; ?>" />
				<input type="hidden" name="xora" value="yes" />
				
			</form>
<?php
		}//end while danh sach ban

	
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}			
?>
			</div>
			<!-- end grid -->
		</div>
		<!-- /#col-md-12 -->
	</div>
	
	<!-- Pagination -->

	<ul class="pagination">
        <li><a href="?pageno=1&makhu=<?=$makhu?>">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo '?pageno='.($pageno - 1).'&makhu='.$makhu; } ?>">Prev</a>
        </li>
		
		<?php
		$offset=10;
		$from=$pageno-$offset;
		$to=$pageno+$offset;
		if ($from<=0) $from=1;  $to=$offset*5;
		if ($to>$total_pages)	$to=$total_pages;
		for ($j=$from;$j<=$to;$j++) {
			if ($j==$pageno) { ?>
				<li class='active'><a href='home.php?pageno=<?=$j?>&makhu=<?=$makhu?>'><?=$j?></a></li>
			<?php } else { ?>
				<li class=''><a href='home.php?pageno=<?=$j?>&makhu=<?=$makhu?>'><?=$j?></a></li>
			<?php }
		}
		?>
		
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).'&makhu='.$makhu; } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages.'&makhu='.$makhu ?>">Last</a></li>
    </ul>
		<!-- Pagination End-->
	  
	<!-- /div class="xs" -->
  	
	<!-- /div class="col-md-12 graphs"-->
    
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Nav CSS -->
<!-- Metis Menu Plugin JavaScript -->

</script>

<?php
	if($nhapmon == 0)	// ko co dang nhap mon
	{
?>
<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         // if(new Date().getTime() - time >= 5000) //5s 1 phut: 60000
         //     window.location.reload(true);
         // else 
         //     setTimeout(refresh, 2000);
     }

     //setTimeout(refresh, 2000);
</script>
<?php 
	}
?>
</body>
</html>
