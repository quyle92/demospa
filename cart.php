<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');

@session_start();	//session_destroy();
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('Asia/Bangkok');
$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
//
//------------xử lý session của user ---------------//
//
if(!isset($_SESSION['MaNV'])) 
{ 
?>
<script>
	setTimeout('window.location="login.php"',0);
</script>
<?php
}

$_SESSION['NhapMon'] = 1; 

$manv=$_SESSION['MaNV'];
$tennv = $_SESSION['TenNV'];
$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
//
//----------------------lấy các thông tin post, get -------------------//
//
//----------------------mã lịch sử phiếu, mã bàn --------------------------------------//
//

$malichsuphieu = ""; 
if(isset($_GET['malichsuphieu']))			//---trường hợp xử lý theo link phân trang hoặc từ home
{
	$malichsuphieu= $_GET['malichsuphieu'];
}

if(isset($_POST['malichsuphieu']) && $malichsuphieu == "") //trường hợp xử lý theo submit form chọn món
{
	$malichsuphieu= $_POST['malichsuphieu'];
}

if(isset($_SESSION['MaLichSuPhieu']) && $malichsuphieu == "") //lấy từ session nếu chưa có mã lịch sử phiếu
{
	$malichsuphieu = $_SESSION['MaLichSuPhieu'];
}

if($malichsuphieu != "")
{
	$_SESSION['MaLichSuPhieu']= $malichsuphieu;			//-----luu lai session mới nhất MaLichSuPhieu
}
//
//
$maban = "";
if(isset($_GET['maban']))								//----get gia tri tu home.php
{
	$maban = $_GET['maban'];
}
if(isset($_POST['maban']) && $maban == "")				//----lấy từ submit form
{
	$maban = $_POST['maban'];
} 
if(isset($_SESSION['MaBan']) && $maban == "") 			// lấy từ session nếu chưa có mã bàn
{
	$maban = $_SESSION['MaBan'];
}

if($maban != "")
{
	$_SESSION['MaBan'] = $maban;						//-----lưu lai session ma ban mới nhất
}

if($maban==null or $maban=="" or $malichsuphieu == "")
{ 
?> 
	<script> 
		alert('Chưa có order dịch vụ');
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
	$manhomhangbanmoi = $manhomhangbancu;		// không thay đổi mã nhóm hàng bán
}
//
//----------------check có hàng bán -------------------//
//
if(isset($_GET['mahangban']))			//-----lay ma hang ban bang phuong thuc get
{
	$mahangban = $_GET['mahangban'];
	
	$l_sql = "Select * from tblDMHangBan WHERE MaHangBan = '$mahangban'";
	$rs7=sqlsrv_query($conn,$l_sql);
	while($r7=sqlsrv_fetch_array($rs7))
	{
		$manhomhangbanmoi = $r7['MaNhomHangBan'];
		$setmenu = $r7['SetMenu'];
	}
	sqlsrv_free_stmt( $rs7);
}

if(isset($_POST['mahangban']))			//-----lay ma hang ban bang phuong thuc post
{
	$mahangban = $_POST['mahangban'];
	
	$l_sql = "Select * from tblDMHangBan WHERE MaHangBan = '$mahangban'";
	$rs7=sqlsrv_query($conn,$l_sql);
	while($r7=sqlsrv_fetch_array($rs7))
	{
		//echo "</br>MaNhomHangBan: ". 
		$manhomhangbanmoi = $r7['MaNhomHangBan'];
		$setmenu = $r7['SetMenu'];
	}
	sqlsrv_free_stmt( $rs7);
}

$soluong_init = 0;
//if(isset($_GET['soluong']))
//	$soluong_init = $_GET['soluong'];//ok lấy đc $soluong
//	$mahangban = $_GET['mahangban'];
//	$_SESSION['SoLuong'][$mahangban] = $soluong_init;
//if($soluong_init) 
//{
//>
//script
//	setTimeout('window.location="order.php"',0);
//</script>
//<?php
//}
//
//	lưu lại session khi có click hang bán
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
//				action: add, update, delete
$action = "";
if(isset($_GET['action']))
{
	$action=$_GET['action'];
}

if ($action=="remove-all") 
{ 
	unset($_SESSION['SoLuong']);
	unset($_SESSION['TenHangBan']);
	unset($_SESSION['MaDVT']);
	unset($_SESSION['Gia']);
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
      $sql = "Insert into tblOrder_InPhieuTinhTien(MaNV, ThoiGianIn, MaLichSuPhieu, TinhTrangIn, InTamTinh) values('$manv','".date('Y-m-d H:i:s')."','$malichsuphieu','0','1')";
      $rs=sqlsrv_query($conn,$sql);
    }
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<?php require_once ('header-order.php'); ?>
</head>
<body>
		<div class="col-sm-6 col-md-4" style="margin-bottom:5px">
<?php
	if($malichsuphieu != null && $malichsuphieu != "")
	{
?>			
		<h4>Bàn: <?=$maban?> - Hóa đơn: <?=$malichsuphieu?></h4>
<?php
	}
