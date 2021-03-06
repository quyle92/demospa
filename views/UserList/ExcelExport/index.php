<?php 
require_once('helper/security.php');
date_default_timezone_set('Asia/Bangkok');
setlocale(LC_ALL, "en_US.UTF-8");
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
  $i = 0;
  $rs = $data['users'];
  foreach (  $rs as $r ) {
    if ($i == 0){
      foreach( $r as $key => $value){
        if($key !== 'MaNV') $col_name[] = $key;
        //$col_val[$i] = $value;
      }
    }
    $col_val[$i] = array(
        $r['STT'],
        $r['TenSD'],
        $r['TenNV'],
        unserialize( $r['BaoCaoDuocXem'] )
        //(!is_array(unserialize( $r['BaoCaoDuocXem'])) ?"" : implode(", ", (array) unserialize( $r['BaoCaoDuocXem'] ) ) )
    );
    $i++;
  }
  //pr(array($col_name));//die;


function convertTitle(&$value, $key) {
  if($value == 'TenSD') $value = 'ID Nhân Viên';
  if($value == 'TenNV') $value = 'Chức Vụ';
  if($value == 'BaoCaoDuocXem') $value = 'Báo Cáo';
  $value = stripUnicode($value); 
}

array_walk($col_name, "convertTitle"); 

function convertReport(&$value, $key) { 

    foreach($value as $k => &$v)
    {

        if( $k == 3 && is_array($v) )
        {
          foreach($v as &$report){
            //make baocao into Báo Cáo
            $report = Controller_Users_DanhSachUsers::layBaoCao($report);
            $report = stripUnicode($report);
          }
          unset($report);
          // make array("a" , "b") into (string) "a,b"
          $v = implode(", ", $v );
          
        }
      
    }
    unset($v);
  
}

array_walk($col_val, "convertReport"); 

$data =  array_merge(array($col_name), $col_val );

//pr($data);die;
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
header("Content-Type: text/vnd.ms-excel; charset= UTF-16LE");

$out = fopen("php://output", 'w+');
fputs($out, "\xEF\xBB\xBF"); // this is UTF-8 BOM

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

//open this: https://stackoverflow.com/a/6488070/11297747
?>


