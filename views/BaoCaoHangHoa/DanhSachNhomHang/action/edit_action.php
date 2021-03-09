<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$productCat = new HangHoa($conn); 
//var_dump($_POST['edit_user']);die;
if( !empty($_POST['edit_cat']) )
{ 
  $productCat->edit();//var_dump ( $_SESSION['error'] );
  //die;
  echo  "<script>window.history.go(-1); </script>";
}

