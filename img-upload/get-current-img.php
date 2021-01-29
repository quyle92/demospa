<?php
require('../lib/db.php');
require('../lib/ORDER_KTV.php');
require('../functions/lichsuphieu.php');
session_start();

$order_ktv = new ORDER_KTV();



if(isset($_POST['ktv'])){ 
 
	echo $maktv = $_POST['ktv'];
	$_SESSION['maktv'] = $maktv;
	$_SESSION['ten_ktv'] = $order_ktv->getTenKTV( $maktv );

    // $pictures = $order_ktv->getKTVPicsByID( $maktv );  	

    if ( strlen( $_SESSION['back'] ) > 0 ){
		$back= $_SESSION['back']; 
		unset($_SESSION['back']);
		header("location:$back");
	} 
	else header("location: ../index.php");
}