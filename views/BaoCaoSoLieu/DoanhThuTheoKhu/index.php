<?php
//require_once('helper/security.php');
require_once('lib/BaoCaoSoLieu.php');
$stats = new BaoCaoSoLieu($conn);

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
$doanh_thu = $stats->getDoanhThuTheoKhu($tuNgay, $denNgay, $tuGio, $denGio);
 //pr($doanh_thu);die;
$doanh_thu = removeOuterArr($doanh_thu);

 //pr($doanh_thu);die;


?>
 <h3 class="title">Báo cáo doanh thu theo khu</h3>
 <div class="panel panel-warning">
	<div class="panel-body no-padding">
		<table class="table table-striped doanhthu">
			<thead>
				<tr class="warning">
					<th>Khu</th>
					<th>Số hóa đơn</th>
					<th>Doanh thu thực (VNĐ)</th>
					<th>Tiển dịch vụ (VNĐ)</th>
					<th>Giảm giá (VNĐ)</th>								
					<th>Khách tip (VNĐ)</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($doanh_thu as $dt)
			{ //pr($dt);die; 
			?>
				<tr>
					<td><?php echo $dt['Ma_Khu'] ;?></td>
					<td><?php echo $dt['TongSoHoaDon'];?></td>
					<td><?php echo $dt['TienDichVu'] - $dt['TienGiamGia'];?></td>
					<td><?php echo $dt['TienDichVu'] ;?></td>
					<td><?php echo $dt['TienGiamGia'];?></td>
					<td><?php echo $dt['TienKhachTip'];?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>