<?php 
include("lib/db.php");//all of these use set_include_path defined in .htaccess
include("lib/BaoCaoBieuDo.php");
include("lib/General.php");
$general = new General($conn);
@session_start();
$dophu = new BaoCaoBieuDo($conn);

$tuNgay = isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] :"";//16/10/2020
$tuNgay = substr($tuNgay,6) . "/" . substr($tuNgay,3,2) . "/" . substr($tuNgay,0,2);

$denNgay = isset( $_POST['denNgay'] ) ? $_POST['denNgay'] :"";
$denNgay = substr($denNgay,6) . "/" . substr($denNgay,3,2) . "/" . substr($denNgay,0,2);

$tuGio =  isset( $_POST['tuGio'] ) ? $_POST['tuGio'] :"";
if ($tuGio == '' || $tuGio == null) $tuGio = "00:01";

$denGio =  isset( $_POST['denGio'] ) ? $_POST['denGio'] :"";
if ($denGio == '' || $denGio == null) $denGio = "23:00";

$ma_khu =  isset( $_POST['ma_khu'] ) ? $_POST['ma_khu'] :"";

$khu = $general->getKhu();
$output = array();

$co_nguoi = $dophu->getTotalTablesWithBills( $tuNgay, $denNgay, $tuGio, $denGio, $ma_khu);
$tong_so_ban = $dophu->countTotalTables( $ma_khu );
$ban_trong = $tong_so_ban - $co_nguoi;

$output[] = [
		'co_nguoi' => $co_nguoi,
		'ban_trong' => $ban_trong
];

echo json_encode($output);