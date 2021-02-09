<?php
$page_name = "BaoCaoNhanVien";
require_once('helper/security.php');
require_once('lib/NhanVien.php');
$staff = new NhanVien($conn);

?>
<style>
.table.doanhthu > tbody > tr:first-child > td {
    color: green;
    font-weight: 700;
}
.tuGio, .denGio{
  display:none;
}
</style>
<form action="" method="post">
   <?php require_once('datetimepicker_all.php'); ?> 
</form> 
<?php
$tuNgay = date('Y-m-d', strtotime($tuNgay));
$denNgay = date('Y-m-d', strtotime($denNgay));
$rs = $staff->getChamCong( $tuNgay, $denNgay );
$countSoChamCong = count($rs);
?>
<h3 class="title">TỔNG LƯỢT CHẤM CÔNG: <?php echo number_format($countSoChamCong,0); ?></h3>
<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã NV</th>
          <th>Tên NV</th>
          <th>Vân tay</th>
		  <th>Giờ vào</th>
          <th>Giờ ra</th>
		  <th>Số giờ</th>
		  <th>Ghi chú</th>
        </tr>
      </thead>
      <tbody>
      	<?php
      	foreach ( $rs as $r )
      	{ ?> 
      	<tr class="success">
		  <td><?php echo $r['MaNhanVien'];?></td>
		  <td><?php echo $r['TenNV'];?></td>
		  <td><?php echo $r['MaThe'];?></td>
		   <td><?php echo $r['GioVao'];?></td>		
		  <td><?php echo $r['GioRa'];?></td>	
		  <td><?php echo round($sogio,2);?></td>
		  <td><?php echo $r['GhiChu'];?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>