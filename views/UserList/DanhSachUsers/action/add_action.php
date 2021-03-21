<?php 
session_start();
use Lib\Users;
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();

$user = new Users($conn); 

// var_dump($_POST['add_user']); die;
if(!empty($_POST['add_user']) )
{ 
   $add_user = $user->them();//var_dump($_SESSION['error']['password_mismatch']);die();
   echo  "<script>window.history.go(-1); </script>";

}