<?php 
session_start();
use Lib\Users;
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();

$user = new Users($conn); 
// var_dump($_POST['add_user']); die;
if(!empty($_GET['xoaUser']) )
{ 
   $add_user = $user->xoaUser($_GET['xoaUser']);
   echo  "<script>window.history.go(-1); </script>";

}