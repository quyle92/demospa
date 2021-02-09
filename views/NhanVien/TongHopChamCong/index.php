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
$rs = $staff->getTongHopChamCong( $tuNgay, $denNgay );
//pr($rs);die;
?>
<h3 class="title">TỔNG HỢP  CHẤM CÔNG</h3>
<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Tên NV</th>
          <th>Công ngày</th>
          <th>Đi Trễ/Về sớm</th>
          <th>Tăng ca</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      	<?php
      	foreach ( $rs as $r )
      	{ ?> 
      	<tr class="success">
            <td><?php echo $r['TenNV'];?></td>
            <td><?php echo number_format($r['CongNgay'],0);?></td>
            <td><?php echo number_format($r['DiTreVeSom'],0);?></td>
            <td><?php echo number_format($r['TangCa'],0);?></td>
            <td></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>