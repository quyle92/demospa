<?php
require_once('../../../../lib/db.php');
require_once('../../../../lib/BaoCaoBieuDo.php');
require_once('../../../../helper/custom-functions.php');
session_start();
$client = new BaoCaoBieuDo($conn);

$tuNgay = isset($_POST['tuNgay']) ? $_POST['tuNgay'] : '';
$tuNgay = substr($tuNgay,6,4) . '/' . substr($tuNgay,3,2) . '/' . substr($tuNgay,0,2);

$denNgay = isset($_POST['denNgay']) ? $_POST['denNgay'] : '';
$denNgay = substr($denNgay,	6, 4) . '/' . substr($denNgay,3,2) . '/' . substr($denNgay,0,2);

/**
 * Date Processing
 * ref: https://www.webfx.com/blog/web-design/php-dateinterval-class/
 */

$begin = new DateTime($tuNgay);
$end = new DateTime($denNgay);
$end = $end->add( new DateInterval('P1D') );

$interval = DateInterval::createFromDateString('1 day');
$date_range = new DatePeriod($begin, $interval, $end);

$datediff = strtotime($denNgay) - strtotime($tuNgay);
$datediff = round( $datediff / (60 * 60 *24) ) + 1;//var_dump($datediff); 

$clientRevByMonth = $client->getClientRevByMonth( $date_range, $datediff );
$clientRevByMonth = array(
	'khachLe' => strToInt($clientRevByMonth[0]) ,  
	'khachThe' => strToInt($clientRevByMonth[1]) 
);
echo json_encode($clientRevByMonth);
