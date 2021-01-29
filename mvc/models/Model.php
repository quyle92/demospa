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
		//var_dump(  $this->checkUser($username) );die;
		if( $this->checkUser($username) == true)
		{
			$_SESSION['duplicate_username'] = -1;
			echo  "<script>window.history.go(-1); </script>";
			return;
		};

		$password = htmlentities(trim(strip_tags($user_info['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($user_info['confirm_password'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($user_info['maNV'])),ENT_QUOTES,'utf-8');

		$report_arr = isset( $user_info['report_arr'] ) ? serialize( $user_info['report_arr'] )  : array(); 

		if( empty( $password ) || $password !== $confirm_password ){//var_dump("confirm_password: " . $password);die;

			$_SESSION['password_mismatch'] = -1;
			$_SESSION['username'] = $username;
			$_SESSION['maNV'] = $maNV;
			$_SESSION['report_arr'] = unserialize($report_arr);
			// header('Location:javascript://history.go(-1)');
			// exit();
			echo  "<script>window.history.go(-1); </script>";
			return;
		}

		
		//$report_arr = htmlentities(trim(strip_tags($report_arr)),ENT_QUOTES,'utf-8');
		//echo $report_arr; die;
		if ( $username != "" && $password != "" && $report_arr != "" )
		{//var_dump("INSERT_INTO: " .$password);die;
			 $sql="INSERT INTO [tblDSNguoiSD] ( [TenSD], [MaNhanVien],
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

		} else {//var_dump("signup_success = 0: " .$password);die;
		 	//throw new \Exception('Required field(s) missing. Please try again.');
		 	$_SESSION['signup_success'] = 0;
		 	//header('location:javascript://history.go(-1)');exit();
		 	echo  "<script>window.history.go(-1); </script>";
		}


	}

	protected function checkUser($username)
	{
		$sql = "SELECT * FROM [tblDSNguoiSD] WHERE [TenSD] = '$username' ";
		try {
			$rs = $this->conn->query($sql)->fetch();
				
			if($rs) 
				return true;
			else
				return false;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function edit($user_info)
	{	 //var_dump(  $user_info);die;
		$username =  htmlentities(trim(strip_tags($user_info['username'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($user_info['maNV'])),ENT_QUOTES,'utf-8');

		$report_arr = isset( $user_info['report_arr'] ) ? serialize( $user_info['report_arr'] )  : array(); 
		
		if ( $report_arr != "" )
		{//var_dump("INSERT_INTO: " .$password);die;
			$sql="UPDATE [tblDSNguoiSD] SET  [MaNhanVien] = '$maNV', [BaoCaoDuocXem] = '$report_arr'  Where [TenSD]= '$username'";
			//die;

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

		} else {//var_dump("signup_success = 0: " .$password);die;
		 	//throw new \Exception('Required field(s) missing. Please try again.');
		 	$_SESSION['signup_success'] = 0;
		 	//header('location:javascript://history.go(-1)');exit();
		 	echo  "<script>window.history.go(-1); </script>";
		}


	}

	public function editWithPassword($user_info)
	{	// var_dump(  $user_info);die;
		$username =  htmlentities(trim(strip_tags($user_info['username'])),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($user_info['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($user_info['confirm_password'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($user_info['maNV'])),ENT_QUOTES,'utf-8');

		$report_arr = isset( $user_info['report_arr'] ) ? serialize( $user_info['report_arr'] )  : array(); 

		if( empty( $password ) || $password !== $confirm_password ){//var_dump("confirm_password: " . $password);die;

			$_SESSION['password_mismatch'] = -1;
			$_SESSION['maNV'] = $maNV;
			$_SESSION['report_arr'] = unserialize($report_arr);
			// header('Location:javascript://history.go(-1)');
			// exit();
			echo  "<script>window.history.go(-1); </script>";
			return;
		}

		if (  $password != "" && $report_arr != "" )
		{//var_dump("INSERT_INTO: " .$password);die;
			 $sql="UPDATE [tblDSNguoiSD] SET  [MaNhanVien] = '$maNV', [MatKhau] = PWDENCRYPT('$password'), [BaoCaoDuocXem] = '$report_arr' Where [TenSD]= '$username'";

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

		} else {//var_dump("signup_success = 0: " .$password);die;
		 	//throw new \Exception('Required field(s) missing. Please try again.');
		 	$_SESSION['signup_success'] = 0;
		 	//header('location:javascript://history.go(-1)');exit();
		 	echo  "<script>window.history.go(-1); </script>";
		}


	}

	public function xoaUser( $tenSD ){
		//$tenSD = implode
		 $sql = "DELETE FROM  [tblDSNguoiSD] where [TenSD] = '$tenSD'";
		try{
			$rs = $this->conn->query($sql);
			echo  "<script>window.history.go(-1); </script>";
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function doiMatKhau($user_info)
    {	
    	$username =  htmlentities(trim(strip_tags($user_info['username'])),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($user_info['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($user_info['confirm_password'])),ENT_QUOTES,'utf-8');

		if( empty( $password ) || $password !== $confirm_password ){//var_dump("confirm_password: " . $password);die;

			$_SESSION['password_mismatch'] = -1;

			return;
		}

    	$sql="UPDATE [tblDSNguoiSD] SET  [MatKhau] = PWDENCRYPT('$password') Where [TenSD]= '$username'";

		try{
		 		$rs = $this->conn->query($sql);//var_dump($rs);die;
		 		$_SESSION['change_success'] = 1; //var_dump($_SESSION['change_success']);die;
				//header('location:javascript://history.go(-1)');exit();
				//echo  "<script>window.history.go(-1); </script>";
					
			}

		catch(Exception $e) 
			{ 	
				echo $e->getMessage();
				$_SESSION['change_success'] = 0;
				//header('location:javascript://history.go(-1)');exit();
				//echo  "<script>window.history.go(-1); </script>";
			}

    }


}
?>