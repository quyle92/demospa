<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$productCat = new HangHoa($conn);

// var_dump($_POST['add_cat']); die;
if( !empty($_POST['add_cat']) )
{ 
   $add_user = $productCat->them();//var_dump ( $_SESSION['error'] );die;
   echo  "<script>window.history.go(-1); </script>";

}