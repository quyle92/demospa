<?php 

use Lib\HangHoa;
session_start();
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$product = new HangHoa($conn);

//var_dump($_POST); die;
if( !empty($_POST['add_cat']) )
{ 
  	$product->themCat();//var_dump ( $_SESSION['error'] );die;
   echo  "<script>window.history.go(-1); </script>";

}