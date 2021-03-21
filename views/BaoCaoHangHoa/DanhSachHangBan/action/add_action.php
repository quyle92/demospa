<?php 
session_start();
use Lib\HangHoa;

require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$product = new HangHoa($conn);

//var_dump($_POST['add_prod']); die;
if( !empty($_POST['add_prod']) )
{ 
   $product->themProd();//var_dump ( $_SESSION['error'] );die;
   echo  "<script>window.history.go(-1); </script>";

}