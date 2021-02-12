<?php 
require('../../lib/db.php');
require('../../lib/clsKhachHang.php');
require('../../functions/lichsuphieu.php');
require('../../helper/custom-functions.php');
$sgDep = new clsKhachHang($conn);
@session_start();	

$client_code = $_POST['client_code'];

$data = [];

$r = $sgDep->getClientInfo( $client_code );//var_dump($rs);

array_push( $data, $r['MaDoiTuong'], ($r['TenDoiTuong']), $r['DienThoai'], ($r['DiaChi']), ($r['MaTheVip']), $r['LoaiTheVip'] );

$data = array_map("utf8_encode",$data);

echo json_encode($data );
