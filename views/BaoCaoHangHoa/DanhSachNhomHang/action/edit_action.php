<?php 

use Lib\HangHoa;
session_start();
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$product = new HangHoa($conn);

if( !empty($_POST['edit_cat']) )
{ 
  $product->edit();//var_dump ( $_SESSION['error'] );
  //die;
  echo  "<script>window.history.go(-1); </script>";
}

