<?php

use Lib\NhanVien;
$staff = new NhanVien($conn);
?>

<h3 class="title">TỔNG HỢP TIỀN TIP</h3>
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<table class="table table-striped">
			<thead>
				<tr class="warning">
					<th></th>
					<th>Tiền khách tip (VNĐ)</th>
					<th></th>
					<th>Thực nhận (VNĐ)</th>								
				</tr>
			</thead>
			<tbody>
			<?php
			$rs = $staff->getTongHopTip();
			foreach ($rs as $r) 
			{ ?>
				<tr>
					<td></td>
					<td><?php echo number_format( $r['ThucNhan'],0); ?></td>
					<td></td>
					<td><?php echo number_format( $r['TienKhachTip'],0); ?></td>
				</tr>
			<?php
			} ?>
			</tbody>
		</table>
	</div>
</div>
<h3 class="title">TỔNG HỢP TIP THEO NHÂN VIÊN</h3>
<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã NV</th>
          <th>Tên NV</th>
		  <th>Khách Tip (VNĐ)</th>
          <th>Thực nhận (VNĐ)</th>
        </tr>
      </thead>
      <tbody>
      	<?php
		$rs = $staff->getTipTheoNV();
		foreach ($rs as $r) 
		{ ?>
	      	<tr class="success">
				<td><?php echo $r['MaNV'];?></td>
				<td><?php echo $r['TenNV'];?></td>
	            <td><?php echo number_format($r['TienKhachTip'],0);?></td>
	            <td><?php echo number_format($r['TienThucNhan'],0);?></td>
	        </tr>
        <?php } ?>
      </tbody>
	</table>
</div> 	
