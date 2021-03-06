<?php
require_once('lib/BaoCaoSoLieu.php');
$staff = new BaoCaoSoLieu($conn);

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

<h3 class="title">DOANH THU NHÂN VIÊN</h3>
<div class="bs-example4" data-example-id="contextual-table">
<table class="table">
   <thead>
    <tr>
      <th>ID</th>
      <th>Nhân viên</th>
      <th>Doanh thu</th>
    </tr>
  </thead>
  <tbody>
<?php
$salesByStaff = $staff->getSalesByStaff( $tuNgay, $denNgay, $tuGio, $denGio , $totalMoney );
$totalMoney = number_format($totalMoney,0,',','.'); 
?>  
  <tr class="success">
    <td>Tổng cộng</td>
    <td></td>
    <td><?php echo $totalMoney;?></td>
  </tr>
<?php
	
foreach($salesByStaff as $staff)
{
?>  
    <tr class="success">
      <td><?php echo $staff['MaNV'];?></td>
      <td><?php echo $staff['TenNV'];?></td>
            <td><?php echo number_format($staff['DoanhThu'],0,',','.');?></td>
        </tr>
<?php     
}

  ?>
      </tbody>
    </table>