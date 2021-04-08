<?php
namespace Lib;
use Lib\General;
class NhanVien extends General {

	/* Properties */
    private $conn;
    private $general;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
        $this->general = new General( $conn );
	}

	public function getNhanVien(){
		$sql = "";
		$sql .= "SELECT a.*, b.Ten as TenNhomNV, c.TenChucVu FROM tblDMNhanVien a LEFT JOIN tblDMNhomNhanVien b ON a.NhomNhanVien = b.Ma LEFT JOIN  tblDMChucVu c ON a.MaChucVu = c.MaChucVu  where a.DaNghiViec = 0 and a.MaVanTay  is not null  and a.MaVanTay <>''";

		$sql .= "SELECT count(*) as tongnhanvien FROM 
			( SELECT a.*, b.Ten as TenNhomNV, c.TenChucVu FROM tblDMNhanVien a LEFT JOIN tblDMNhomNhanVien b ON a.NhomNhanVien = b.Ma LEFT JOIN  tblDMChucVu c ON a.MaChucVu = c.MaChucVu  where a.DaNghiViec = 0 and a.MaVanTay  is not null  and a.MaVanTay <>'' ) t1";
		try 
			{
				$stmt = $this->conn->query($sql);

			  	$rowset =  array();

				do {

				    $rowset[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
				    
				} while ($stmt->nextRowset());

				return $rowset;

			}

		catch ( PDOException $error )
			{
				echo $error->getMessage();
			
			}

	}

	public function getTongHopTip()
	{
		$sql = "SELECT ISNULL(Sum(TongTien),0) as ThucNhan, ISNULL(SUM(a.TienChietKhau),0) as TienKhachTip 
		FROM tblPhieuThuChi a WHERE LoaiPhieu like 'CHH'";
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

	public function getTipTheoNV()
	{
		$sql = "SELECT Distinct a.MaNV, b.TenNV, ISNULL(Sum(a.TienChietKhau) OVER (Partition By a.MaNV ),0) as TienKhachTip, ISNULL(SUM(a.TongTien)  OVER (Partition By a.MaNV),0) as TienThucNhan 
		FROM tblPhieuThuChi a left join tblDMNhanVien b On a.MaNV = b.MaNV Where LoaiPhieu like 'CHH' and b.TenNV <> '' and b.TenNV is not null";
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

	public function getChamCong( $tuNgay, $denNgay )
	{
		$sql = "SELECT a.MaThe, Substring(Convert(varchar,isnull(a.GioVao,getdate()),8),1,5) as GioVao, 
		case when DATEDIFF(minute,ISNULL(a.GioVao,getdate()),ISNULL(a.GioRa,getdate())) = 0 then null else Substring(Convert(varchar,isnull(a.GioRa,getdate()),8),1,5) end as GioRa, a.MaNhanVien, b.TenNV, DATEDIFF(minute,ISNULL(a.GioVao,getdate()),ISNULL(a.GioRa,getdate())) as SoPhut FROM tblHR_QuetTheChamCong a, tblDMNhanVien b WHERE
		Convert(varchar,isnull(GioVao,getdate()),126) >= '$tuNgay' AND 
		Convert(varchar,isnull(GioVao,getdate()),126) <= '$denNgay'
		AND  a.MaNhanVien = b.MaNV Group by a.MaThe, a.GioVao, a.GioRa, a.MaNhanVien, b.TenNV Order by a.GioVao, a.MaNhanVien";
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

	public function getTongHopChamCong( $tuNgay, $denNgay )
	{	
		$sql = "";
		$sql = "SELECT a.MaNV, b.TenNV, a.Thang, a.Nam
		--, Sum(CongNgay) as CongNgay
		--, Sum(DiTreVeSom) as DiTreVeSom
		--, Sum(TangCa) as TangCa 
		FROM tblHR_ChamCong a, tblDMNhanVien b WHERE a.MaNV = b.MaNV ";
		$sql .= "and Ngay >= ? and Thang = ? and Nam = ? ";//(1)
		$sql .= "and Ngay <= ? and Thang = ? and Nam = ?";
		$sql .= " Group by a.MaNV, b.TenNV, a.Thang, a.Nam";
		try
		{	
			$stmt = $this->conn->prepare($sql);

			$a = intval( date("d",strtotime($tuNgay)) );
			$b = intval( date("m",strtotime($tuNgay)) );
			$c = intval( date("Y",strtotime($tuNgay)) );
			$x = intval( date("d",strtotime($denNgay)) );
			$y = intval( date("m",strtotime($denNgay)) );	
			$z = intval( date("Y",strtotime($denNgay)) );

			$stmt->bindParam(1, $a , PDO::PARAM_INT);
			$stmt->bindParam(2, $b , PDO::PARAM_INT);
			$stmt->bindParam(3, $c , PDO::PARAM_INT);
			$stmt->bindParam(4, $x , PDO::PARAM_INT);
			$stmt->bindParam(5, $y , PDO::PARAM_INT);
			$stmt->bindParam(6, $z , PDO::PARAM_INT);

			$stmt->execute();

			$rs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

		// $sql="with t1 as ( select 
		// 		b.Ten as TenNhomNV, a.MaNV, a.TenNV, NhomNhanVien, MaThe, 
		// 		GhiChuNV, 
		// 		--SourceHinhAnh, HinhAnhTemp, 
		// 		GhiChuDichVu, ThuTuDieuTour, c.GioBatDau, c.GioKetThuc, c.GhiChu, d.MaPhieuDieuTour, d.MaBanPhong, d.TenHangBan, d.GioThucHien, e.SoLanPhucVu, e.SoSaoDuocYeuCau   
		// 		from tblDMNhanVien a
		// 		left join tblDMNhomNhanVien b on a.NhomNhanVien = b.Ma		
		// 		left join (Select MaNV, ThuTuDieuTour, GioBatDau, GioKetThuc, GhiChu from tblHR_LichDieuTour where ThuTuDieuTour > 0 and Ngay = '2' and Thang = '10' and Nam = '2019') c on c.MaNV = a.MaNV 
		// 		left join (Select * from tblTheoDoiPhucVuSpa_ChiTiet Where Ngay like '".date('2019-10-01')."') d On a.MaNV = d.MaNV 
		// 		left join (Select * from tblTheoDoiPhucVuSpa Where Ngay like '".date('2019-10-01')."') e On a.MaNV = e.MaNV 
		// 		where NhomNhanVien in (Select Ma from tblDMNhomNhanVien where IsDieuTour = 1)
		// 		)
		// 		SELECT * from t1 Order by NhomNhanVien";
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

	public function getnhomNV()
	{
		$sql = "Select * from tblDMNhomNhanVien where IsDieuTour = 1";
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

	public function updateKTV( $params )
	{	
		$maktv = $params['MaNV'];
		$TenNV = $params['TenNV'];
		$NhomNhanVien = $params['NhomNhanVien'];
		$ThuTuDieuTour = $params['ThuTuDieuTour'];
		$SoLanPhucVu = $params['SoLanPhucVu'];
		$SoSaoDuocYeuCau = $params['SoSaoDuocYeuCau'];
		$GioBatDau = $params['GioBatDau'];
		$GioKetThuc = $params['GioKetThuc'];
		//var_dump ($GioBatDau);die;
		$sql = "
			UPDATE  [tblDMNhanVien] SET 
			[TenNV] =  N'$TenNV', 
			[NhomNhanVien] = '$NhomNhanVien'
			Where [MaNV] ='$maktv'

			UPDATE  [tblTheoDoiPhucVuSpa] SET 
			[SoLanPhucVu] =  '$SoLanPhucVu', 
			[SoSaoDuocYeuCau] = '$SoSaoDuocYeuCau'
			Where [MaNV] ='$maktv'
			
		";
		if( isset($GioBatDau) && isset($GioKetThuc) ){
			$sql .= "UPDATE  [tblHR_LichDieuTour] SET 
			[ThuTuDieuTour] = '$ThuTuDieuTour',
			[GioBatDau] =   CONVERT(DATETIME, '$GioBatDau'), 
			[GioKetThuc] = CONVERT(DATETIME, '$GioKetThuc')
			Where [MaNV] ='$maktv'";
		}
		try
		{
			$rs = $this->conn->query($sql);
			return $rs;

		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}

	}

	public function deleteKTV( $params )
	{	
		$maktv = $params['MaNV'];
		$sql = "DELETE FROM tblDMNhanVien WHERE MaNV = '$maktv'";
		// var_dump ($maktv );die;
		try
		{
			$rs = $this->conn->query($sql);
			return $rs;

		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function vaoCa( $maNV )
	{	
		// var_dump ($maNV);die;
	 $sql = "
	SET NOCOUNT ON;

	IF NOT EXISTS
		(
		    SELECT Top 1 GioBatDau, GioKetThuc from tblHR_LichDieuTour where MaNV like '$maNV' and  Ngay = DAY( GETDATE() ) and Thang = Month( GETDATE() ) and Nam = YEAR( GETDATE() ) Order by GioBatDau desc
		) 	
		BEGIN
	  		SELECT Top 1 GioBatDau, GioKetThuc from tblHR_LichDieuTour where MaNV like '$maNV' Order by GioBatDau desc
	   	END
	   	
	ELSE
		BEGIN
   			UPDATE tblHR_LichDieuTour SET ThuTuDieuTour = ThuTuDieuTour + 1 Where MaNV = '$maNV' and Ngay = DAY( GETDATE() ) and Thang = Month( GETDATE() ) and Nam = YEAR( GETDATE() )
   		END
   	";

		try
		{
			$rs = $this->conn->prepare($sql);
			$rs->execute();
			//echo $rs->rowCount();//-1: select | 0: update
			if( $rs->rowCount() === -1  )
			{	

				$r = $rs->fetch(\PDO::FETCH_ASSOC);
				$this->vaoCaMoi( $maNV, $r['GioBatDau'], $r['GioKetThuc'] );
			}
		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	protected function vaoCaMoi( $maNV, $giobatdau, $gioketthuc )
	{
		 $sql = "INSERT into tblHR_LichDieuTour(MaNV, Ngay, Thang, Nam, ThuTuDieuTour,GioBatDau, GioKetThuc) values('$maNV', DAY( GETDATE() ), Month( GETDATE() ), YEAR( GETDATE() ), 1 ,'$giobatdau','$gioketthuc')";
		try
		{
			$rs = $this->conn->query($sql);
			
		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function raCa( $maNV )
	{	
		$sql = "Update tblHR_LichDieuTour set ThuTuDieuTour = 0 where MaNV like '$maNV' and Ngay = DAY( GETDATE() ) and Thang = Month( GETDATE() ) and Nam = YEAR( GETDATE() )";
		try
		{
			$rs = $this->conn->query($sql);

		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function addKVT( $params )
	{	
		$message = [];
		$maNV = $params['maNV'];
		$tenNV = $params['tenNV'];
		$nhomNhanVien = $params['nhomNV'];
		$gioiTinh =  $params['gioiTinh'];
		//var_dump ( $gioiTinh);die;
		//bắt lỗi mã NV
		if ( empty($maNV) )
		{	
			 $message['empty_maNV'] = "Mã NV chưa điền.";
		}

		if ( $this->general->checkMaNV( $maNV ) === true )
		{	
			 $message['duplicate_maNV'] = "Mã NV đã tồn tại.";
		}

		//bắt lỗi tên NVPhucVu
		if ( empty($tenNV) )
		{	
			 $message['empty_tenNV'] = "Tên NV chưa điền.";
		}

		//bắt lỗi tên nhomNV
		if ( empty($nhomNhanVien) )
		{	
			 $message['empty_nhomNhanVien'] = "Nhóm NV chưa điền.";
		}


		//bắt lỗi tên gioiTinh
		if ( ! in_array( $gioiTinh, ['0','1'] )  )
		{	
			 $message['empty_gioiTinh'] = "Giói tính chưa điền.";
		}
		//var_dump ($message);die;
		if( count ( $message ) > 0 ) return $message;
		//sql 
		$sql = "INSERT INTO tblDMNhanVien (MaNV, TenNV, NhomNhanVien, GioiTinh, DaNghiViec, MaTrungTam)
		VALUES(:maNV, :tenNV, :nhomNhanVien, :gioiTinh, 0, 1) ";

		try
		{
			$stmt = $this->conn->prepare($sql);

			$stmt->bindParam('maNV', $maNV);
			$stmt->bindParam('tenNV', $tenNV);
			$stmt->bindParam('nhomNhanVien', $nhomNhanVien);
			$stmt->bindParam('gioiTinh', $gioiTinh);

			$stmt->execute();
			$count = $stmt->rowCount();
			$message['success'] = "Insert $count rows.\n";
			return $message;

		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

}

/**
 * Note
 */
//(1): nếu ko có khoảng trằng thì sẽ ra error: Must declare the scalar variable "@P3and"