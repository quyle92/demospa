<?php 
require('fpdf182/fpdf.php');
require ('lib/restaurant.php');

$height = 50;
$pdf = new FPDF('P', 'mm' , array(80, $height+30));
$pdf->AddFont('Roboto','', 'Roboto-Regular.php');
$pdf->AddFont('Roboto','B', 'Roboto-Bold.php');
$pdf->AddFont('Roboto','I', 'Roboto-Italic.php');
$pdf->AddFont('OpenSans','', 'OpenSans-Regular.php');


$pdf->AddPage();
//$pdf->SetMargins(1,0,0);

$pdf->SetFont('Roboto','B',6);

$orderID = $_GET['orderID'] ;

$nha_hang = new Restaurant();
$rs = $nha_hang->order_chitiet( $orderID );




$pdf->Cell(65,3,'Pizza Restaurant', 0, 1, 'C');
$pdf->SetFont('Arial','',6);
$pdf->Cell(65,3,'Address: 123 XVNT, F:25, BT', 0, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(65,3,'Invoice', 0, 1, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(65,3,'Number: NT001234', 0, 1, 'C');
$pdf->Cell(65,3,'Date: 24/12/2020', 0, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(17,3,'Customer:', 0, 0, 'L');$pdf->SetFont('Arial','',6);$pdf->Cell(50,3,'Andrew Smith', 0, 1, 'L');
$pdf->SetFont('Arial','B',6);
$pdf->Cell(17,3,'Telephone:', 0, 0, 'L');$pdf->SetFont('Arial','',6);$pdf->Cell(50,3,'0919 919 911', 0, 1, 'L');
$pdf->SetFont('Arial','B',6);
$pdf->Cell(17,3,'Address:', 0, 0, 'L');$pdf->SetFont('Arial','',6);$pdf->Cell(50,3,'456 My Street HCMC', 0, 1, 'L');

$pdf->Line(10,40,70,40);
$pdf->Ln(3);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(40,3,'Price:', 0, 0, 'L');
$pdf->Cell(10,3,'SL:', 0, 0, 'L');
$pdf->Cell(22,3,'Total:', 0, 0, 'L');

/**
 * Order item*
 */
$pdf->Line(10,45,70,45);
$pdf->Ln(5);
$pdf->SetFont('Roboto','',6);



$so_luong_arr = array();
$thanh_tien_arr = array();
while( $order_chitiet = sqlsrv_fetch_array($rs) )
{
	$pdf->Cell(40,3, $order_chitiet['TenHangBan'], 0, 0, 'L');
	$pdf->Cell(10,3,$order_chitiet['SoLuong']+0, 0, 0, 'L');
	$thanh_tien = $order_chitiet['DonGia']*$order_chitiet['SoLuong'];
	$pdf->Cell(17,3,number_format($thanh_tien,0,",","."), 0, 0, 'L');
	$pdf->Ln(3);
	$so_luong_arr[] = $order_chitiet['SoLuong'];
	$thanh_tien_arr[] = $thanh_tien;
}

$total_qty = 0 ;
foreach ($so_luong_arr as $sl){
	$total_qty += $sl; 
}

$grand_total = 0 ;
foreach ($thanh_tien_arr as $tt){
	$grand_total += $tt; 
}
/**
 * End of Order Item
 */
$pdf->Ln(4);
$pdf->SetFont('Times','B',6);
$pdf->Cell(60,1,'', 'T', 1, 'L');
$pdf->Cell(40,3,'Grand Total', 0, 0, 'L');
$pdf->Cell(10,3, $total_qty, 0, 0, 'L');
$pdf->Cell(17,3, "VND ".number_format($grand_total,0,",","."), 0, 0, 'L');



$pdf->Output();