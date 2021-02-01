<?php 
include("lib/db.php");//all of these use set_include_path defined in .htaccess
include("lib/BaoCaoBieuDo.php");
include("lib/General.php");
$general = new General($conn);
@session_start();
$dophu = new BaoCaoBieuDo($conn);

$tungay = isset( $_POST['tungay'] ) ? $_POST['tungay'] :"";//16/10/2020
$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = isset( $_POST['denngay'] ) ? $_POST['denngay'] :"";
$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$tugio =  isset( $_POST['tugio'] ) ? $_POST['tugio'] :"";
if ($tugio == '' || $tugio == null) $tugio = "00:01";

$dengio =  isset( $_POST['dengio'] ) ? $_POST['dengio'] :"";
if ($dengio == '' || $dengio == null) $dengio = "23:00";

$ma_khu =  isset( $_POST['ma_khu'] ) ? $_POST['ma_khu'] :"";

$khu = $general->getKhu();
$output = array();

$co_nguoi = $dophu->getTotalTablesWithBills( $tungay, $denngay, $tugio, $dengio, $ma_khu);
$tong_so_ban = $dophu->countTotalTables( $ma_khu );
$ban_trong = $tong_so_ban - $co_nguoi;

$output[] = [
		'co_nguoi' => $co_nguoi,
		'ban_trong' => $ban_trong
];

echo json_encode($output);