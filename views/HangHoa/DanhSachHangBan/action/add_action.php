<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$product = new HangHoa($conn);

//var_dump($_POST['add_prod']); die;
if( !empty($_POST['add_prod']) )
{ 
   $product->themProd();//var_dump ( $_SESSION['error'] );die;
   echo  "<script>window.history.go(-1); </script>";

}