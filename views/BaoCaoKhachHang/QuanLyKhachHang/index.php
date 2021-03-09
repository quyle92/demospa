<?php
require_once('lib/KhachHang.php');
$client = new KhachHang($conn);
?>
<style>
/**
 * Fake table
 */
 .Table
{
    display: table;
}
.Heading
{
  display: table-header-group;
  font-weight: bold;
  text-align: center;
  background-color: #ddd;
}
.Table .Row
{
  display: table-row;
}
.Cell
{
  display: table-cell;
  width: 27%;
  border: solid;
  border-width: thin;
  padding: 3px 10px;
  border: 1px solid #999999;
  text-align: center;
}
</style>
<div class="row" style="margin:10px 0">
  
	<button class="btn btn-primary pull-left" style="margin-bottom: 5px" data-toggle="modal" data-target="#addNewClient"><b>+</b> Add</button>
	<button type="button" class="btn btn-large btn-info pull-right"><a href="excel-export.php" style="color:#fff" >Export CSV</a></button>
	
</div>
<?php include_once('add_client_modal.php'); ?>
<div class="row">

  <div class="col-md-12">
    <table class="table" id="kh_list">
      <thead>
        <tr>
          <th>Mã</th>           
          <th>Tên</th>    
          <th>Điện thoại</th>
          <th>Địa chỉ</th>
          <th>Nhóm</th>
          <th>Ghi chú</th>          
          <th>Chỉnh sửa</th>       
          <th>Xóa</th>       
        </tr>
      </thead>
    <tbody>
<?php 
$client_list = $client->getAllClients();
$clients = array(); 

foreach($client_list as $r )
{
  $clients[] = [
          'MaDoiTuong' => $r['MaDoiTuong'], 
          'TenDoiTuong' => $r['TenDoiTuong'], 
          'MaNhomKH' => $r['MaNhomKH'], 
          'DienThoai' => $r['DienThoai'], 
          'DiaChi' => $r['DiaChi'], 
          'GhiChu' => $r['GhiChu'], 
          'MaLichSuPhieu' => $r['MaLichSuPhieu'], 
          'TienThucTra' => $r['TienThucTra'], 
          'GioVao' =>$r['GioVao'],
          'MaNhanVien' => $r['MaNhanVien']
  ];
}
//var_dump($clients);die; 
$client_list =  customizeArrayKH( $clients );//var_dump(sizeof($client_list));die; 
foreach( $client_list as $client )
{
?>
          <tr class="success">
              <td><?php echo $client->MaDoiTuong;?></td>            
              <td><?php echo $client->TenDoiTuong;?>
                <button type="button" class="btn btn-info btn-xs" style="float: right" data-toggle="modal" data-target="#product_view_<?=$client->MaDoiTuong?>" data-target="#product_view">
                  <span class="glyphicon glyphicon-user"></span> History
                </button>
              </td>      
              <td><?php echo $client->DienThoai;?></td>
              <td><?php echo $client->DiaChi;?></td>
              <td><?php echo $client->MaNhomKH;?></td>
              <td><?php echo $client->GhiChu;?></td>
              <td><a href="KTV_list.php?maktv=<?php echo $client->MaNhanVien; ?>&chinhsua=1">Chỉnh sửa</a></td>
              <td><a href="KTV_list.php?maktv=<?php echo $client->MaNhanVien; ?>&xoa=1">Xóa</a></td>             
          </tr>

<div class="modal fade product_view" id="product_view_<?=$client->MaDoiTuong?>">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
              <h3 class="modal-title">Lịch sử khách hàng</h3>
          </div>
          <div class="modal-body">
                <div class="container">
                    <div class="row col-md-6 custyle">
                        <div class="Table">
                            <div class="Heading">
                                <div class="Cell"><?php //$i = 0;var_dump($client->GioVao[$i]->format('d/m/Y') );die;?>
                                    <p><strong>Mã Lịch Sử Phiếu</strong></p>
                                </div>
                                <div class="Cell">
                                    <p><strong>Ngày Vào</strong></p>
                                </div>
                                <div class="Cell">
                                    <p><strong>Tổng Tiền</strong></p>
                                </div>
                            </div>
                            <?php
                            $i = 0;//var_dump($client->GioVao[$i]->format('d/m/Y') );die;
                            foreach( $client->MaLichSuPhieu as $bill_id)
                            {
                            ?>
                            <div class="Row">
                                <div class="Cell">
                                    <p><?=$bill_id?></p>
                                </div>
                                <div class="Cell">
                                    <p><?=(isset($client->GioVao[$i])) ? substr($client->GioVao[$i],0,10) : ""?> </p>
                                </div>
                                <div class="Cell">
                                    <p> <?=number_format($client->TienThucTra[$i],0,",",".")?><sup>đ</sup></p>
                                </div>
                            </div>
                            <?php $i++;
                            } ?>
                        </div>
                    </div>
                </div>                    
          </div>
      </div>
  </div>
</div>          
<?php } ?>
<script>
$(document).ready(function() {
  // $.noConflict();
    $('#kh_list').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
} );
</script>
                </tbody>
              </table> 
		        </div>
		          <!-- /#col-md-12 -->
	         

</div>