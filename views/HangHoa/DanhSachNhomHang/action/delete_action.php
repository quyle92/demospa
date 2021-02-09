<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$productCat = new HangHoa($conn);

if(!empty($_GET['xoaCat']) )
{ 	
   $productCat->xoaCat($_GET['xoaCat']);
   echo  "<script>window.history.go(-1); </script>";

}