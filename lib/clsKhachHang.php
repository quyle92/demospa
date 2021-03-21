<?php
namespace Lib;

use \ForceUTF8\Encoding;

class clsKhachHang{

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
	}

	public function getCustomersList()
	{
		$sql = "SELECT * FROM [tblDMKHNCC] WHERE LaKH = 1 ";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();	
		}
	}

	public function searchCustomer( $client_code, $client_name, $client_tel )
	{	

		if( $client_tel != NULL )
		{
			$sql = "SELECT * FROM [tblDMKHNCC] WHERE LaKH = 1 AND MaDoiTuong = '$client_code' OR TenDoiTuong = '$client_name' OR DienThoai = '$client_tel' ";
		}
		else
		{
			 $sql = "SELECT * FROM [tblDMKHNCC] WHERE LaKH = 1 AND MaDoiTuong = '$client_code' OR TenDoiTuong = '$client_name'";
		}

		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientInfo( $ma_doi_tuong )
	{
		$sql = "SELECT a.*, b.* FROM [tblDMKHNCC] a LEFT JOIN [tblKhachHang_TheVip] b ON a.MaDoiTuong = b.MaKhachHang
			 Where  LaKH = 1 AND [MaDoiTuong]='$ma_doi_tuong'";
		try
		{
			$rs = $this->conn->query($sql)->fetch(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( PDOException $e )
		{
			die("Failed to connect to DB: ". $e->getMessage());
		}
	}


	public function insertNewClient( $client_name, $client_address, $client_tel)
	{	
		$stt = 0;
		$sql = "SELECT max(substring(MaDoiTuong,11,5)) FROM [tblDMKHNCC]";
		$rs = $this->conn->query($sql)->fetchColumn();
		$stt = ++$rs;

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

	

	public function getClientInfo_LSPhieu( $malichsuphieu )
	{
		 $sql = "SELECT a.MaKhachHang, a.TenKhachHang, a.NhomKH, b.DienThoai, b.DiaChi, b.MaTheVip, b.NgayApDung, b.NgayKetThuc FROM tblLichSuPhieu a left join (
			Select e.MaDoiTuong, e.DienThoai, e.DiaChi, f.MaTheVip, f.NgayApDung, f.NgayKetThuc, f.NgungThe, 
			f.LoaiTheVip from tblDMKHNCC e left join tblKhachHang_TheVip f On e.MaDoiTuong = f.MaKhachHang
			) b
			 On a.MaKhachHang = b.MaDoiTuong Where a.MaLichSuPhieu='$malichsuphieu' 
			 Group by a.MaKhachHang, a.TenKhachHang,a.NhomKH, b.DienThoai, b.DiaChi, b.MaTheVip, b.NgayApDung, b.NgayKetThuc";

		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			die( $e->getMessage());
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
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

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
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
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
				SELECT * from t1 Order by  MaDoiTuong, GioVao DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}
}