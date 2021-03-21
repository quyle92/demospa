<?php 
namespace Lib;
class BaoCaoBieuDo  {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
	}

	public function getSalesThisYear()
	{	
		$this_year = date('Y');

	 	$sql = "";

	 	$sql .= "SELECT ";

		for ( $i = 1; $i <= 12; $i++ ){

		    if($i <= 9){
		     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $this_year . "/0" . $i ."' Then (TienThucTra)  Else 0 END) as DoanhThuT" . $i . ", "; 
		   }

		    if($i > 9){
		      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $this_year . "/" . $i ."' Then (TienThucTra)  Else 0 END) as DoanhThuT" . $i . ", "; 
		    }
		}
		  
		 $sql = rtrim($sql, ", ");

		 $sql .=" FROM [tblLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";

		  try
		  {
		    $rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_BOTH );//var_dump($rs);
		    if($rs != false)
		    {
		     
		      $doanh_thu = array();
		      foreach ( $rs as $r1 ) 
		      {
		        //${"doanhthu_t" . $i} = (int) $r1[$k];
		        //var_dump($r1);

		        $doanh_thu = array(); 

		        foreach ( $r1 as $k => $v)
		        { 

		            if( is_int($k) ) $doanh_thu[] = $v;  
		   
		        }
		       
		      }

		       return $doanh_thu;
		  
		    }
		  }
		  catch (PDOException $e) {
		    echo $e->getMessage();
		  }
	}

	public function getSalesLastYear()
	{	
		$this_year = date('Y', strtotime('-1 year'));

	 	$sql = "";

	 	$sql .= "SELECT ";

		for ( $i = 1; $i <= 12; $i++ ){

		    if($i <= 9){
		     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $this_year . "/0" . $i ."' Then (TienThucTra)  Else 0 END) as DoanhThuT" . $i . ", "; 
		   }

		    if($i > 9){
		      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $this_year . "/" . $i ."' Then (TienThucTra)  Else 0 END) as DoanhThuT" . $i . ", "; 
		    }
		}
		  
		 $sql = rtrim($sql, ", ");

		 $sql .=" FROM [tblLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";

		  try
		  {
		    $rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_BOTH );//var_dump($rs);
		    if($rs != false)
		    {
		     
		      $doanh_thu = array();
		      foreach ( $rs as $r1 ) 
		      {
		        //${"doanhthu_t" . $i} = (int) $r1[$k];
		        //var_dump($r1);

		        $doanh_thu = array(); 

		        foreach ( $r1 as $k => $v)
		        { 

		            if( is_int($k) ) $doanh_thu[] = $v;  
		   
		        }
		       
		      }

		       return $doanh_thu;
		  
		    }
		  }
		  catch (PDOException $e) {
		    echo $e->getMessage();
		  }
	}

	public function getSalesAnotherYear($year_selected)
	{
		  $sql = "";

		  $sql .= "SELECT ";

		for ( $i = 1; $i <= 12; $i++ ){

		    if($i <= 9){
		     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $year_selected . "/0" . $i ."' Then (TienThucTra)  Else 0 END) as DoanhThuT" . $i . ", "; 
		   }

		    if($i > 9){
		      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $year_selected . "/" . $i ."' Then (TienThucTra)  Else 0 END) as DoanhThuT" . $i . ", "; 
		    }
		}
		  
		  $sql = rtrim($sql, ", ");

		 $sql .=" FROM [tblLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";

		  try
		  {
		    $rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_BOTH );//var_dump($rs);
		    if($rs != false)
		    {
		     
		      $doanh_thu = array();
		      foreach ( $rs as $r1 ) 
		      {
		        //${"doanhthu_t" . $i} = (int) $r1[$k];
		        //var_dump($r1);

		        $doanh_thu = array(); 

		        foreach ( $r1 as $k => $v)
		        { 

		            if( is_int($k) ) $doanh_thu[] = $v;  
		   
		        }
		       
		      }

		       return $doanh_thu;
		  
		    }
		  }
		  catch (PDOException $e) {
		    echo $e->getMessage();
		  }		
	}

	public function getClientRevByWeek( $from ) {
		 //$from = '2020-12-12';
		 $sql = "DECLARE @StartDate AS VARCHAR(100)='$from'

SELECT CONVERT(INT, SUM(CASE WHEN substring(Convert(varchar,[GioVao],126),0,11) 
	= @StartDate Then TienThucTra Else 0 END) ) as T2,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 1, @StartDate) Then TienThucTra Else 0 END) As Int) as T3,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 2, @StartDate) Then TienThucTra Else 0 END)  As Int) as T4,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 3, @StartDate) Then TienThucTra Else 0 END)  As Int) as T5,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 4, @StartDate) Then TienThucTra Else 0 END)  As Int) as T6,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 5, @StartDate) Then TienThucTra Else 0 END)  As Int) as T7,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 6, @StartDate) Then TienThucTra Else 0 END)  As Int) as CN
	FROM  tblLichSuPhieu Where MaTheVip = '' or MaTheVip IS  NULL
	
