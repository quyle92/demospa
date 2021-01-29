<?php
require('../lib/db.php');
require('../lib/ORDER_KTV.php');
require('../functions/lichsuphieu.php');
session_start();

$order_ktv = new ORDER_KTV();

if( isset($_POST['delete_pics']) ){ 
 
	$maktv = $_POST['maktv'];//var_dump($maktv);
	$pic_item_arr =  $_POST['pic_item'];//var_dump($pic_item_arr);
	$pics_remove = $order_ktv->deletePics( $maktv,  $pic_item_arr );
	//var_dump( $pics_remove );

	if ( strlen( $_SESSION['back'] ) > 0 ){
		$back= $_SESSION['back']; 
		unset($_SESSION['back']);
		header("location:$back");
	} 
	else header("location: ../index.php");


     
}