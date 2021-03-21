<?php
ini_set('mssql.charset', 'UTF-8');
class DbConnection {

		protected $conn;

		function __construct() {
			try{
				$this->conn = new PDO("odbc:Driver={SQL Server}; Server=DELL-PC\SQLEXPRESS; Port=14330; Database=SPA_SAIGONDEP; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
				
				$this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
				$this->conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC );
				$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
			catch(Exception $e){
                throw new Exception($e->getMessage());   
            }			
		
		}
		


}

class clsKTV  {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
	}
	
	public function getKTVList()
	{
		$sql = "SELECT * FROM tblDMNhanVien Where NhomNhanVien in (Select Ma from tblDMNhomNhanVien Where IsDieuTour = 1)";
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

	public function insertNewKTV( $ma_nv, $ten_nv, $ma_the, $nhom_nv)
	{	
		$ten_nv = htmlentities(trim(strip_tags($ten_nv)),ENT_QUOTES,'utf-8');

		$sql_1 = "INSERT INTO tblDMNhanVien ( MaNV, TenNV, MaThe, NhomNhanVien	) VALUES( '$ma_nv', N'$ten_nv', N'$ma_the', '$nhom_nv' )  ";
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

	public function getKTVInfo( $ma_nv )
	{
		$sql = "SELECT * FROM tblDMNhanVien Where MaNV='$ma_nv'";
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

	public function updateKTV( $ma_nv, $ten_nv, $nhom_nv)
	{	
		$ma_nv = htmlentities(trim(strip_tags($ma_nv)),ENT_QUOTES,'utf-8');
		$ten_nv = htmlentities(trim(strip_tags($ten_nv)),ENT_QUOTES,'utf-8');
		$nhom_nv = htmlentities(trim(strip_tags($nhom_nv)),ENT_QUOTES,'utf-8');

		$sql_1 = "UPDATE tblDMNhanVien SET  MaNV = '$ma_nv', TenNV = N'$ten_nv', NhomNhanVien = '$nhom_nv'	WHERE MaNV = '$ma_nv'";
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

	public function deleteKTV( $ma_nv )
	{	
		$sql_1 = "DELETE FROM tblDMNhanVien WHERE MaNV = '$ma_nv' ";
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


	public function getAllKTV()
	{

		$sql="with t1 as ( select 
				b.Ten as TenNhomNV, a.MaNV, a.TenNV, NhomNhanVien, MaThe, 
				GhiChuNV, 
				--SourceHinhAnh, HinhAnhTemp, 
				GhiChuDichVu, ThuTuDieuTour, c.GioBatDau, c.GioKetThuc, c.GhiChu, d.MaPhieuDieuTour, d.MaBanPhong, d.TenHangBan, d.GioThucHien, e.SoLanPhucVu, e.SoSaoDuocYeuCau   
				from tblDMNhanVien a
				left join tblDMNhomNhanVien b on a.NhomNhanVien = b.Ma		
				left join (Select MaNV, ThuTuDieuTour, GioBatDau, GioKetThuc, GhiChu from tblHR_LichDieuTour where ThuTuDieuTour > 0 and Ngay = '".intval(date('d'))."' and Thang = '".intval(date('m'))."' and Nam = '".intval(date('Y'))."') c on c.MaNV = a.MaNV 
				left join (Select * from tblTheoDoiPhucVuSpa_ChiTiet Where Ngay like '".date('Y-m-d')."') d On a.MaNV = d.MaNV 
				left join (Select * from tblTheoDoiPhucVuSpa Where Ngay like '".date('Y-m-d')."') e On a.MaNV = e.MaNV 
				where NhomNhanVien in (Select Ma from tblDMNhomNhanVien where IsDieuTour = 1)
				)
				SELECT * from t1 Order by NhomNhanVien";
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

	public function getKTVGroup() {
		$sql = 'select Ma, Ten from tblDMNhomNhanVien where IsDieuTour = 1';
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