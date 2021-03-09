<?php
ini_set('mssql.charset', 'UTF-8');
class DbConnection {

		protected $conn;

		function __construct() {
			try{
				$this->conn = new PDO("odbc:Driver={SQL Server}; Server=DELL-PC\SQLEXPRESS; Port=14330; Database=SPA_SAIGONDEP; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
				
				$this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
				$this->conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
				$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
			catch(Exception $e){
                throw new Exception($e->getMessage());   
            }			
		
		}
		


}
require_once('lib/General.php');

class KhachHang extends General {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
	}

	function order_chitiet( $orderID )
	{
		$sql = "SELECT  * FROM tblOrderChiTiet where OrderID='$orderID'";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	function order_in_process(){
		$sql = "SELECT  * FROM [tblOrder] WHERE TrangThai = 0  ORDER BY OrderID ASC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	} 

	function list_items_in_order( $orderID){
		$sql = "SELECT  * FROM [tblOrderChiTiet] WHERE OrderID = '$orderID' ORDER BY OrderID DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	} 

	public function getCustomersList()
	{
		$sql = "SELECT * FROM [tblDMKHNCC] ";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function insertNewClient( $client_name, $client_address, $client_tel)
	{	
		$stt = 0;
		$sql = "SELECT max(substring(MaDoiTuong,11,5)) FROM [tblDMKHNCC]";
		$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		$r = sqlsrv_fetch_array($rs);
		$stt = ++$r[0];

		$date = date("yy-m");//2020-11
		$date = substr($date,0,4) . substr($date,5,2);
		$ma_doi_tuong =  $_SESSION['MaTrungTam'] . "1" . $date . "-" . $stt;

		$ten_doi_tuong = htmlentities(trim(strip_tags($client_name)),ENT_QUOTES,'utf-8');
		$dia_chi = htmlentities(trim(strip_tags($client_address)),ENT_QUOTES,'utf-8');
		$dien_thoai = htmlentities(trim(strip_tags($client_tel)),ENT_QUOTES,'utf-8');

		$sql_1 = "INSERT INTO [tblDMKHNCC] ( MaDoiTuong, TenDoiTuong, DiaChi, DienThoai	) VALUES( '$ma_doi_tuong', N'$ten_doi_tuong', N'$dia_chi', '$dien_thoai' )  ";
		try
		{
			$rs_1 = $this->conn->query($sql);

			if( !$rs_1 ){
				$_SESSION['insert_error'] = "Insert failed...";
			}
			else
			{
				$_SESSION['insert_success'] = "Inserted successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientInfo( $ma_doi_tuong )
	{
		$sql = "SELECT * FROM [tblDMKHNCC] Where [MaDoiTuong]='$ma_doi_tuong'";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function updateClient( $client_id, $client_name, $client_address, $client_tel)
	{	
		$ma_doi_tuong = htmlentities(trim(strip_tags($client_id)),ENT_QUOTES,'utf-8');
		$ten_doi_tuong = htmlentities(trim(strip_tags($client_name)),ENT_QUOTES,'utf-8');
		$dia_chi = htmlentities(trim(strip_tags($client_address)),ENT_QUOTES,'utf-8');
		$dien_thoai = htmlentities(trim(strip_tags($client_tel)),ENT_QUOTES,'utf-8');

		$sql_1 = "UPDATE [tblDMKHNCC] SET  MaDoiTuong = '$ma_doi_tuong', TenDoiTuong = N'$ten_doi_tuong', DiaChi = '$dia_chi', DienThoai = '$dien_thoai'	WHERE [MaDoiTuong] = '$ma_doi_tuong' ";
		try
		{
			$rs_1 = $this->conn->query($sql);

			if( !$rs_1 ){
				$_SESSION['update_error'] = "Update failed...";
			}
			else
			{
				$_SESSION['update_success'] = "Update successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function deleteClient( $client_id )
	{	
		$sql_1 = "DELETE FROM [tblDMKHNCC] WHERE [MaDoiTuong] = '$client_id' ";
		try
		{
			$rs_1 = $this->conn->query($sql);

			if( !$rs_1 ){
				$_SESSION['delete_error'] = "Delete failed...";
			}
			else
			{
				$_SESSION['delete_success'] = "Delete successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientList()
	{
		$sql="select a.MaDoiTuong, a.TenDoiTuong, a.DienThoai, a.DiaChi, a.MaNhomKH, a.GhiChu from tblDMKHNCC a left join tblDMNhomKH b on a.MaNhomKH = b.Ma Order by a.MaDoiTuong";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

			return $rs;
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getBillHistory( $client_id )
	{
		$sql = "SELECT  MaLichSuPhieu, substring( Convert(varchar,GioVao,105),0,11 ) as GioVao, TienThucTra FROM [tblLichSuPhieu] WHERE MaKhachHang = '$client_id' ORDER BY substring( Convert(varchar,GioVao,105),0,11 ) DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getAllClients()
	{

		$sql="with t1 as ( select 
				b.MaDoiTuong, TenDoiTuong, MaLichSuPhieu, TienThucTra, 
				GioVao, MaNhomKH
				,DienThoai, DiaChi, b.GhiChu, b.MaNhanVien
				from tblLichSuPhieu a
				right join tblDMKHNCC b on a.MaKhachHang = b.MaDoiTuong		
				left join tblDMNhomKH c on b.MaNhomKH = c.Ma 
				)
				SELECT * from t1   
				--where MaDoiTuong='01-201909-001' or MaDoiTuong='01-201910-201'
				Order by  MaDoiTuong, GioVao DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientsWithCard( $tungay, $denngay, $tugio, $dengio )
	{
		   $sql = " SELECT a.*, b.*, c.* FROM  [tblTheVIP_GhiNoDV] a
		 	JOIN [tblKhachHang_TheVip] b ON a.MaTheVip = b.MaTheVip
		 	JOIN [tblDMKHNCC] c ON b.MaKhachHang = c.[MaDoiTuong]
			Where substring( Convert(varchar,isnull([NgayQuanHe],getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'";

		try
		{

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getClientAppointments( $tungay, $denngay, $tugio, $dengio )
	{
		$sql = " SELECT a.*, b.* FROM [tblKhachHangBooking] a JOIN tblDMNhanVien b ON a.MaNV = b.MaNV
			Where substring( Convert(varchar,isnull(GioBatDau,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'
			";

		try
		{

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getMaNhomKH()
	{
		$sql = "SELECT * from tblDMNhomKH";

		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	public function addClient()
	{	
		$flag = true;

		$client_id      = $this->generateClientID();	
		$client_name    = htmlentities(trim(strip_tags($_POST['client_name'])),ENT_QUOTES,'utf-8');
		$client_tel     = htmlentities(trim(strip_tags($_POST['client_tel'])),ENT_QUOTES,'utf-8');
		$client_address = htmlentities(trim(strip_tags($_POST['client_address'])),ENT_QUOTES,'utf-8');
		$client_group   = htmlentities(trim(strip_tags($_POST['client_group'])),ENT_QUOTES,'utf-8');
		$client_notes   = htmlentities(trim(strip_tags($_POST['client_notes'])),ENT_QUOTES,'utf-8');

		if( empty($client_name) )
		{
			$_SESSION['error']['empty_clientName'] = "Client name was missing!";
			$flag = false;
		}

		if( empty($client_tel) )
		{
			$_SESSION['error']['empty_clientTel'] = "Client phone number was missing!";
			$flag = false;
		}

		if( empty($client_group) )
		{
			$_SESSION['error']['empty_clientGroup'] = "Client group was not selected!";
			$flag = false;
		}
	}



}