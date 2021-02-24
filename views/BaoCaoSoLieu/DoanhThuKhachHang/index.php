<?php
$page_name = "BaoCaoSoLieu";
require_once('helper/security.php');
require_once('lib/BaoCaoSoLieu.php');
$client = new BaoCaoSoLieu($conn);

?>

<style>
.table > tbody > tr:first-child > td {
    color: green;
    font-weight: 700;
}
</style>

<form action="" method="post">
   <?php require_once('datetimepicker_all.php'); 
   $tuNgay = date('Y-m-d', strtotime($tuNgay));
   $denNgay = date('Y-m-d', strtotime($denNgay));
   ?> 
</form> 

<h3 class="title">TOP 10 KHÁCH HÀNG</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
       <tr>
          <th>ID</th>
          <th>Khách Hàng</th>
          <th>Địa chỉ</th>
          <th>Số điện thoại</th>
          <th>Ngày</th>
          <th>Tên Nhân Viên</th>
          <th>Tổng Tiền</th>          
        </tr>
      </thead>
      <tbody>
<?php
$topTenClient = $client->getTopTenClients( $tuNgay, $denNgay, $tuGio, $denGio  );
//var_dump($topTenClient);die;
$totalMoney = number_format($topTenClient[0][0]['TotalMoney'],0,',','.'); 
?>  
		<tr class="success">
			<td>Tổng cộng</td>
			<td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?php echo $totalMoney;?></td>
    </tr>
<?php
	
foreach($topTenClient[1] as $r)
{
?>  
		<tr class="success">
      <td><?php echo $r['MaKhachHang'];?></td>
      <td><?php echo $r['TenDoiTuong'];?></td>
      <td><?php echo $r['DiaChi'];?></td>
      <td><?php echo $r['DienThoai'];?></td>
      <td><?php echo $r['NgayQuanHe'];?></td>
      <td><?php echo $r['TenNV'];?></td>
      <td><?php echo number_format($r['TongTien'],0,',','.');?></td>
    </tr>
<?php 		
}

  ?>
      </tbody>
    </table>
   </div>
		
    <h3 class="title">Chi tiết khách hàng sử dụng</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
       <thead>
        <tr>
          <th>ID</th>
          <th>Khách Hàng</th>
          <th>Địa chỉ</th>
          <th>Số điện thoại</th>
          <th>Ngày</th>
          <th>Tên Nhân Viên</th>
          <th>Tổng Tiền</th>
        </tr>
      </thead>
      <tbody>
<?php
$salesByClient = $client->getSalesByClient( $tuNgay, $denNgay, $tuGio, $denGio ,$totalMoney );

$totalMoney = number_format($totalMoney,0,',','.'); 
?>  
    <tr class="success">
      <td>Tổng cộng</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
            <td><?php echo $totalMoney;?></td>
    </tr>
<?php
	
foreach($salesByClient as $client)
{
?>  
		<tr class="success">
      <td><?php echo $client['MaKhachHang'];?></td>
      <td><?php echo $client['TenDoiTuong'];?></td>
      <td><?php echo $client['DiaChi']?></td>
      <td><?php echo $client['DienThoai']?></td>
      <td><?php echo date('d-m-Y', strtotime(substr($client['NgayQuanHe'], 0, 10) ) )?></td>
      <td><?php echo $client['TenNV']?></td>
      <td><?php echo number_format($client['TongTien'],0,',','.');?></td>
    </tr>
<?php 		
}

  ?>
      </tbody>
    </table>