<?php
session_start();
use Lib\BaoCaoBieuDo;
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$clientDev = new BaoCaoBieuDo($conn);


$start = isset($_POST['start']) ? $_POST['start'] : '';

$clientNoByWeek = $clientDev->getClientNoByWeek( $start );
$clientNoByWeek = (strToInt($clientNoByWeek));
echo json_encode($clientNoByWeek);