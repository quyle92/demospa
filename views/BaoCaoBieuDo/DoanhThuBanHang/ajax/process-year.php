<?php
require_once('../../../../lib/db.php');
require_once('../../../../lib/BaoCaoBieuDo.php');
@session_start();
$chartReport = new BaoCaoBieuDo($conn);

if($_POST['year'] != "") $year_selected = $_POST['year'];

$doanh_thu = $chartReport->getSalesAnotherYear($year_selected);
echo json_encode($doanh_thu);