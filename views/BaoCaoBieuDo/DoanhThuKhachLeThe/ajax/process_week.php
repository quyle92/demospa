<?php
require_once('../../../../lib/db.php');
require_once('../../../../lib/BaoCaoBieuDo.php');
require_once('../../../../helper/custom-functions.php');
session_start();
$client = new BaoCaoBieuDo($conn);

$start = isset($_POST['start']) ? $_POST['start'] : '';

$clientRevByWeek = $client->getClientRevByWeek( $start );
//$clientNoByWeek = array();
$clientRevByWeek = array(
	'khachLe' => strToInt($clientRevByWeek[0]) ,  
	'khachThe' => strToInt($clientRevByWeek[1]) 
);
echo json_encode($clientRevByWeek);