<?php 

use Lib\HangHoa;
session_start();
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$product = new HangHoa($conn);

if(!empty($_GET['xoaCat']) )
{ 	
   $product->xoaCat($_GET['xoaCat']);
   echo  "<script>window.history.go(-1); </script>";

}