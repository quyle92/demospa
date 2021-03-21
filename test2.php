<?php 
try
{
	$conn = new PDO("odbc:Driver={SQL Server}; Server=QUYLE\SQLEXPRESS; Port=14330; Database=SPA_SAIGONDEP; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
	$conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
	$conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC );
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$conn->setAttribute( PDO::ODBC_ATTR_ASSUME_UTF8 , true );
	if(!$conn) print_r($conn->errorinfo());
}
catch (PDOException $e) {
  echo $e->getMessage();

 
 } 


		 $sql = "SELECT * FROM 
		 	( SELECT distinct MaKhachHang, TenDoiTuong, DiaChi, DienThoai, NgayQuanHe, TenNV,
				TongTien = SUM(TienThucTra) OVER (Partition By MaKhachHang)
				FROM tblLichSuPhieu a JOIN tblDMKHNCC b ON a.MaKhachHang = b.MaDoiTuong
		 		LEFT JOIN tblDMNhanVien c ON b.MaNhanVien1 = c.MaNV
		 		WHERE 
				 LaKH = 1 AND TienThucTra > 0
			) t1 ORDER BY TongTien DESC";

		try{
			$rs = $conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);var_dump($rs);die;
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}