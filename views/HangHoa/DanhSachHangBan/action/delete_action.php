<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$product = new HangHoa($conn);

if(!empty($_GET['xoaProd']) )
{ 	
   $product->xoaProd($_GET['xoaProd']);
   echo  "<script>window.history.go(-1); </script>";

}