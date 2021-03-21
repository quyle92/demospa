<?php 
require_once realpath('../../../../../vendor/autoload.php');
use Lib\clsKhachHang;
$conn =  DBConnect();
$sgDep = new clsKhachHang($conn);
@session_start();	

$client_code = $_POST['client_code'];
$client_name = $_POST['client_name'];
$client_tel = $_POST['client_tel'];
$data = [];
//var_dump($_POST);
$rs = $sgDep->searchCustomer( $client_code, $client_name, $client_tel );
foreach($rs as $r)
{
	$data []= '<tr>
    <td class="sorting_1">' . $r["MaDoiTuong"]  .' </td>
    <td>'. $r["TenDoiTuong"] . '</td>
    <td>' .$r["DienThoai"] .'</td>
    <td>' . $r["DiaChi"] . '</td>
    <td> <button type="button" class="btn btn-primary" id="client_selected_' . $r["MaDoiTuong"] . '" value="' .$r["MaDoiTuong"] . '">Select</button></td>
  </tr>';
}

echo json_encode($data);
