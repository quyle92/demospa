<?php
require('lib/db.php');
require('lib/BaoCaoBieuDo.php');
require('helper/custom-functions.php');
session_start();
$clientDev = new BaoCaoBieuDo($conn);

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
$datediff = round( $datediff / (60 * 60 *24) ) + 1;//var_dump($datediff); (1)

$clientNoByMonth = $clientDev->getClientNoByMonth( $date_range, $datediff );
$clientNoByMonth = (strToInt($clientNoByMonth));
echo json_encode($clientNoByMonth);


/**
 * Note
 */
//(1)Cach 2:
//$datediff = $begin->diff( $end );
///echo $datediff->days; 