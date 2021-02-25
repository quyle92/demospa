<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$product = new HangHoa($conn); 
//var_dump($_POST['edit_prod']);die;
if( !empty($_POST['edit_prod']) )
{ 
  $product->editProd();//var_dump($_SESSION['fail']);die;
  echo  "<script>window.history.go(-1); </script>";
}

