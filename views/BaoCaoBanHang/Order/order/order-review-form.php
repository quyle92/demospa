<div class="col-sm-6 col-md-4" style="margin-bottom:5px">
<!----------------------------- Order Review Form---------------------------->
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<h4>Danh mục nhân viên</h4>
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
							<td class="col-md-12">Tên Nhân Viên</td>
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
	$tenktv = ""; $soluong = 1;

	if(!isset($_SESSION['TenKTV'])) 
	{
		$_SESSION['TenKTV']=array(); 
	}
	
	if(!isset($_SESSION['MaKTV'])) 
	{
		$_SESSION['MaKTV']=array(); 
	}
	
	if(!isset($_SESSION['SoLuong']))
	{
		$_SESSION['SoLuong']=array();
	}
	//
	//--------xử lý truon hợp thêm sản phẩm----------//
	//
	if(isset($_SESSION['MaNV']))
	{
		$maktv = $_SESSION['MaNV'];
	}
	//echo $maktv;
	//var_dump( $_SESSION['TenKTV'] );
	$maktvtemp = "";
	if ($maktv != "" && $action!="update" and $action!="remove")//-- dang chon mon ok
	{
		//if (!array_key_exists($maktv,$_SESSION['TenKTV']))		//---kiểm tra có key chưa ?
		//{
			$l_sql = "Select a.* from tblDMNhanVien a, tblTheoDoiPhucVuSpa_ChiTiet b Where a.MaNV = b.MaNV and a.MaNV = '$maktv' and b.MaPhieuDieuTour like '$malichsuphieu'";
			//$l_sql = "Select a.* from tblDMNhanVien a, tblTheoDoiPhucVuSpa_ChiTiet b Where a.MaNV = b.MaNV and a.MaNV = '$maktv' ";
			$rs3=sqlsrv_query($conn,$l_sql);
			$r3=sqlsrv_fetch_array($rs3);
			
  		    $_SESSION['TenKTV'][$maktv]=$r3['TenNV'];var_dump($_SESSION['MaKTV']);
			$_SESSION['MaKTV'][$maktv]=$r3['MaNV'];
			$_SESSION['SoLuong'][$maktv]=1;

			sqlsrv_free_stmt( $rs3);
		//}
	}
	//
	//--------xử lý action update giỏ hàng: not use ----------------------//
	//
	if ($action=="update") 
	{
		( $soluong_arr =$_POST['soluong_arr'] );
		( $maktv_arr=$_POST['maktv_arr'] ); 

		count($_POST['maktv_arr']);
		echo "sl hang update:".count($_POST['maktv_arr']);
		
		for ($i=0;$i<count($_POST['maktv_arr']);$i++) 
		{
			"<br>".$soluong=$soluong_arr[$i];
			settype($soluong,'int'); 
			if ($soluong==0) continue;
		 	"<br>".$maktv=$maktv_arr[$i];
		 	settype($maktv,'int');
		 	if ($maktv<=0) continue;
				
			$l_sql_update = "Select a.* from tblDMNhanVien a, tblTheoDoiPhucVuSpa_ChiTiet b Where a.MaNV = b.MaNV and a.MaNV = '$maktv' and b.MaPhieuDieuTour like '$malichsuphieu'";
			$rs4=sqlsrv_query($conn,$l_sql_update);
			$r4=sqlsrv_fetch_array($rs4);
				
			$_SESSION['TenKTV'][$maktv]=$r4['TenNV'];
			$_SESSION['MaKTV'][$maktv]=$r4['MaNV'];
		 	($_SESSION['SoLuong'][$maktv]=$soluong); 

			sqlsrv_free_stmt( $rs4);
		}
	}
	////////////////////////////////////////////////////////////
	//
	//-------trường hợp không có chọn hoặc remove món: load từ danh sách lịch sử phiếu //
	//
	if ($maktv == "" && $malichsuphieu!= null && $malichsuphieu!= "")
	{
		$sql="SELECT * from [tblTheoDoiPhucVuSpa_ChiTiet] Where Malichsuphieu like '$malichsuphieu' Order by GioThucHien";

		$rs=sqlsrv_query($conn,$sql);
		while ($r=sqlsrv_fetch_array($rs))
		{
			$r["SoLuong"];

			$maktv=$r['MaNV'];
			
			$_SESSION['TenKTV'][$maktv]=$r['TenNV'];
			$_SESSION['MaKTV'][$maktv]=$r['MaNV'];
			$_SESSION['SoLuong'][$maktv]=intval($r['SoLuong']);
		}
	}
		
	/*this is to avoid empty arra element*/
	if (array_key_exists("",$_SESSION['TenKTV'])) 
	{
		unset($_SESSION['TenKTV'][""]);
	}

	if (array_key_exists("",$_SESSION['MaKTV'])) 
	{
		unset($_SESSION['MaKTV'][""]);
	}

	if (array_key_exists("",$_SESSION['SoLuong'])) 
	{
		unset($_SESSION['SoLuong'][""]);
	}
		
	/*end of this is to avoid empty arra element*/
	 	
	($_SESSION['TenKTV']);
	($_SESSION['MaKTV']);
	($_SESSION['SoLuong']);
	
	reset($_SESSION['TenKTV']);
	reset($_SESSION['MaKTV']);
	reset($_SESSION['SoLuong']);  

	$tongsoluong = 0;
	for ($i = 0; $i< count($_SESSION['TenKTV']) ; $i++)
	{ 
		($maktv=key($_SESSION['MaKTV']) ); //echo $maktv; hiện mã hàng bán ok nè
		($madvt=current($_SESSION['MaKTV']) );
		($tenHB=current($_SESSION['TenKTV']) );
	 	$soluong=current($_SESSION['SoLuong']);

	 	$tongsoluong = $tongsoluong + $soluong;
			
		if ($tenHB!="")
		{
?>
				<tr>
					<td class="text-center">
						<input type="checkbox" name="id_arr[]" value="<?=$maktv?>" />
					</td>
					<td class="col-md-12">
						<div class="media">
					 	<!-- <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://lorempixel.com/460/250/" style="width: 72px; height: 72px;"> </a> -->
					 		<div class="media-body">
								<h5 class="media-heading"><?=$tenHB?></h5>
								<!--<h5 class="media-heading">-<?=$maktv?></h5> -->
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
				 			<input type="hidden" value="<?=$maktv?>" name="maktv_arr[]" class="input-maktv" />
						</div>
					</td>
					<td class="text-left"></td>
					<td class="text-left"></td>
				</tr>
<?php 
		}//end if co hang ban

		next($_SESSION['TenKTV']);
		next($_SESSION['MaKTV']);
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
	
	if (array_key_exists("",$_SESSION['TenKTV'])) 
	{
		unset($_SESSION['TenKTV'][""]);
	}

	if (array_key_exists("",$_SESSION['MaKTV'])) 
	{
		unset($_SESSION['MaKTV'][""]);
	}
	
	foreach ( $_SESSION['TenKTV'] as $id => $ten )
	{
    	if ( $ten ==null)
    	{
        	unset($_SESSION['TenKTV'][$id]);
        	unset($_SESSION['MaKTV'][$id]);
        	unset ($_SESSION['SoLuong'][$id]);
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