?>
<!-----------------------------SHIPPING METHOD ---------------------------->
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<h4>Danh mục món</h4>
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
							<td class="col-md-12">Tên Sản Phẩm</td>
							<td class="text-center soluong">SL</td>
							<td class="text-center"></td>
							<td class="text-right">
								<!-- <div  class="btn btn-danger" style="margin-left: 20px;">
									<a href="order.php?action=remove-all&malichsuphieu=<?php //$malichsuphieu?>&maban=<?php //$maban?>"><i class="fa fa-times-circle" style="color:#fff"></i></a>
								</div>-->
							</td>
						</tr>
<!-- ---------------hien thi danh sach hang ban trong lich su phieu ---------------- -->
<?php
	$tenhangban = ""; $giaban = 0; $soluong = 1;
	
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
			$rs3=sqlsrv_query($conn,$l_sql);
			$r3=sqlsrv_fetch_array($rs3);
			
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
			$_SESSION['SoLuong'][$mahangban]=$soluong_init;
			$setmenu = $r3['SetMenu'];

			sqlsrv_free_stmt( $rs3);
			
			if($setmenu == 1)
			{
				$l_sql = "Select a.*,b.TenHangBan, b.MaDVTCoBan from tblDMHangBan_Setmenu a, tblDMHangBan b where a.MaHangBan = b.MaHangBan and a.MaHangBanSetMenu = '$mahangban' and a.MacDinh = 1";
				$rs31=sqlsrv_query($conn,$l_sql);
				if(sqlsrv_has_rows($rs31) !== false)
				{
					while ($r3=sqlsrv_fetch_array($rs31))
					{
						$r3["SoLuong"];

						$mahangbantemp = $r3['MaHangBan'];
			
						$_SESSION['TenHangBan'][$mahangbantemp]="#Set#".$r3['TenHangBan'];
						$_SESSION['MaDVT'][$mahangbantemp]=$r3['MaDVTCoBan'];
						$_SESSION['Gia'][$mahangbantemp]=0;
						$_SESSION['SoLuong'][$mahangbantemp]=intval($r3['SoLuong']);
					}
				}
				sqlsrv_free_stmt($rs31);
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
			$rs4=sqlsrv_query($conn,$l_sql_update);
			$r4=sqlsrv_fetch_array($rs4);
				
			$_SESSION['TenHangBan'][$mahangban]=$r4['TenHangBan'];
			$_SESSION['MaDVT'][$mahangban]=$r4['MaDVTCoBan'];
			($_SESSION['Gia'][$mahangban]=$r4['Gia']);
		 	($_SESSION['SoLuong'][$mahangban]=$soluong); 

			sqlsrv_free_stmt( $rs4);
		}
	}
	////////////////////////////////////////////////////////////
	//
	//-------trường hợp không có chọn hoặc remove món: load từ danh sách lịch sử phiếu //
	//
	if ($mahangban == "" && $mahangban_xoa == "" && $malichsuphieu!= null && $malichsuphieu!= "")
	{
		$sql="SELECT MaLichSuPhieu, MaHangBan, TenHangBan, MaDVT, DonGia, Sum(SoLuong) as SoLuong, Sum(ThanhTien) as ThanhTien from [tblLSPhieu_HangBan] Where Malichsuphieu like '$malichsuphieu' group by MaLichsuphieu, MaHangBan, TenHangBan, MaDVT, DonGia having sum(SoLuong) > 0 Order by Min(ThoiGianBan)";

		$rs=sqlsrv_query($conn,$sql);
		while ($r=sqlsrv_fetch_array($rs))
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
	 	$tien = $soluong * $giaHB;
	 	$tongtien = $tongtien + $tien;
	 	$tongsoluong = $tongsoluong + $soluong;
			
		if ($tenHB!="")
		{
?>
				<tr>
					<td class="text-center">
						<input type="checkbox" name="id_arr[]" value="<?=$mahangban?>" />
					</td>
					<td class="col-md-12">
						<div class="media">
					 		<div class="media-body">
								<h5 class="media-heading"><?=$tenHB?></h5>
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
							<input type="text" id="tongtien" name="tongtien" class="form-control input-tongtien-number" value="<?=number_format($tongtien,0,",",".")?>" oninput="validity.valid||(value='0');" style="border:0px solid #808080!important; border-radius:0px!important;width:80px"/><?php $_SESSION['tongtien'] = $tongtien;?>
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
							<span style="margin-left: 10px !important;"><button type="submit" class="btn" style="color:red" name ="huybo" formaction="order_confirm.php?malichsuphieu=<?=$malichsuphieu?>&order=0">Hủy Bỏ</button></span>
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
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" /> 
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
    //	newVal_ThanhTien_str = newVal_ThanhTien_str.substring(0,len-3) + '.' + newVal_ThanhTien_str.substring(len-3,3);
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
    tongtienObj.value = tongTien_newvalue; 	//--ok
    tongsoluongObj.value = tongsoluong_newvalue;
    //
    // ajax: ok
    //
    var ajaxurl = 'order_update.php',
        data =  {'mahangban': mahangban, 'soluong': soluong_newVal};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
		
			
            document.getElementById("ketqua").innerHTML=response;
           
			
        });
  });
</script>
<script>
		$("#checkAll").click(function () {
     $('input:checkbox').prop('checked', this.checked);
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

</body>