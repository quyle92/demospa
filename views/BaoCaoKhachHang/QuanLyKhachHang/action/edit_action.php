<?php 

use Lib\KhachHang;
session_start();
require_once realpath('../../../../vendor/autoload.php');
$conn = DBConnect();
$client = new KhachHang($conn);
$client->editClient($_POST);


