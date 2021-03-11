<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/KhachHang.php');
$product = new KhachHang($conn);
$product->editClient($_POST);


