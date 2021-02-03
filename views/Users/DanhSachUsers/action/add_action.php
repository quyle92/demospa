<?php 
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/Users.php');
session_start();
$user = new Users($conn); 

// var_dump($_POST['add_user']); die;
if(!empty($_POST['add_user']) )
{ 
   $add_user = $user->them();//var_dump($_SESSION['password_mismatch']);die();
   echo  "<script>window.history.go(-1); </script>";

}