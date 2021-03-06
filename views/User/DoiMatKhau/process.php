<?php
session_start();
require_once('helper/security.php');
require_once('lib/db.php');
require_once('lib/Users.php');
$user = new Users($conn); 
$rs = $user->doiMatKhau();
echo  "<script>window.history.go(-1); </script>";