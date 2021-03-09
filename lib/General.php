<?php
class General {

		/* Properties */
	    private $conn;

	    /* Get database access */
	    public function __construct(\PDO $dbCon) {
	        $this->conn = $dbCon;
		}

	public function getKhu()
	{
		$sql="select COUNT(MaKhu) OVER(PARTITION BY MaKhu) AS count, a.* from tblDMKhu a
		 Where MaKhu in (Select MaKhu from tblDMBan)";
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

	protected function checkUser($username)
	{	//var_dump($username);die;
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

	protected function checkCatID($cat_id)
	{
		$sql = "SELECT * FROM [tblDMNhomHangBan] WHERE [Ma] = '$cat_id' ";
		try {
			$rs = $this->conn->query($sql)->fetch();
			//var_dump($rs);die;	
			if($rs) 
				return true;
			else
				return false;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	protected function checkCatName($cat_name)
	{	//var_dump($cat_name);die;
		$sql = "SELECT * FROM [tblDMNhomHangBan]";
		try 
		{
			$rs = $this->conn->query($sql)->fetchAll();//var_dump( $this->conn->query($sql));die;
			foreach ($rs as $r)
			{
				if ($r['Ten'] == $cat_name ){
					
					return true;
				}
				
			}

			return false;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	protected function checkProdID($prod_id)
	{
		$sql = "SELECT * FROM [tblDMHangBan] WHERE [MaHangBan] = '$prod_id' ";
		try {
			$rs = $this->conn->query($sql)->fetch();
			//var_dump($rs);die;	
			if($rs) 
				return true;
			else
				return false;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	protected function checkProdName($prod_name)
	{	//var_dump($prod_name);die;
		$sql = "SELECT * FROM [tblDMHangBan]";
		try 
		{
			$rs = $this->conn->query($sql)->fetchAll();//var_dump( $this->conn->query($sql));die;
			foreach ($rs as $r)
			{
				if ($r['TenHangBan'] == $prod_name ){
					
					return true;
				}
				
			}

			return false;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	protected function generateClientID()
	{
		$sql = "
		SELECT ISNULL(
			--expression to test
			(SELECT  '01-' + ( SELECT REPLACE( SUBSTRING( (CONVERT(varchar, getdate(), 126)) , 1, 7 ), '-', '' ) ) + '-' + MAX(CAST(SUBSTRING(MaDoiTuong, 11, LEN(MaDoiTuong)-10) AS char)) from tblDMKHNCC
			where MaDoiTuong like '%' + ( SELECT REPLACE( SUBSTRING( (CONVERT(varchar, getdate(), 126)) , 1, 7 ), '-', '' ) ) + '%')
			, 
			--value to return if expression is NULL
			( SELECT '01-' + REPLACE( SUBSTRING( (CONVERT(varchar, getdate(), 126)) , 1, 7 ), '-', '' ) + '-001') 
		)
		";
		try 
		{
			$rs = $this->conn->query($sql)->fetchColumn();//var_dump( $this->conn->query($sql));die;

			return $rs;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

}