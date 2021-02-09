<?php
require_once('lib/General.php');
class NhanVien extends General {

	/* Properties */
    private $conn;
    private $general;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
        $this->general = new General( $dbCon );
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

				    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				    
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
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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
		FROM [SPA_SENVANG].[dbo].tblHR_ChamCong a, [SPA_SENVANG].[dbo].tblDMNhanVien b WHERE a.MaNV = b.MaNV ";
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

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
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