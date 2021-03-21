<?php

use Lib\KhachHang;

$client = new KhachHang($conn);

if(  isset($_SESSION['add_success']) )
{
    echo "<div class='alert alert-success'>" .
         $_SESSION['add_success']
        . "</div>";
    unset($_SESSION['add_success']); 
}


if(  isset($_SESSION['del_success']) )
{
    echo "<div class='alert alert-success'>" .
         $_SESSION['del_success']
        . "</div>";
    unset($_SESSION['del_success']); 
}

if( isset($_SESSION['error']) )
{
  echo "<div id=\"error\"></div>";

}


$rs = $client->getMaNhomKH();
$nhomKH = [];
foreach($rs as $r)
{
  $nhomKH[] =  [ $r['Ma'] => $r['Ten'] ];
}
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

.editable-click{
  border-bottom: none;
}
</style>
<div class="row" style="margin:10px 0">
  
	<button class="btn btn-primary pull-left" style="margin-bottom: 5px" data-toggle="modal" data-target="#addNewClient"><b>+</b> Add</button>
	<button type="button" class="btn btn-large btn-info pull-right"><a href="excel-export.php" style="color:#fff" >Export CSV</a></button>
	
</div>
<?php include_once('add_client_modal.php'); 
unset($_SESSION['error']);?>
<div class="row">

  <div class="col-md-12">
    <table class="table" id="kh_list">
      <thead>
        <tr>
          <th>Mã</th>           
          <th>Tên</th>    
          <th></th>
          <th>Điện thoại</th>
          <th>Địa chỉ</th>
          <th>Nhóm</th>
          <th>Ghi chú</th>          
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
              </td>      
              <td>
                <button type="button" class="btn btn-info btn-xs" style="float: right" data-toggle="modal" data-target="#product_view_<?=$client->MaDoiTuong?>" data-target="#product_view">
                  <span class="glyphicon glyphicon-user"></span> History
                </button>
              </td>
              <td><?php echo $client->DienThoai;?></td>
              <td><?php echo $client->DiaChi;?></td>
              <td><?php echo $client->MaNhomKH;?></td>
              <td><?php echo $client->GhiChu;?></td>
              <td><button type="button" class="btn btn-xs btn-danger pull-left clearField"> <a href="action/delete_action.php?xoaClient=<?=$client->MaDoiTuong?>" onclick="return confirm('Are you sure you want to delete?');" style="color: #fff"> <span class="glyphicon glyphicon-remove clearField"></span></a></button></td>
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
<?php

?>

          </tbody>
        </table> 
      </div>
		          <!-- /#col-md-12 -->
	         

</div>
<script>
var source = <?=json_encode($nhomKH);?>;
var error = $('div#error');
if( error.length > 0 ){
  $('#addNewClient').modal('show');
}

$(document).ready(function() {
  // $.noConflict();
    $('#kh_list').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        createdRow:function(row, data, rowIndex)
        {
          $.each($('td', row), function(colIndex){
            if(colIndex == 1)
            {
              $(this).attr('data-name', 'TenDoiTuong');
              $(this).attr('class', 'TenDoiTuong');
              $(this).attr('data-type', 'text');
              $(this).attr('data-pk', data[0]);
            }
            if(colIndex == 3)
            {
              $(this).attr('data-name', 'DienThoai');
              $(this).attr('class', 'DienThoai');
              $(this).attr('data-type', 'text');
              $(this).attr('data-pk', data[0]);
            }
            if(colIndex == 4)
            {
              $(this).attr('data-name', 'DiaChi1');
              $(this).attr('class', 'DiaChi1');
              $(this).attr('data-type', 'text');
              $(this).attr('data-pk', data[0]);
            }
            if(colIndex == 5)
            {
              $(this).attr('data-name', 'MaNhomKH');
              $(this).attr('class', 'MaNhomKH');
              $(this).attr('data-type', 'select');
              $(this).attr('data-pk', data[0]);
            }
            if(colIndex == 6)
            {
              $(this).attr('data-name', 'GhiChu');
              $(this).attr('class', 'GhiChu');
              $(this).attr('data-type', 'text');
              $(this).attr('data-pk', data[0]);
            }
          });
        }
    });
});

 $('#kh_list').editable({
    container:'body',
    selector:'td.TenDoiTuong',
    url:'action/edit_action.php',
    toggle: 'dblclick',
    title:'Name',
    emptytext: "",
    validate:function(value){
      if($.trim(value) == '')
      {
        return 'This field is required';
      }

    },
    success: function(response, newValue) {
      if ( response.length > 0 ){
        let output = JSON.parse(response) ;
        if(output.success == false) 
          return output.msg;
      }
    }
  });

  $('#kh_list').editable({
    container:'body',
    selector:'td.DienThoai',
    url:'action/edit_action.php',
    toggle: 'dblclick',
    title:'Tel  No.',
    type:'POST',
    emptytext: "",
    validate:function(value){
      let phoneNo = $.trim(value);
      let phoneRegex =/((09|03|07|08|05)+([0-9]{8})\b)/g;

      if($.trim(value) == '')
      {
        return 'This field is required';
      }

      if(phoneNo.length > 10 || phoneRegex.test( phoneNo ) === false  )
      {  
        return 'Invalid phone number';
      }
    },
    success: function(response, newValue) {
      if ( response.length > 0 ){
        let output = JSON.parse(response) ;
        if(output.success == false) 
          return output.msg; //msg will be shown in editable form
      }
    }


  });

  $('#kh_list').editable({
    container:'body',
    selector:'td.DiaChi1',
    url:'action/edit_action.php',
    toggle: 'dblclick',
    title:'Address',
    emptytext: ""
  });

   $('#kh_list').editable({
    container:'body',
    selector:'td.MaNhomKH',
    url:'action/edit_action.php',
    toggle: 'dblclick',
    source:source,
    emptytext: "",
    validate:function(value){
      if($.trim(value) == '')
      {
        return 'This field is required';
      }

    },
    success: function(response, newValue) {
       if ( response.length > 0 ){
        let output = JSON.parse(response) ;
        if(output.success == false) 
          return output.msg; //msg will be shown in editable form
        }
    }
    });

   $('#kh_list').editable({
    container:'body',
    selector:'td.DiaChi1',
    url:'action/edit_action.php',
    toggle: 'dblclick',
    title:'Address',
    emptytext: ""
  });
</script>
<!-- <div id="app">
  <input v-model="message" placeholder="edit me">
  <p>Message is: {{ message }}</p>
</div>
<script type="text/javascript">
  const app = new Vue({
    el: '#app',
    data:{
      message: '',

    }
  });

  app.message = 'Dean'
</script> -->