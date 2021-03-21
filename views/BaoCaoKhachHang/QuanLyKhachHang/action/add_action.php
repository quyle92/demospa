<?php 

use Lib\KhachHang;
session_start();
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$client = new KhachHang($conn);

if( !empty($_POST['add_client']) )
{ 
   $client->addClient();//var_dump ( $_SESSION['error'] );die;
   echo  "<script>window.history.go(-1); </script>";

}