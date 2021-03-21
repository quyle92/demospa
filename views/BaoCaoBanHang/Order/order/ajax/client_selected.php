<?php 
require_once realpath('../../../../../vendor/autoload.php');
use Lib\clsKhachHang;
$conn =  DBConnect();
$sgDep = new clsKhachHang($conn);
@session_start();
use \ForceUTF8\Encoding;
$client_code = $_POST['client_code'];

$data = [];

$r = $sgDep->getClientInfo( $client_code );//var_dump($r);

array_push( $data, $r['MaDoiTuong'], $r['TenDoiTuong'], $r['DienThoai'], ($r['DiaChi']), ($r['MaTheVip']), $r['LoaiTheVip'] );

function encode($v){
	return  Encoding::toUTF8($v);
}
$data = array_map("encode",$data);


echo json_encode($data );
