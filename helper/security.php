<?php
$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
//var_dump($bao_cao_duoc_xem );var_dump($_SESSION['MaNV']);die;
if( !isset($_SESSION['MaNV'])  )
{
   die('<script> 
   	alert("Bạn ko được quyền truy cập vào đây!");
   	 setTimeout(
        function(){
            window.location = "../../login.php" 
        },
    100);
   	</script>');
}

//if the page is DoiMatKhau, then no need further investigation as it is not a kind of report.
if( explode('/', $p)[1] === 'DoiMatKhau' ){
  
  return;

}

if( $_SESSION['MaNV'] !== 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
{
	die('<script> 
   	alert("Bạn ko được quyền truy cập vào đây!");
   	 setTimeout(
        function(){
            window.location = "../../login.php" 
        },
    100);
   	</script>');
}

// if (!isset($_SESSION['CREATED'])) {
//     $_SESSION['CREATED'] = time();
// } elseif (isset($_SESSION['CREATED']) && (time() - $_SESSION['CREATED'] > 2)) {
//     // last request was more than 30 minutes ago
//     unset($_SESSION['MaNV']);
//     unset($_SESSION['CREATED']);
//     setcookie(session_name(), '', time() - 2592000, '/'); 
//     die('<script> 
//     alert("Phiên đăng nhập đã hết! Vui lòng login lại!");
//      setTimeout(
//         function(){
//             window.location = "../../../login.php" 
//         },
//     100);
//     </script>');
// }
