<?php

use Lib\Users;
session_start();
$conn =  DBConnect();
$user = new Users($conn); 
$rs = $user->doiMatKhau();
echo  "<script>window.history.go(-1); </script>";