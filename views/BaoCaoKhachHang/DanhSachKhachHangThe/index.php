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
          <th>ID</th>
          <th>Khách hàng</th>
          <th>Ngày</th>
		 <!--  <th>Thẻ</th> -->
      	</tr>
      </thead>
      <tbody>
<?php
$clientsWithCard = $client->getClientsWithCard( $tuNgay, $denNgay, $tuGio, $denGio );
	
foreach($clientsWithCard as $client)
{
?>  
		<tr class="success">
			<td><?php echo $client['MaTheVip'];?></td>
			<td><?php echo $client['TenChuThe'];?></td>
			<td><?php echo date('d-m-Y', strtotime( substr($client['NgayApDung'], 0, 10) ) ); ?></td>

        </tr>
<?php 		
}

  ?>
      </tbody>
    </table>
   </div>