<?php
require_once('lib/BaoCaoSoLieu.php');
$product = new BaoCaoSoLieu($conn);
//tblTonKhoPhatSinh
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

<h3 class="title">Báo Cáo Tồn Kho</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Tên Hàng Bán</th>
          <th>Mã DVT</th>
		      <th>Số Lượng</th>
          <th>Thành Tiền</th>
        </tr>
      </thead>
      <tbody>
<?php
$topTenItems = $product->getTopTenItems( $tuNgay, $denNgay, $tuGio, $denGio , $totalQty, $totalMoney );
//var_dump($topTenItems);die;
$totalQty = number_format($topTenItems[0][0]['TotalQty'],0,',','.');
$totalMoney = number_format($topTenItems[0][0]['TotalMoney'],0,',','.'); 
?>  
		<tr class="success">
			<td>Tổng cộng</td>
			<td></td>
			<td><?php echo $totalQty?></td>
          	<td><?php echo $totalMoney;?></td>
        </tr>
<?php
	
foreach($topTenItems[1] as $food)
{
?>  
		<tr class="success">
			<td><?php echo $food['TenHangBan'];?></td>
			<td><?php echo $food['MaDVT'];?></td>
			<td><?php echo number_format($food['TongSoLuong'],0,',','.')?></td>
      <td><?php echo number_format($food['ThanhTien'],0,',','.');?></td>
        </tr>
<?php 		
}

  ?>
      </tbody>
    </table>
   </div>
		
