<?php 
session_start();
//require_once('./helper/security.php');
require_once('lib/db.php');
require_once('lib/NhanVien.php');
$ktv = new NhanVien($conn);
var_dump($_POST);die;
if( isset( $_POST['MaNV'] ) )
{     
	$rs =  $ktv->updateKTV( $_GET['ma_kvt'] );
}


