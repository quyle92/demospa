<?php
session_start();
use Lib\BaoCaoBieuDo;
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$clientDev = new BaoCaoBieuDo($conn);

$tuThang = isset($_POST['tuThang']) ? $_POST['tuThang'] : '';
$tuThang = substr($tuThang,3,4) . '-' . substr($tuThang,0,2);

$denThang = isset($_POST['denThang']) ? $_POST['denThang'] : ''; $denThang = substr($denThang,3, 4) . '-' . substr($denThang,0,2);

/**
 * Date Processing
 * ref: https://stackoverflow.com/questions/18742998/how-to-list-all-months-between-two-dates
 */

$begin  = ( new DateTime($tuThang) )->modify('first day of this month');
$end    = ( new DateTime($denThang) )->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$month_range = new DatePeriod($begin, $interval, $end );

$month_diff =  iterator_count($month_range );//Calculate the number of months between two dates. Ref: https://stackoverflow.com/a/25684828/11297747s

$clientNoByYear = $clientDev->getClientNoByYear( $month_range, $month_diff );
$clientNoByYear = (strToInt($clientNoByYear));
echo json_encode($clientNoByYear);