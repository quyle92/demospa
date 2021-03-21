<?php
session_start();
use Lib\BaoCaoBieuDo;
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$chartReport = new BaoCaoBieuDo($conn);

if($_POST['year'] != "") $year_selected = $_POST['year'];

$doanh_thu = $chartReport->getSalesAnotherYear($year_selected);
echo json_encode($doanh_thu);