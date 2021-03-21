<?php 
session_start();
use Lib\HangHoa;

require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$product = new HangHoa($conn);
//var_dump($_POST['edit_prod']);die;
if( !empty($_POST['edit_prod']) )
{ 
  $product->editProd();//var_dump($_SESSION['fail']);die;
  echo  "<script>window.history.go(-1); </script>";
}

