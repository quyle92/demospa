<?php 
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/Users.php');
session_start();
$user = new Users($conn); 

// var_dump($_POST['add_user']); die;
if(!empty($_GET['xoaUser']) )
{ 
   $add_user = $user->xoaUser($_GET['xoaUser']);
   echo  "<script>window.history.go(-1); </script>";

}