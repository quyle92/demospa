<?php 
class BaoCaoBieuDo  {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
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
		    $rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_BOTH );//var_dump($rs);
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
		    $rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_BOTH );//var_dump($rs);
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
		    $rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_BOTH );//var_dump($rs);
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
}
