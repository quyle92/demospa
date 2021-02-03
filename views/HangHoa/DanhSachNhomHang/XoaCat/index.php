<?php
//require_once('helper/security.php');
require_once('lib/db.php');
require_once('lib/HangHoa.php');
$productCat = new HangHoa($conn);
//var_dump ($_GET['xoaCat']);die;
if ( isset($_GET['xoaCat']) )
{
	$newCat = $productCat->xoaCat($_GET['xoaCat']);
	//header('location:' . $p);
}