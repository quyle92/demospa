<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/NhanVien.php');
$ktv = new NhanVien($conn);

if( isset( $_GET['action'] ) && $_GET['action'] === 'getAllKTV' )
{
      $rs =  $ktv->getAllKTV();
      $output = [];
      foreach($rs as $r){
      	$output[] = [
      	  'MaNV' => $r['MaNV'], 
            'TenNV' => $r['TenNV'], 
            'NhomNhanVien' => $r['NhomNhanVien'], 
            'TenNhomNV' => $r['TenNhomNV'], 
            'ThuTuDieuTour' => $r['ThuTuDieuTour'], 
            'GhiChuNV' => $r['GhiChuNV'], 
            //'HinhAnhTemp' => $r['HinhAnhTemp'], 
            'GioBatDau' => $r['GioBatDau'], 
            'GioKetThuc' => $r['GioKetThuc'], 
            'GhiChu' => $r['GhiChu'],
            'MaPhieuDieuTour' => $r['MaPhieuDieuTour'],
            'MaBanPhong' => $r['MaBanPhong'],
            'TenHangBan' => $r['TenHangBan'],
            'GioThucHien' => $r['GioThucHien'],
            'SoLanPhucVu' => $r['SoLanPhucVu'],
            'SoSaoDuocYeuCau' => $r['SoSaoDuocYeuCau']
      	];
      }
      echo json_encode($output);
}


if( isset( $_GET['action'] ) && $_GET['action'] === 'getnhomNV' )
{
      $rs =  $ktv->getnhomNV();
      $output = [];
      foreach($rs as $r){
            $output[] = [
                  'Ma' => $r['Ma'], 
                  'Ten' => $r['Ten'], 

            ];
      }
      echo json_encode($output);
}


if( isset( $_POST['action'] ) && $_POST['action'] == 'update' )
{     
      $params = $_POST;
      //var_dump ($params);die;
      $rs =  $ktv->updateKTV( $params );

      // $output = [];
      // $output['success'] = false;
      // $output['msg'] = "Sth Wrong";
      // echo json_encode($output);
}

if( isset( $_POST['action'] ) && $_POST['action'] == 'delete' )
{     
      $params = $_POST;
      //var_dump ($params);die;
      $rs =  $ktv->deleteKTV( $params );
}
