<?php
require('lib/db.php');
$conn = DBConnect();

session_start();
	$user=$_POST['username'];
	$pass=$_POST['password'];
	
	$sql="select PWDCOMPARE(:pass,MatKhau) as IsDungMatKhau, TenSD, b.MaNV, b.TenNV, BaoCaoDuocXem, b.MaTrungTam, c.TenTrungTam from tblDSNguoiSD a, tblDMNhanVien b, tblDMTrungTam c where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD like :user";
	
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
	$stmt->bindValue(':user', "%{$user}%");
	$stmt->execute();
	$r = $stmt->fetch();//var_dump($r);die;
	// $sql="select PWDCOMPARE('$pass',MatKhau) as IsDungMatKhau, TenSD, b.MaNV, b.TenNV, b.MaTrungTam, c.TenTrungTam from tblDSNguoiSD a, tblDMNhanVien b, tblDMTrungTam c where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD like '$user'";
	// $r = $conn->query($sql)->fetch();var_dump($r);die;
	
	if(($r)===false)
	{
?>
		<script>
			window.onload=function(){
		alert("Đăng nhập không thành công. Sai email hoặc mật khẩu");
			setTimeout('window.location="./login.php"',0);
		}
		</script>
<?php
	}
	else
	{
	 	
 
		if($r['IsDungMatKhau'])
		{
			$_SESSION['MaNV']=$r['MaNV']; $_SESSION['CREATED'] = time();
			$_SESSION['TenNV']=$r['TenNV'];
			$_SESSION['TenSD']=$r['TenSD'];
			$_SESSION['MaTrungTam']=$r['MaTrungTam'];
			$_SESSION['TenTrungTam']=$r['TenTrungTam']; //mb_convert_encoding($r['TenTrungTam'],'UTF-8', 'UTF-8');
			//$_SESSION['MaKhu'] = "";
			$_SESSION['BaoCaoDuocXem'] = unserialize( $r['BaoCaoDuocXem'] );

			header('location:views/BaoCaoBanHang/TangTret/');
		}
		else
		{
?>
			<script>
				window.onload=function(){
				alert("Đăng nhập không thành công. Sai mật khẩu");
				setTimeout('window.location="./login.php"',0);
				}
			</script>
<?php
		}
	}
?>
	
		
	