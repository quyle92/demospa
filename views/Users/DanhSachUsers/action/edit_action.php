<?php 
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/Users.php');
session_start();
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
   echo  "<script>window.history.go(-1); </script>";

}