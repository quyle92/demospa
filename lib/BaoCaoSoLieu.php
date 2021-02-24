<?php 
//require ('General.php');

class BaoCaoSoLieu extends General{

	/* Properties */
    private $conn;
    private $general;


    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
        $this->general = new General($dbCon);
	}

	public function getDoanhThuTheoKhu($tungay, $denngay, $tugio, $dengio)
	{	
		$khuList = $this->general->getKhu();
		$khuNameList = [];
		foreach ($khuList as $r )
		{
			$khuNameList[] = str_replace("-", "_",$r['MoTa']);
		}

		 $fromSql = " FROM tblLichSuPhieu where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and TienThucTra > 0 and Len(Malichsuphieu) = 18 AND substring( Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'
				";

		$sql = "";
		$sql .= "SELECT 'Tổng' as Ma_Khu  , SUM(CASE WHEN 1=1 THEN 1 ELSE 0 END) as TongSoHoaDon, ISNULL(SUM(TienThucTra),0) as TienThucTra, ISNULL(SUM(TienDichVu),0) as TienDichVu, ISNULL(SUM(TienGiamGia),0) as TienGiamGia, ISNULL(SUM(TienGio),0) as TienKhachTip" . $fromSql;

		$i = 1;
		foreach ( $khuNameList as $khu)
		{	
			 $sql .="SELECT '$khu' as Ma_Khu , SUM(CASE WHEN MaKhu LIKE '%$khu%' THEN 1 ELSE 0 END) as TongSoHoaDon, SUM(CASE WHEN MaKhu LIKE '%$khu%' THEN TienThucTra ELSE 0 END) as TienThucTra,
			 ISNULL( SUM(CASE WHEN MaKhu LIKE '%$khu%' THEN TienDichVu ELSE 0 END), 0 ) as TienDichVu, 
			 ISNULL(  SUM(CASE WHEN MaKhu LIKE '%$khu%' THEN TienGiamGia ELSE 0 END), 0 ) as TienGiamGia,
			 ISNULL( SUM(CASE WHEN MaKhu LIKE '%$khu%' THEN TienGio ELSE 0 END), 0 ) as TienKhachTip " . $fromSql;
			
		}
		//echo $sql;
		try{

			$stmt = $this->conn->query($sql);
			$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

			} while ($stmt->nextRowset());

			return $rowset;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function getTopTenItems( $tungay, $denngay, $tugio, $dengio, &$totalQty, &$totalMoney)
	{
		$sql = "SET NOCOUNT ON;
		IF OBJECT_ID(N'tempdb..#temp_t1') IS NOT NULL BEGIN DROP TABLE #temp_t1 END 
				SELECT * into #temp_t1 FROM 
				( SELECT distinct MaHangBan, TenHangBan, MaDVT, DonGia, TongSoLuong = sum(SoLuong) 
				over (Partition by MaHangBan), ThanhTien = 
				DonGia * sum(SoLuong) over (Partition by MaHangBan)
				FROM tblLSPhieu_HangBan
				Where substring( Convert(varchar,isnull(ThoiGianBan,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'   AND SoLuong >0 and DonGia > 0 ) t1

				SELECT sum(TongSoLuong) AS TotalQty, sum(ThanhTien) AS TotalMoney 
				FROM ( SELECT Top 10 * FROM #temp_t1 ORDER BY TongSoLuong DESC) t2 						 
			";
		$sql .= "SELECT Top 10 * FROM #temp_t1 ORDER BY TongSoLuong DESC
				drop table #temp_t1";

		try{

			$stmt = $this->conn->query($sql);
			$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);

			} while ($stmt->nextRowset());
			
			return $rowset;

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldDetails( $tungay, $denngay, $tugio, $dengio, &$totalQty, &$totalMoney ) {
		$sql = "SELECT MaHangBan, TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT distinct MaHangBan, TenHangBan, MaDVT, sum(SoLuong) over ( Partition by MaHangBan)
 					as SoLuong, DonGia	 FROM [tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,isnull(ThoiGianBan,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}'
					 AND '{$denngay}T{$dengio}'
					 and SoLuong > 0 AND DonGia >0 
					) t1 ORDER BY SoLuong DESC ";

		$sql_1 = "SELECT isnull( sum(SoLuong), 0 ) as TotalQty, isnull( sum(ThanhTien), 0 ) as TotalMoney 
					FROM [tblLSPhieu_HangBan] 
					where substring( Convert(varchar,isnull(ThoiGianBan,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND
					'{$denngay}T{$dengio}' AND DonGia >0 
					and SoLuong > 0";

		try{

			$rs_1 = $this->conn->query($sql_1)->fetch(PDO::FETCH_ASSOC);
			$totalQty = $rs_1['TotalQty'];
			$totalMoney = $rs_1['TotalMoney'];
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getTopTenClients( $tungay, $denngay, $tugio, $dengio)
	{
		$sql = "SET NOCOUNT ON;
		IF OBJECT_ID(N'tempdb..#temp_t1') IS NOT NULL BEGIN DROP TABLE #temp_t1 END 
			SELECT * into #temp_t1 FROM
			(
				SELECT distinct MaKhachHang, TenDoiTuong, DiaChi, DienThoai, NgayQuanHe, TenNV,
				TongTien = SUM(TienThucTra) OVER (Partition By MaKhachHang)
				FROM tblLichSuPhieu a JOIN tblDMKHNCC b ON a.MaKhachHang = b.MaDoiTuong
		 		LEFT JOIN tblDMNhanVien c ON b.MaNhanVien1 = c.MaNV
		 		WHERE 
				substring( Convert(varchar,isnull(NgayQuanHe,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'
				And LaKH = 1 AND TienThucTra > 0
			) t1

			SELECT isnull( sum(TongTien), 0 ) AS TotalMoney FROM ( SELECT Top 10 * FROM #temp_t1 ORDER BY TongTien DESC ) t1
				
			";
		 $sql .= "SELECT Top 10 * FROM #temp_t1 ORDER BY TongTien DESC
				drop table #temp_t1";

		try{

			$stmt = $this->conn->query($sql);
			$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    

			} while ($stmt->nextRowset());
			//var_dump ($rowset);die;
			return $rowset;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getSalesByClient( $tungay, $denngay, $tugio, $dengio, &$totalMoney ) {
		 $sql = "SELECT * FROM 
		 	( SELECT distinct MaKhachHang, TenDoiTuong, DiaChi, DienThoai, NgayQuanHe, TenNV,
				TongTien = SUM(TienThucTra) OVER (Partition By MaKhachHang)
				FROM tblLichSuPhieu a JOIN tblDMKHNCC b ON a.MaKhachHang = b.MaDoiTuong
		 		LEFT JOIN tblDMNhanVien c ON b.MaNhanVien1 = c.MaNV
		 		WHERE 
				substring( Convert(varchar,isnull(NgayQuanHe,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'
				And LaKH = 1 AND TienThucTra > 0
			) t1 ORDER BY TongTien DESC";
		 $sql_1 = "SELECT isnull( sum(TongTien), 0 ) AS TotalMoney
				FROM [tblDMKHNCC] 
				WHERE substring( Convert(varchar,isnull(NgayQuanHe,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'
				And LaKH = 1";

		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$totalMoney = $rs_1;
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}



	public function getSalesByStaff( $tungay, $denngay, $tugio, $dengio, &$totalMoney ) {
		
		 $sql = "select distinct a.MaNV, TenNV, DoanhThu = SUM(TongTien) OVER (PARTITION BY MaNhanVien1)
				FROM tblDMNhanVien a  LEFT JOIN tblDMKHNCC b ON a.MaNV = b.MaNhanVien1
				AND 
				substring( Convert(varchar,isnull(NgayQuanHe,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'  ORDER BY DoanhThu DESC";

		 $sql_1 = "SELECT sum(TongTien) as TotalMoney 
		 		FROM tblDMNhanVien a  JOIN tblDMKHNCC b ON a.MaNV = b.MaNhanVien1
				WHERE 
				substring( Convert(varchar,isnull(NgayQuanHe,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'";

		try{

			$rs_1 = $this->conn->query($sql_1)->fetch(PDO::FETCH_ASSOC);
			$totalMoney = $rs_1['TotalMoney'];
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}



}