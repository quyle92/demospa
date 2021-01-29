<?php
class Model extends DB{
 
	public function getUsersList()
	{
		 $sql = "SELECT distinct TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [tblDSNguoiSD] a,  [tblDMNhanVien] b, [tblDMBaoCao] c where a.MaNhanVien = b.MaNV ";
		try{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			
			return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layTatCaBaoCao(){
		$sql = "SELECT top 3 * FROM [tblDMBaoCao] ";
		try {
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
			
				return $rs;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layBaoCao( $ma_bao_cao ){
		$sql = "SELECT * FROM [tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
		try {
			$rs = $this->conn->query($sql)->fetch();
				
				return $rs['TenBaoCao'];
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function them($user_info)
	{	// var_dump(  $user_info);die;
		$username =  htmlentities(trim(strip_tags($user_info['username'])),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($user_info['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($user_info['confirm_password'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($user_info['maNV'])),ENT_QUOTES,'utf-8');

		if( $password !== $confirm_password ){var_dump("confirm_password: " . $password);die;
			$_SESSION['password_mismatch'] = -1;
			// header('Location:javascript://history.go(-1)');
			// exit();
			echo  "<script>window.history.go(-1); </script>";
		}

		$report_arr = serialize( $user_info['report_arr'] ); 
		//$report_arr = htmlentities(trim(strip_tags($report_arr)),ENT_QUOTES,'utf-8');
		//echo $report_arr; die;
		if ( $username != "" && $password != "" && $report_arr != "" )
		{//var_dump("INSERT_INTO: " .$password);die;
			echo $sql="INSERT INTO [tblDSNguoiSD] ( [TenSD], [MaNhanVien],
			   [MatKhau],[KiemTraSD],[DangSD],[TamNgung],[KhongDoi],[SuDungDacBiet], [BaoCaoDuocXem]) VALUES ( '$username', '$maNV', PWDENCRYPT('$password'), 0,0,0,0,0, '$report_arr' )"; 

			try{
			 		$rs = $this->conn->query($sql);
			 		$_SESSION['signup_success'] = 1;
					//header('location:javascript://history.go(-1)');exit();
					echo  "<script>window.history.go(-1); </script>";
					
				}

			catch(Exception $e) 
				{ 	
					echo $e->getMessage();
					$_SESSION['signup_success'] = 0;
					//header('location:javascript://history.go(-1)');exit();
					echo  "<script>window.history.go(-1); </script>";
				}

		} else {var_dump("signup_success = 0: " .$password);die;
		 	//throw new \Exception('Required field(s) missing. Please try again.');
		 	$_SESSION['signup_success'] = 0;
		 	//header('location:javascript://history.go(-1)');exit();
		 	echo  "<script>window.history.go(-1); </script>";
		}


	}

}
?>