<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();
date_default_timezone_set('Asia/Bangkok');

$ngay = date('d');
$thang = date('m');
$nam = date('Y');

$manv_nhom = ""; $vaoca = 0; $manv = ""; $manhomnv = "";
if(isset($_POST['manv']))
{
  	$manv_nhom = $_POST['manv'];
    if(strpos($manv_nhom,",") !== false)
    {
      $arr_nv = explode(",", $manv_nhom);
      $manv = $arr_nv[0];
      $manhomnv = $arr_nv[1];
    }
  	$vaoca = $_POST['vaoca'];
    //
  	//$sql = "delete from tblHR_LichDieuTour Where MaNV like '$manv'";
    //$rs=sqlsrv_query($conn,$sql);
    //
    //
    $thututour = 0;
    if($vaoca == 1)
    {
      $sql = "Select ISNULL(MAX(ThuTuDieuTour),0) as ThuTuMax from tblHR_LichDieuTour Where Ngay = '".intval($ngay)."' and Thang = '".intval($thang)."' and Nam = '".intval($nam)."' and MaNV in (Select MaNV from tblDMNhanVien Where NhomNhanVien like '$manhomnv')";
      $rs1=sqlsrv_query($conn,$sql);
      if($rs1 != false)
      {
        while($r=sqlsrv_fetch_array($rs1))
        {
          $r['ThuTuMax'];
          $thututour = $r['ThuTuMax'] + 1;
        }
      }

      if($thututour == 0)
      {
        $thututour = 1;
        //
        //------chưa có sx ngày, đây là record đầu tiên -> query lấy ngay bắt đầu và ngày kết thúc của nv
        //
        $giobatdau = date('Y-m-d')." 08:00:00";
        $gioketthuc = date('Y-m-d')." 23:59:59";
        $matrungtam = "01";

        $sql = "Select Top 1 GioBatDau, GioKetThuc, MaTrungTam from tblHR_LichDieuTour where MaNV like '$manv' Order by GioBatDau desc";
        $rs2=sqlsrv_query($conn,$sql);
        if($rs2 != false)
        {
          while($r2=sqlsrv_fetch_array($rs2))
          {
            $r2['GioBatDau'];
            $r2['GioKetThuc'];
            $r2['MaTrungTam'];
            $matrungtam = $r2['MaTrungTam'];
            $giobatdau = "".date('Y-m-d H:i:s', strtotime($r2['GioBatDau']));
            $gioketthuc = "".date('Y-m-d H:i:s', strtotime($r2['GioKetThuc']));
          }
        }

        $sql = "Insert into tblHR_LichDieuTour(MaNV, Ngay, Thang, Nam, ThuTuDieuTour,GioBatDau, GioKetThuc, MaTrungTam) values('$manv','".intval($ngay)."','".intval($thang)."','".intval($nam)."','$thututour','$giobatdau','$gioketthuc','$matrungtam')";
        $rs2=sqlsrv_query($conn,$sql);
      }
      else
      {
        $sql = "Update tblHR_LichDieuTour set ThuTuDieuTour = '$thututour' Where MaNV like '$manv' and Ngay = '".intval($ngay)."' and Thang = '".intval($thang)."' and Nam = '".intval($nam)."'";
        $rs=sqlsrv_query($conn,$sql);
      }
    }
    else
    {
        $sql = "Update tblHR_LichDieuTour set ThuTuDieuTour = 0 where MaNV like '$manv' and Ngay = '".intval($ngay)."' and Thang = '".intval($thang)."' and Nam = '".intval($nam)."'";
        $rs=sqlsrv_query($conn,$sql);
    }
}
?>