SELECT CONVERT(INT, SUM(CASE WHEN substring(Convert(varchar,[GioVao],126),0,11) 
	= @StartDate Then TienThucTra Else 0 END) ) as T2,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 1, @StartDate) Then TienThucTra Else 0 END) As Int) as T3,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 2, @StartDate) Then TienThucTra Else 0 END)  As Int) as T4,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 3, @StartDate) Then TienThucTra Else 0 END)  As Int) as T5,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 4, @StartDate) Then TienThucTra Else 0 END)  As Int) as T6,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 5, @StartDate) Then TienThucTra Else 0 END)  As Int) as T7,
	CAST( SUM(CASE WHEN substring(Convert(varchar,[GioVao],111),0,11) 
	=  DATEADD(DAY, 6, @StartDate) Then TienThucTra Else 0 END)  As Int) as CN
	FROM  tblLichSuPhieu Where MaTheVip <> '' or MaTheVip IS NOT NULL";

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

	public function getClientRevByMonth(  $date_range, $datediff )
	{
		$sql = "";
		$sql .= "SELECT ";

		$i = 1;
		foreach ($date_range as $dt) {
		    $sql .= "SUM(CASE WHEN substring(convert(varchar, GioVao, 126),0,11) ='" . $dt->format("Y-m-d") . "' 
		    Then TienThucTra Else 0 END) As '" . $dt->format("Y-m-d") . "'";
		    
		    if ( $i < $datediff) $sql .= ",";
		    $i++;
		}

		$sql .= "
		   FROM  tblLichSuPhieu Where MaTheVip = '' or MaTheVip IS  NULL 

		";

		$sql .= "SELECT ";
		$i = 1;
		foreach ($date_range as $dt) {
		    $sql .= "SUM(CASE WHEN substring(convert(varchar, GioVao, 126),0,11) ='" . $dt->format("Y-m-d") . "' 
		    Then TienThucTra Else 0 END) As '" . $dt->format("Y-m-d") . "'";
		    
		    if ( $i < $datediff) $sql .= ",";
		    $i++;
		}

		 $sql .= "
		   FROM  tblLichSuPhieu Where MaTheVip <> '' or MaTheVip IS NOT NULL
		";

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

	public function getClientRevByYear(  $month_range, $month_diff ) 
	{
		$sql = "";
		$sql .= "SELECT ";

		$i = 1;
		foreach ($month_range as $dt) {
		    $sql .= "SUM(CASE WHEN substring(convert(varchar, GioVao, 126),0,8) ='" . $dt->format("Y-m") . "' 
		    Then TienThucTra Else 0 END) As '" . $dt->format("Y-m") . "'";
		    
		    if ( $i < $month_diff) $sql .= ",";
		    $i++;
		}

		$sql .= "
		   FROM  tblLichSuPhieu Where MaTheVip = '' or MaTheVip IS  NULL 

		";

		$sql .= "SELECT ";
		$i = 1;
		foreach ($month_range as $dt) {
		    $sql .= "SUM(CASE WHEN substring(convert(varchar, GioVao, 126),0,8) ='" . $dt->format("Y-m") . "' 
		    Then TienThucTra Else 0 END) As '" . $dt->format("Y-m") . "'";
		    
		    if ( $i < $month_diff) $sql .= ",";
		    $i++;
		}

		 $sql .= "
		   FROM  tblLichSuPhieu Where MaTheVip <> '' or MaTheVip IS NOT NULL
		";

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

	public function countOccupiedTables(  $ma_khu = NULL ) : int {
		if ( $ma_khu == NULL Or $ma_khu == 'all')
		{
			$sql = "SELECT count(*) FROM [tblLichSuPhieu] where [ThoiGianDongPhieu] IS NULL and substring( Convert(varchar,[GioVao],111),0,11 ) = GETDATE()";
		}
		else {
			$sql = "SELECT count(*) FROM
			( SELECT a.MaBan, b.[MaKhu]  FROM [tblLichSuPhieu] a Left join
				 [tblDMBan] b ON a.MaBan=b.MaBan Left join
				 [tblDMKhu] c ON b.MaKhu=c.MaKhu where [ThoiGianDongPhieu] IS NULL and substring( Convert(varchar,[GioVao],111),0,11 ) = GETDATE() and  b.[MaKhu]='$ma_khu' ) t1";
		}
		try 
		{
			$nRows = $this->conn->query($sql)->fetchColumn(); 
			return $nRows;

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countTotalTables( $ma_khu = NULL ) : int {
		if ( $ma_khu == NULL Or $ma_khu == 'all' )
		{
			$sql = "SELECT count(*) FROM [tblDMBan]";
		}
		else
		{
			 $sql = " SELECT count(*) from ( SELECT * FROM [tblDMBan] where MaKhu ='$ma_khu' ) t1 ";

		}
		try 
		{
			$nRows = $this->conn->query($sql)->fetchColumn(); settype($nRows,'int');
			return $nRows;

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	public function getTotalTablesWithBills( $tungay, $denngay, $tugio, $dengio, $ma_khu = NULL) : int {
		if( !isset($ma_khu) )
		{
			echo $sql = "SELECT count(*) FROM
		 	 ( SELECT MaBan, count(*) as SoLuong FROM [tblLichSuPhieu] where substring( Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}' group by MaBan ) t1
			";
		}
		else
		{
			 $sql = "SELECT count(*) FROM
		 	( SELECT a.MaBan, count(*) as SoLuong FROM [tblLichSuPhieu] a Left join
			 [tblDMBan] b ON a.MaBan=b.MaBan Left join
			 [tblDMKhu] c ON b.MaKhu=c.MaKhu
  			 where substring( Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}' and b.[MaKhu]='$ma_khu' group by a.MaBan) t1
			";
		}
		try 
		{
			$nRows = $this->conn->query($sql)->fetchColumn(); 
			return $nRows;

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	public function getClientNoByWeek( $from ) {
		 $sql = "DECLARE @StartDate AS VARCHAR(100)='$from'
 
			SELECT CONVERT(INT, SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			= @StartDate Then 1 Else 0 END) ) as T2,
			CAST( SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			=  DATEADD(DAY, 1, @StartDate) Then 1 Else 0 END) As Int) as T3,
			CAST( SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			=  DATEADD(DAY, 2, @StartDate) Then 1 Else 0 END)  As Int) as T4,
			CAST( SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			=  DATEADD(DAY, 3, @StartDate) Then 1 Else 0 END)  As Int) as T5,
			CAST( SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			=  DATEADD(DAY, 4, @StartDate) Then 1 Else 0 END)  As Int) as T6,
			CAST( SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			=  DATEADD(DAY, 5, @StartDate) Then 1 Else 0 END)  As Int) as T7,
			CAST( SUM(CASE WHEN substring(Convert(varchar,[NgayQuanHe],111),0,11) 
			=  DATEADD(DAY, 6, @StartDate) Then 1 Else 0 END)  As Int) as CN
			FROM [tblDMKHNCC]";

		try 
			{
				$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
				return $rs;

			}
			catch ( PDOException $error )
			{
				echo $error->getMessage();
			}

	

	}

	public function getClientNoByMonth(  $date_range, $datediff ) 
	{
		$sql = "";
		$sql .= "SELECT ";

		$i = 1;
		foreach ($date_range as $dt) {
		    $sql .= "SUM(CASE WHEN substring(convert(varchar, NgayQuanHe, 126),0,11) ='" . $dt->format("Y-m-d") . "' 
		    Then 1 Else 0 END) As Day_";
		    $sql .= ($i <= 9) ? "0" . $i : $i;
		    
		    if ( $i < $datediff) $sql .= ",";
		    $i++;
		}

		 $sql .= "
		    FROM tblDMKHNCC
		";


		try 
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
			return $rs;

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}


	}

	function getClientNoByYear( $month_range, $month_diff )
	{
		$sql = "";
		$sql .= "SELECT ";

		$i = 1;
		foreach ($month_range as $dt) {
		    $sql .= "SUM(CASE WHEN substring(convert(varchar, NgayQuanHe, 126),0,8) ='" . $dt->format("Y-m") . "' 
		    Then 1 Else 0 END) As " . $dt->format("M_Y");
		    
		    if ( $i < $month_diff) $sql .= ",";
		    $i++;
		}

		$sql .= "
		    FROM tblDMKHNCC
		";


		try 
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
			return $rs;

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}



}
