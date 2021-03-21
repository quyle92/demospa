<?php 
session_start();
use Lib\HangHoa;

require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$product = new HangHoa($conn);

if(!empty($_GET['xoaProd']) )
{ 	
   $product->xoaProd($_GET['xoaProd']);
   echo  "<script>window.history.go(-1); </script>";

}