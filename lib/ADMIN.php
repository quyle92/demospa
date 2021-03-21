<?php
class Admin  {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
	}
	
	public function layDanhSachUsers() {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [SPA_SAIGONDEP].[dbo].[tblDSNguoiSD] a,  [SPA_SAIGONDEP].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV 		";
		try{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			//$r=sqlsrv_fetch_array($rs); 
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layBaoCao( $ma_bao_cao ){
		$sql = "SELECT * FROM [SPA_SAIGONDEP].[dbo].[tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
		try {
			$rs = $this->conn->query($sql)->fetch();
						
				return $rs['TenBaoCao'];
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}


}