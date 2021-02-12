<?php //header("Content-Type: application/json; charset=UTF-8");
require('lib/db.php');
require('lib/clsKhachHang.php');
require('helper/custom-functions.php');
require('helper/ForceUTF8/Encoding.php');
use \ForceUTF8\Encoding;
$sgDep = new clsKhachHang($conn);
@session_start();	

$client_code = $_POST['client_code'];

$data = [];

$r = $sgDep->getClientInfo( $client_code );//var_dump($r);

array_push( $data, $r['MaDoiTuong'], $r['TenDoiTuong'], $r['DienThoai'], ($r['DiaChi']), ($r['MaTheVip']), $r['LoaiTheVip'] );

function encode($v){
	return  Encoding::toUTF8($v);
}
$data = array_map("encode",$data);


echo json_encode($data );
