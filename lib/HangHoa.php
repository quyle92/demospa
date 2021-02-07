<?php
require_once('lib/General.php');
class HangHoa  extends General {

	/* Properties */
    private $conn;
    private $general;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
        $this->general = new General( $dbCon );
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

	public function them() 
	{
		$flag = true;

		$cat_id = htmlentities(trim(strip_tags($_POST['cat_id'])),ENT_QUOTES,'utf-8');
		$cat_name = htmlentities(trim(strip_tags($_POST['cat_name'])),ENT_QUOTES,'utf-8');

		if( empty($cat_id) )
		{
			$_SESSION['error']['empty_catID'] = "Category ID is empty!";
			$flag = false;
		}
		elseif( $this->general->checkCatID($cat_id) == true)
		{	
			$_SESSION['error']['duplicate_CatID'] = "Category ID already existed!";
			$flag = false;
		};

		if( empty($cat_name) )
		{
			$_SESSION['error']['empty_catName'] = "Category name is empty!";
			$flag = false;
		}
		elseif( $this->general->checkCatName($cat_name) == true)
		{
			$_SESSION['error']['duplicate_CatName'] = "Category name already existed!";
			$flag = false;
		};

		$_SESSION['cat_id'] = $cat_id;
		$_SESSION['cat_name'] = $cat_name;

		if ( $flag === true )
		{
			$sql = "INSERT INTO  [tblDMNhomHangBan] ( [Ma], [Ten] ) VALUES ( '$cat_id', N'$cat_name' )";
			try
			{	

				$rs = $this->conn->query($sql);
				$_SESSION['add_success'] = " <strong>Success!</strong> Add category name successfully...";

			}
			catch( Exception $e )
			{
				echo $e->getMessage();
			}
		}
	}

	public function edit() 
	{
		$flag = true;

		$cat_id = htmlentities(trim(strip_tags($_POST['cat_id'])),ENT_QUOTES,'utf-8');
		$cat_name = htmlentities(trim(strip_tags($_POST['cat_name'])),ENT_QUOTES,'utf-8');

		if( empty($cat_name) )
		{
			$_SESSION['fail']['empty_catName'] = "Category name is empty!";
			$flag = false;
		}
		elseif( $this->general->checkCatName($cat_name) == true)
		{
			$_SESSION['fail']['duplicate_CatName'] = "Category name already existed!";
			$flag = false;
		};

		$_SESSION['cat_id_edit'] = $cat_id;//var_dump($_SESSION['cat_id']);die;
		$_SESSION['cat_name'] = $cat_name;

		if ( $flag === true )
		{
			$sql = "UPDATE  [tblDMNhomHangBan] SET  [Ten] = N'$cat_name'  Where [Ma] ='$cat_id'";
			try
			{
				$rs = $this->conn->query($sql);
				$_SESSION['add_success'] = " <strong>Success!</strong> Add category name successfully...";
			}
			catch( Exception $e )
			{
				echo $e->getMessage();
			}
		}
	}

	
	public function xoaCat($cat_id)
	{	
		$sql = "DELETE FROM  [tblDMNhomHangBan] where [Ma] = '$cat_id'";

		try
		{
			$rs = $this->conn->query($sql);
			$_SESSION['del_success'] = "Category item deleted successfully!";
			//var_dump ( $_SESSION['del_success'] );die;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}
	





}