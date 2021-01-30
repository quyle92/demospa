<?php
$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = explode('/',$p)[0];
if( !isset($_SESSION['MaNV'])  )
{	
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');exit();
}
// elseif ($_SESSION['MaNV'] !== 'HDQT')
// {
// 	die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');exit();
// }

if( $_SESSION['MaNV'] !== 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
{
	die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');exit();

}