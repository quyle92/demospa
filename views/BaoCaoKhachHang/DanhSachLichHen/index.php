<?php

use Lib\KhachHang;

$client = new KhachHang($conn);
?>
<style>
.table.doanhthu > tbody > tr:first-child > td {
    color: green;
    font-weight: 700;
}
</style>
<form action="" method="post">
   <?php require_once('datetimepicker_all.php'); ?> 
</form> 
<?php
$tuNgay = date('Y-m-d', strtotime($tuNgay));
$denNgay = date('Y-m-d', strtotime($denNgay));

?>
    <h3 class="title">Danh sách khách hàng - thẻ</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã booking</th>
          <th>Mã Khách hàng</th>
          <th>Khách hàng</th>
          <th>Số lượng</th>
          <th>Dịch vụ</th>
          <th>Giờ bắt đầu</th>
          <th>Giờ kết thúc</th>
        </tr>
      </thead>
      <tbody>
<?php
$clientAppointments = $client->getClientAppointments( $tuNgay, $denNgay, $tuGio, $denGio );
	
foreach($clientAppointments as $client)
{
?>  
		<tr class="success">
      <td><?php echo $client['MaBooking'];?></td>
      <td><?php echo $client['MaKH'];?></td>
      <td><?php echo $client['TenKH'];?></td>
      <td><?php echo $client['SoLuong'];?></td>
      <td><?php echo $client['DichVu'];?></td>
      <td><?php echo date('d-m-Y H:i:s', strtotime( $client['GioBatDau'] ) ); ?></td>
      <td><?php echo date('d-m-Y H:i:s', strtotime( $client['GioKetThuc']) ); ?></td>
    </tr>
<?php 		
}

  ?>
      </tbody>
    </table>
   </div>