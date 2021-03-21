<?php 
session_start();
use Lib\Users;
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();

$user = new Users($conn); 
 //var_dump($_POST); die;
if(!empty($_POST['edit_user']) &&  !empty($_POST['password']))
{ 
   $add_user = $user->editWithPassword();//var_dump($_SESSION['error']['password_mismatch']);die();
   echo  "<script>window.history.go(-1); </script>";

}
else
{ 
   $add_user = $user->edit();//var_dump($_SESSION['error']['password_mismatch']);die();
   //var_dump($_SESSION['edit_success']);die;
   echo  "<script>window.history.go(-1); </script>";

}