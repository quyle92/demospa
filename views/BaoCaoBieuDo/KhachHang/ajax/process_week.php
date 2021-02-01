<?php
require('lib/db.php');
require('lib/BaoCaoBieuDo.php');
require('helper/custom-functions.php');
session_start();
$clientDev = new BaoCaoBieuDo($conn);


$start = isset($_POST['start']) ? $_POST['start'] : '';

$clientNoByWeek = $clientDev->getClientNoByWeek( $start );
$clientNoByWeek = (strToInt($clientNoByWeek));
echo json_encode($clientNoByWeek);