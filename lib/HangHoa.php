<?php
require_once('lib/General.php');
use \ForceUTF8\Encoding;
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

	public function themCat() 
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
//var_dump($_SESSION['cat_id']);die;
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
		$cat_name =  htmlentities(trim(strip_tags($_POST['cat_name'])),ENT_QUOTES,'utf-8');

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
			//echo $sql = "UPDATE  [tblDMNhomHangBan] SET  [Ten] = N'$cat_name'  Where [Ma] ='$cat_id'";//die;
			echo $sql = "UPDATE  [tblDMNhomHangBan] SET  [Ten] =  cast(N'$cat_name' as nvarchar(max))  Where [Ma] ='$cat_id'";//die;
			try
			{
				$rs = $this->conn->query($sql);
				$_SESSION['add_success'] = " <strong>Success!</strong> Edit category name successfully...";
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

	/**
	 * Product
	 */
	public function getAllProducts()
	{	
		$sql = "SELECT a.*, b.Ten, c.Gia FROM [tblDMHangBan] a LEFT JOIN [tblDMNhomHangBan] b ON a.MaNhomHangBan = b.Ma  
		LEFT JOIN tblGiaBanHang c on a.MaHangBan = c.MaHangBan
		order by a.[MaHangBan]";
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

	public function getDonViTinh()
	{
		$sql = "SELECT distinct [MaDVTCoBan] from [tblDMHangBan]";
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

	public function themProd() 
	{
		$flag = true;
		//var_dump ( $_POST);die;
		$prod_id = htmlentities(trim(strip_tags($_POST['prod_id'])),ENT_QUOTES,'utf-8');
		$prod_name = htmlentities(trim(strip_tags($_POST['prod_name'])),ENT_QUOTES,'utf-8');
		$cat_id = isset($_POST['cat_id']) ? htmlentities(trim(strip_tags($_POST['cat_id'])),ENT_QUOTES,'utf-8') : "";
		$donViTinh = isset($_POST['donViTinh']) ? htmlentities(trim(strip_tags($_POST['donViTinh'])),ENT_QUOTES,'utf-8') : "";

		if( empty($prod_id) )
		{
			$_SESSION['error']['empty_ProdID'] = "Product ID is empty!";
			$flag = false;
		}
		elseif( $this->general->checkProdID($prod_id) == true)
		{	
			$_SESSION['error']['duplicate_ProdID'] = "Product ID already existed!";
			$flag = false;
		};

		if( empty($prod_name) )
		{
			$_SESSION['error']['empty_ProdName'] = "Product name is empty!";
			$flag = false;
		}
		elseif( $this->general->checkProdName($prod_name) == true)
		{
			$_SESSION['error']['duplicate_ProdName'] = "Product name already existed!";
			$flag = false;
		};

		if( empty($cat_id) )
		{
			$_SESSION['error']['empty_CatID'] = "Category ID is empty!";
			$flag = false;
		}

		if( empty($donViTinh) )
		{
			$_SESSION['error']['donViTinh'] = "MaDVT is empty!";
			$flag = false;
		}

		$_SESSION['prod_id'] = $prod_id;//var_dump($_SESSION['prod_id']);die;
		$_SESSION['prod_name'] = $prod_name;
		$_SESSION['cat_id'] = $cat_id;
		$_SESSION['donViTinh'] = $donViTinh;

		if ( $flag === true )
		{
			$sql = "INSERT INTO [tblDMHangBan] ( [MaHangBan], [TenHangBan], [MaNhomHangBan], [MaDVTCoBan] ) VALUES ( '$prod_id', N'$prod_name', '$cat_id', '$donViTinh')";
			try
			{	

				$rs = $this->conn->query($sql);
				$_SESSION['add_success'] = " <strong>Success!</strong> Product name added successfully...";

			}
			catch( Exception $e )
			{
				echo $e->getMessage();
			}
		}
	}

	public function editProd() 
	{
		$flag = true;
		//var_dump ( $_POST);die;
		$prod_id = htmlentities(trim(strip_tags($_POST['prod_id'])),ENT_QUOTES,'utf-8');
		$prod_name = isset($_POST['prod_name']) ? htmlentities(trim(strip_tags($_POST['prod_name'])),ENT_QUOTES,'utf-8') : "";
		$cat_id = isset($_POST['cat_id']) ? htmlentities(trim(strip_tags($_POST['cat_id'])),ENT_QUOTES,'utf-8') : "";
		$donViTinh = isset($_POST['donViTinh']) ? htmlentities(trim(strip_tags($_POST['donViTinh'])),ENT_QUOTES,'utf-8') : "";


		if( empty($prod_name) )
		{
			$_SESSION['fail']['empty_ProdName'] = "Product name is empty!";
			$flag = false;
		}
		// elseif( $this->general->checkProdName($prod_name) == true )
		// {
		// 	$_SESSION['fail']['duplicate_ProdName'] = "Product name already existed!";
		// 	$flag = false;
		// };

		if( empty($cat_id) )
		{
			$_SESSION['fail']['empty_CatID'] = "Category ID is empty!";
			$flag = false;
		}

		if( empty($donViTinh) )
		{
			$_SESSION['fail']['donViTinh'] = "MaDVT is empty!";
			$flag = false;
		}

		$_SESSION['prod_id_edit'] = $prod_id;
		$_SESSION['prod_name_edit'] = $prod_name;//var_dump($_SESSION['prod_name']);die;
		$_SESSION['cat_id_edit'] = $cat_id;
		$_SESSION['donViTinh_edit'] = $donViTinh;
		// var_dump($flag);die;
		if ( $flag === true )
		{
			 $sql = "UPDATE [tblDMHangBan] SET  [TenHangBan] = N'$prod_name', [MaNhomHangBan] = '$cat_id', [MaDVTCoBan] = '$donViTinh'  WHERE [MaHangBan] = '$prod_id' ";
			try
			{	
				$rs = $this->conn->query($sql);
				$_SESSION['add_success'] = "<strong>Success!</strong> Product name edited successfully...";
			}
			catch( Exception $e )
			{
				echo $e->getMessage();
			}
		}
	}

	public function xoaProd($prod_id)
	{	
		$sql = "DELETE FROM  [tblDMHangBan] where [MaHangBan] = '$prod_id'";

		try
		{
			$rs = $this->conn->query($sql);
			$_SESSION['del_success'] = "Item deleted successfully!";
			//var_dump ( $_SESSION['del_success'] );die;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}



}