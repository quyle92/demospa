<?php

use Lib\NhanVien;

$staff = new NhanVien($conn);
$rs =  $staff->getNhanVien() ;
//$rs = removeOuterArr($rs);
$tongnhanvien = $rs[1][0]["tongnhanvien"];

?>

    <h3 class="title">TỔNG SỐ NHÂN VIÊN : <?php echo $tongnhanvien; ?></h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã</th>
		  <th>Họ Tên</th>
		  <th>Nhóm</th>
          <th>Vân tay</th>
		  <th>Lương CB</th>
		  <th>Chức vụ</th>
        </tr>
      </thead>
      <tbody>
      	<?php
      	$staffList = isset($rs[0]) ? $rs[0] : array();
      	foreach ( $staffList as $r )
      	{ ?> 
		<tr class="success">
			<td><?php echo $r['MaNV'];?></td>
          	<td><?php echo $r['TenNV'];?></td>
          	<td><?php echo $r['TenNhomNV'];?></td>
          	<td><?php echo $r['MaVanTay'];?></td>
          	<td><?php echo number_format($r['LuongCB'],0);?></td>
		  	<td><?php echo $r['TenChucVu'];?></td>
        </tr>
	    <?php 
		}
	    ?>
      </tbody>
    </table>
   	</div>