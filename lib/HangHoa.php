<?php
class HangHoa  {

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
	}

	public function getAllProductCats() {
		$sql = "SELECT * FROM [tblDMNhomHangBan]";
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

	public function addNewCat( $catInfo ) {

		$cat_id = htmlentities(trim(strip_tags($catInfo['cat_id'])),ENT_QUOTES,'utf-8');
		$cat_name = htmlentities(trim(strip_tags($catInfo['cat_name'])),ENT_QUOTES,'utf-8');

		// if( $this->checkCatID($cat_id) == true)
		// {
		// 	$_SESSION['duplicate_cat_id'] = -1;
		// 	$_SESSION['cat_id'] = $cat_id;
		// 	$_SESSION['cat_name'] = $cat_name;
		// 	//echo  "<script>window.history.go(-1); </script>";
		// 	return;
		// };

		// if( $this->checkCatName($cat_name) == true)
		// {
		// 	$_SESSION['duplicate_cat_name'] = -1;
		// 	$_SESSION['cat_id'] = $cat_id;
		// 	$_SESSION['cat_name'] = $cat_name;
		// 	//echo  "<script>window.history.go(-1); </script>";
		// 	return;
		// };
		//var_dump (  $catInfo);die;
		$sql = "INSERT INTO  [tblDMNhomHangBan] ( [Ma], [Ten] ) VALUES ( '$cat_id', N'$cat_name' )";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION['add_success'] = 1;
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
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
					var_dump($cat_name);die;
					return true;
				}
				
			}

			return false;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function xoaCat($cat_id)
	{	
	
		$sql = "DELETE FROM  [tblDMNhomHangBan] where [Ma] = '$cat_id'";
		try{
			$rs = $this->conn->query($sql);
			$_SESSION['delete_success'] = 1;//var_dump ($rs);die;
			return $rs;	
			//echo  "<script>window.history.go(-1); </script>";
		}
		catch ( PDOException $error ){
			$_SESSION['delete_success'] = -1;
			echo $error->getMessage();
		}
	}
	





}