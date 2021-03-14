<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/KhachHang.php');
$productCat = new KhachHang($conn);

if( ! empty($_GET['xoaClient']) )
{ 	
   $productCat->xoaClient($_GET['xoaClient']);
   echo  "<script>window.history.go(-1); </script>";

}