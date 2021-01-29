<?php 
require('lib/db.php');
require('lib/clsKhachHang.php');
@session_start();
$client = new clsKhachHang($conn);
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

	$rs = $client->getClientList();
	for ($i = 0; $i < sqlsrv_num_rows($rs); $i++) {
		$client_list = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
		if ($i == 0){
			foreach( $client_list as $key => $value){
				$col_name[] = $key;
				$col_val[$i] = $value;
			}
		}
		$col_val[$i] = array(
		
				$client_list['MaDoiTuong'],
				$client_list['TenDoiTuong'],
				$client_list['DienThoai'],
				$client_list['DiaChi'],
				$client_list['MaNhomKH'],
				$client_list['GhiChu']

		);
		//var_dump(array($col_val));die;
	}

	$data =  array($col_name) + $col_val;
	//print_r($data);die;
	
  function cleanData(&$str)
  {

    // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';

    // force certain number/date formats to be imported as strings
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }

    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

    }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/vnd.ms-excel; charset=UTF-8");

  $out = fopen("php://output", 'w+');
  fwrite($out, "\xEF\xBB\xBF"); // this is UTF-8 BOM

  // $flag = false;
  foreach($data as $row) {
    // if(!$flag) {
    //   // display field/column names as first row
    //   fputcsv($out, array_keys($row), ',', '"');
    //   $flag = true;
    // }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ",");
  }

  fclose($out);
  exit;
?>
