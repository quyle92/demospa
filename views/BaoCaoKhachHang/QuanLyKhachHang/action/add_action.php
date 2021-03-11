<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/KhachHang.php');
$product = new KhachHang($conn);

//var_dump($_POST['add_prod']); die;
if( !empty($_POST['add_client']) )
{ 
   $product->addClient();//var_dump ( $_SESSION['error'] );die;
   echo  "<script>window.history.go(-1); </script>";

}