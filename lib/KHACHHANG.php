<?php
namespace Lib;
use Lib\General;

class KhachHang extends General { //(1)


	/* Properties */
    private $conn;
    private $general;

    /* Get database access */
    public function __construct(\PDO $conn) {
        $this->conn = $conn;
        $this->general = new General( $conn ); //(2)
	}


	function order_chitiet( $orderID )
	{
		$sql = "SELECT  * FROM tblOrderChiTiet where OrderID='$orderID'";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	function order_in_process(){
		$sql = "SELECT  * FROM [tblOrder] WHERE TrangThai = 0  ORDER BY OrderID ASC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	} 

	function list_items_in_order( $orderID){
		$sql = "SELECT  * FROM [tblOrderChiTiet] WHERE OrderID = '$orderID' ORDER BY OrderID DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	} 

	public function getCustomersList()
	{
		$sql = "SELECT  * FROM [tblDMKHNCC] ";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function insertNewClient( $client_name, $client_address, $client_tel)
	{	
		$stt = 0;
		$sql = "SELECT max(substring(MaDoiTuong,11,5)) FROM [tblDMKHNCC]";
		$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		$r = sqlsrv_fetch_array($rs);
		$stt = ++$r[0];

		$date = date("yy-m");//2020-11
		$date = substr($date,0,4) . substr($date,5,2);
		$ma_doi_tuong =  $_SESSION['MaTrungTam'] . "1" . $date . "-" . $stt;

		$ten_doi_tuong = htmlentities(trim(strip_tags($client_name)),ENT_QUOTES,'utf-8');
		$dia_chi = htmlentities(trim(strip_tags($client_address)),ENT_QUOTES,'utf-8');
		$dien_thoai = htmlentities(trim(strip_tags($client_tel)),ENT_QUOTES,'utf-8');

		$sql_1 = "INSERT INTO [tblDMKHNCC] ( MaDoiTuong, TenDoiTuong, DiaChi, DienThoai	) VALUES( '$ma_doi_tuong', N'$ten_doi_tuong', N'$dia_chi', '$dien_thoai' )  ";
		try
		{
			$rs_1 = $this->conn->query($sql);

			if( !$rs_1 ){
				$_SESSION['insert_error'] = "Insert failed...";
			}
			else
			{
				$_SESSION['insert_success'] = "Inserted successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientInfo( $ma_doi_tuong )
	{
		$sql = "SELECT * FROM [tblDMKHNCC] Where [MaDoiTuong]='$ma_doi_tuong'";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function updateClient( $client_id, $client_name, $client_address, $client_tel)
	{	
		$ma_doi_tuong = htmlentities(trim(strip_tags($client_id)),ENT_QUOTES,'utf-8');
		$ten_doi_tuong = htmlentities(trim(strip_tags($client_name)),ENT_QUOTES,'utf-8');
		$dia_chi = htmlentities(trim(strip_tags($client_address)),ENT_QUOTES,'utf-8');
		$dien_thoai = htmlentities(trim(strip_tags($client_tel)),ENT_QUOTES,'utf-8');

		$sql_1 = "UPDATE [tblDMKHNCC] SET  MaDoiTuong = '$ma_doi_tuong', TenDoiTuong = N'$ten_doi_tuong', DiaChi = '$dia_chi', DienThoai = '$dien_thoai'	WHERE [MaDoiTuong] = '$ma_doi_tuong' ";
		try
		{
			$rs_1 = $this->conn->query($sql);

			if( !$rs_1 ){
				$_SESSION['update_error'] = "Update failed...";
			}
			else
			{
				$_SESSION['update_success'] = "Update successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function deleteClient( $client_id )
	{	
		$sql_1 = "DELETE FROM [tblDMKHNCC] WHERE [MaDoiTuong] = '$client_id' ";
		try
		{
			$rs_1 = $this->conn->query($sql);

			if( !$rs_1 ){
				$_SESSION['delete_error'] = "Delete failed...";
			}
			else
			{
				$_SESSION['delete_success'] = "Delete successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientList()
	{
		$sql="select a.MaDoiTuong, a.TenDoiTuong, a.DienThoai, a.DiaChi, a.MaNhomKH, a.GhiChu from tblDMKHNCC a left join tblDMNhomKH b on a.MaNhomKH = b.Ma Order by a.MaDoiTuong";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

			return $rs;
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getBillHistory( $client_id )
	{
		$sql = "SELECT  MaLichSuPhieu, substring( Convert(varchar,GioVao,105),0,11 ) as GioVao, TienThucTra FROM [tblLichSuPhieu] WHERE MaKhachHang = '$client_id' ORDER BY substring( Convert(varchar,GioVao,105),0,11 ) DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getAllClients()
	{

		$sql="with t1 as ( select 
				b.MaDoiTuong, TenDoiTuong, MaLichSuPhieu, TienThucTra, 
				GioVao, MaNhomKH
				,DienThoai, DiaChi, b.GhiChu, b.MaNhanVien
				from tblLichSuPhieu a
				right join tblDMKHNCC b on a.MaKhachHang = b.MaDoiTuong		
				left join tblDMNhomKH c on b.MaNhomKH = c.Ma 
				)
				SELECT * from t1   
				--where MaDoiTuong='01-201909-001' or MaDoiTuong='01-201910-201'
				Order by  MaDoiTuong, GioVao DESC";
		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
			sqlsrv_free_stmt( $rs);
		}

		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientsWithCard( $tungay, $denngay, $tugio, $dengio )
	{
		   $sql = " SELECT a.*, b.*, c.* FROM  [tblTheVIP_GhiNoDV] a
		 	JOIN [tblKhachHang_TheVip] b ON a.MaTheVip = b.MaTheVip
		 	JOIN [tblDMKHNCC] c ON b.MaKhachHang = c.[MaDoiTuong]
			Where substring( Convert(varchar,isnull([NgayQuanHe],getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'";

		try
		{

			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getClientAppointments( $tungay, $denngay, $tugio, $dengio )
	{
		$sql = " SELECT a.*, b.* FROM [tblKhachHangBooking] a JOIN tblDMNhanVien b ON a.MaNV = b.MaNV
			Where substring( Convert(varchar,isnull(GioBatDau,getdate()),126),0,17 ) BETWEEN '{$tungay}T{$tugio}' AND 
				'{$denngay}T{$dengio}'
			";

		try
		{

			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getMaNhomKH()
	{
		$sql = "SELECT * from tblDMNhomKH";

		try
		{
			$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
			return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	public function addClient()
	{	
		$flag = true;
		
		$client_id      = $this->general->generateClientID();
		$client_name    = htmlentities(trim(strip_tags($_POST['client_name'])),ENT_QUOTES,'utf-8');
		$client_tel     = htmlentities(trim(strip_tags($_POST['client_tel'])),ENT_QUOTES,'utf-8');
		$client_tel     = 0 . str_replace(" ", "", $client_tel)	;
		$client_address = htmlentities(trim(strip_tags($_POST['client_address'])),ENT_QUOTES,'utf-8');
		$client_group   = htmlentities(trim(strip_tags($_POST['client_group'])),ENT_QUOTES,'utf-8');
		$client_notes   = htmlentities(trim(strip_tags($_POST['client_notes'])),ENT_QUOTES,'utf-8');

		if( empty($client_name) )
		{
			$_SESSION['error']['empty_clientName'] = "Client name was missing!";
			$flag = false;
		}

		if( empty($client_tel) )
		{
			$_SESSION['error']['empty_clientTel'] = "Client phone number was missing!";
			$flag = false;
		}

		$phoneRegex = "/((09|03|07|08|05)+([0-9]{8})\b)/im";
		if( preg_match_all( $phoneRegex, $client_tel ) != 1 || strlen($client_tel) > 10 )
		{
			$_SESSION['error']['invalidTel'] = "Invalid phone number!";
			$flag = false;
		}

		if( empty($client_group) )
		{
			$_SESSION['error']['empty_clientGroup'] = "Client group was not selected!";
			$flag = false;
		}

		$_SESSION['client_name'] = $client_name;
		$_SESSION['client_tel'] = $client_tel;
		$_SESSION['client_address'] = $client_address;
		$_SESSION['client_group'] = $client_group;
		$_SESSION['client_notes'] = $client_notes;

		if ( $flag === true )
		{	
			$sql = "INSERT INTO  [tblDMKHNCC] ( [MaDoiTuong], [TenDoiTuong], [DienThoai] , [DiaChi1], [MaNhomKH], [GhiChu]) VALUES ( '$client_id', N'$client_name', '$client_tel', '$client_address', '$client_group', '$client_notes' )";
			try
			{	

				$rs = $this->conn->query($sql);
				$_SESSION['add_success'] = " <strong>Success!</strong> Client added successfully...";

			}
			catch( Exception $e )
			{
				echo $e->getMessage();
			}
		}
	}

	public function editClient($params)
	{	
		$flag = true;
		
		if ( $params['name'] == 'TenDoiTuong' )
		{
			$client_name = $params['value'];
			$result = [];
			if( empty($client_name) )
			{
				$result['success'] = false;
				$result['msg'] = 'This field is required!';
				$flag = false;
				//var_dump($result);
				echo json_encode($result);
			}

		}

		if ( $params['name'] == 'DienThoai' )
		{
			$client_tel = $params['value'];
			$result = [];

			if( empty($client_tel) )
			{
				$result['success'] = false;
				$result['msg'] = 'Missing phone number!';
				$flag = false;
				
				echo json_encode($result);
			}
			$phoneRegex = "/((09|03|07|08|05)+([0-9]{8})\b)/im";
			if( preg_match_all( $phoneRegex, $client_tel ) != 1 || strlen($client_tel) > 10 )
			{	
				$result['success'] = false;
				$result['msg'] = "Invalid phone number!";
				$flag = false;

				echo json_encode($result);
			}
		}

		if ( $params['name'] == 'MaNhomKH' )
		{
			$client_group = $params['value'];
			$result = [];
			if( empty($client_group) )
			{
				$result['success'] = false;
				$result['msg'] = 'This field is required!';
				$flag = false;
				
				echo json_encode($result);
			}

		}


		if ( $flag === true )
		{	
			$sql = "
				UPDATE tblDMKHNCC 
				SET ".$params["name"]." = '".$params["value"]."' 
				WHERE MaDoiTuong = '".$params["pk"]."'
				";
			try
			{	

				$rs = $this->conn->query($sql);
				// var_dump($rs);
			}
			catch( Exception $e )
			{
				echo $e->getMessage();
			}
		}
	}

	public function	xoaClient($prod_id)
	{	
		if ( ! $prod_id ) throw new ErrorException;
		
		$prod_id = htmlentities(trim(strip_tags($prod_id)));
		$sql = "DELETE FROM  [tblDMKHNCC] where [MaDoiTuong] = '$prod_id'";
		//var_dump ($prod_id);die;
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



/**Note*/
//(1) nểu chỉ extends General class ko thôi sẽ ko chạy đc protected function trong General vì nó cần phải có $conn mới chạy đc, mà khi extends ko thôi thì chả có ai pass $conn cho nó cả. Cho nên để gọi hàm trong General thì phải dùng thêm (2). Tuy nhiên, Nếu function trong General mà public thì ko cần extends