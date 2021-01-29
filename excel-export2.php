<?php 
require('lib/db.php');
require('lib/KHACHHANG.php');
@session_start();
$client = new KHACHHANG($conn);
date_default_timezone_set('Asia/Bangkok');


  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.

  // $data = array(
  //   array("firstname" => "Mary", "lastname" => "Johnson", "age" => 25),
  //   array("firstname" => "Amanda", "lastname" => "Miller", "age" => 18),
  //   array("firstname" => "James", "lastname" => "Brown", "age" => 31),
  //   array("firstname" => "Patricia", "lastname" => "Williams", "age" => 7),
  //   array("firstname" => "Michael", "lastname" => "Davis", "age" => 43),
  //   array("firstname" => "Sarah", "lastname" => "Miller", "age" => 24),
  //   array("firstname" => "Patrick", "lastname" => "Miller", "age" => 27)
  // );
	$col_name = array();
	$col_val = array();
  $data = "";
	$rs = $client->getClientList();
	for ($i = 0; $i < sqlsrv_num_rows($rs); $i++) {
		$client_list = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
		if ($i == 0){
			foreach( $client_list as $key => $value){
				$col_name[] = $key;
				$col_val[$i] = $value;
			}
		}
		$col_val = array(
		
			'order_code'     =>	$client_list['MaDoiTuong'],
			'customer_name'     =>	$client_list['TenDoiTuong'],
			'order_code'     =>	$client_list['DienThoai'],
				'modify_date'    =>$client_list['DiaChi'],
				'modify_date'    =>$client_list['MaNhomKH'],
				'order_status'    =>$client_list['GhiChu']

		);
	  
    $data .= join("\t", $col_val)."\r\n";//var_dump($data);die;

	}
    header("Content-type: application/x-msdownload");
  header("Content-disposition: csv; filename=" . date("Y-m-d") .
  "_order_list.csv; size=".strlen($data));
  echo $data;
  exit();
	
?>
