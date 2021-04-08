<?php
namespace Lib;

use Lib\General;

class Users extends General {

	/* Properties */
    private $conn;
    private $general;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
        $this->general = new General( $conn );
	}

	public function getUsersList()
	{
		 $sql = "SELECT  ROW_NUMBER() OVER(ORDER BY TenSD)  AS STT,  TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [tblDSNguoiSD] a,  [tblDMNhanVien] b where a.MaNhanVien = b.MaNV";
		try{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			
			return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layTatCaBaoCao(){
		$sql = "SELECT  * FROM [tblDMBaoCao] ";
		try {
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
			
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

	public function them()
	{	 
		$flag = true;

		$username =  htmlentities(trim(strip_tags($_POST['username'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($_POST['maNV'])),ENT_QUOTES,'utf-8');
		$report_arr = isset( $_POST['report_arr'] ) ? serialize( $_POST['report_arr'] )  : "";

		if( empty($username) )
		{
			$_SESSION['error']['empty_username'] = "Username is empty!";
			$flag = false;
		}
		elseif( $this->general->checkUser($username) == true)
		{
			$_SESSION['error']['duplicate_username'] = "Username already existed!";
			$flag = false;
		};

		$password = htmlentities(trim(strip_tags($_POST['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($_POST['confirm_password'])),ENT_QUOTES,'utf-8');
		
		if( empty( $password ) )
		{
			$_SESSION['error']['empty_password'] = "Password is empty!";
			$flag = false;
		}

		if( empty( $confirm_password ) )
		{
			$_SESSION['error']['empty_confirm_password'] = "Confirmed Password is empty!";
			$flag = false;
		}

		if(  $password !== $confirm_password )
		{
			
			$_SESSION['error']['password_mismatch'] = "Password mismatch...";
			$flag = false;
		}

		$_SESSION['username'] = $username;
		$_SESSION['maNV'] = $maNV;
		$_SESSION['report_arr'] = ( !empty($report_arr) ) ? unserialize($report_arr) : "";

		if ( $flag === true )
		{
			$sql="INSERT INTO [tblDSNguoiSD] ( [TenSD], [MaNhanVien],
			   [MatKhau],[KiemTraSD],[DangSD],[TamNgung],[KhongDoi],[SuDungDacBiet], [BaoCaoDuocXem]) VALUES ( '$username', '$maNV', PWDENCRYPT('$password'), 0,0,0,0,0, '$report_arr' )"; 

			try
			{
			 		$rs = $this->conn->query($sql);
			 		$_SESSION['add_success'] = "New  user added successfully...";
			}

			catch(Exception $e) 
			{ 	
				echo $e->getMessage();
				//return false;
			}

		}

	}

	

	public function edit()
	{	 //var_dump(  $user_info);die;
		$flag = true;
		$username =  htmlentities(trim(strip_tags($_POST['username'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($_POST['maNV'])),ENT_QUOTES,'utf-8');

		$report_arr = isset( $_POST['report_arr'] ) ? serialize( $_POST['report_arr'] )  : ''; 
		
		if ( $report_arr != "" )
		{//var_dump("INSERT_INTO: " .$password);die;
			$sql="UPDATE [tblDSNguoiSD] SET  [MaNhanVien] = '$maNV', [BaoCaoDuocXem] = '$report_arr'  Where [TenSD]= '$username'";
			//die;

			try{
			 		$rs = $this->conn->query($sql);
			 		$_SESSION['edit_success'] = "User edited successfully...";

							
				}

			catch(Exception $e) 
				{ 	
					echo $e->getMessage();//var_dump($_SESSION['edit_success']);die;	
				}

		} else {//var_dump("signup_success = 0: " .$password);die;
		 	//throw new \Exception('Required field(s) missing. Please try again.');
		 	$_SESSION['edit_success'] = 0;

		}


	}

	public function editWithPassword()
	{	
		$username =  htmlentities(trim(strip_tags($_POST['username'])),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($_POST['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($_POST['confirm_password'])),ENT_QUOTES,'utf-8');
		$maNV = htmlentities(trim(strip_tags($_POST['maNV'])),ENT_QUOTES,'utf-8');

		$report_arr = isset( $_POST['report_arr'] ) ? serialize( $_POST['report_arr'] )  : array(); 

		if( empty( $password ) )
		{
			$_SESSION['fail']['empty_password'] = "Password is empty!";
			$flag = false;
		}

		if( empty( $confirm_password ) )
		{
			$_SESSION['fail']['empty_confirm_password'] = "Confirmed Password is empty!";
			$flag = false;
		}

		if(  $password !== $confirm_password )
		{
			$_SESSION['fail']['password_mismatch'] = "Password mismatch...";
			$flag = false;
		}

		$_SESSION['username_edit'] = $username;
		$_SESSION['maNV'] = $maNV;
		$_SESSION['report_arr'] = ( !empty($report_arr) ) ? unserialize($report_arr) : "";

		if ( $flag === true )
		{
			 $sql="UPDATE [tblDSNguoiSD] SET  [MaNhanVien] = '$maNV', [MatKhau] = PWDENCRYPT('$password'), [BaoCaoDuocXem] = '$report_arr' Where [TenSD]= '$username'";

			try
			{
		 		$rs = $this->conn->query($sql);
		 		$_SESSION['edit_success'] = 1;
			}

			catch(Exception $e) 
			{ 	
				echo $e->getMessage();

			}

		} 

	}

	public function xoaUser( $tenSD )
	{
		if ( ! $tenSD ) throw new ErrorException;
		
		$tenSD = htmlentities(trim(strip_tags($tenSD)));
		$sql = "DELETE FROM  [tblDSNguoiSD] where [TenSD] = '$tenSD'";
		try{
			$rs = $this->conn->query($sql);
			$_SESSION['del_success'] == "User deleted successfully!";
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function doiMatKhau()
    {	
    	$username =  htmlentities(trim(strip_tags($_POST['username'])),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($_POST['password'])),ENT_QUOTES,'utf-8');
		$confirm_password = htmlentities(trim(strip_tags($_POST['confirm_password'])),ENT_QUOTES,'utf-8');

		if( empty( $password )  ){//var_dump("confirm_password: " . $password);die;

			$_SESSION['password_mismatch'] = -1;

			return;
		}

		if( empty( $password ) || $password !== $confirm_password ){//var_dump("confirm_password: " . $password);die;

			$_SESSION['password_mismatch'] = -2;

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