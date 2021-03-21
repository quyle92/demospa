<?php 

use Lib\KhachHang;
session_start();
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$client = new KhachHang($conn);

if( ! empty($_GET['xoaClient']) )
{ 	
   $client->xoaClient($_GET['xoaClient']);
   echo  "<script>window.history.go(-1); </script>";

}