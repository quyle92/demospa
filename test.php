<?php 
require('lib/db.php');
require('lib/KHACHHANG.php');
require('functions/lichsuphieu.php');

$admin = 'admin';
$sql="select * from tblDSNguoiSD Where TenSD like ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$admin]);//var_dump($rs);die;
//print_r($rs->errorInfo());
$r = $stmt->fetch();var_dump( $r );
//echo $r['TenSD'];
