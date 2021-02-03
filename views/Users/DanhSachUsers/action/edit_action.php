<?php 
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/Users.php');
session_start();
$user = new Users($conn); 
//var_dump($_POST['edit_user']);die;
if( !empty($_POST['edit_user']) )
{
  $edit_user = $user->edit($_POST);
  echo  "<script>window.history.go(-1); </script>";
}