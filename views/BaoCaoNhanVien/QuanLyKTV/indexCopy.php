<?php
require_once('lib/NhanVien.php');
$ktv = new NhanVien($conn);
$themmoi = 0; $chinhsua = "0"; 
?>

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1>THÔNG TIN KTV</h1>
    <form action="KTV_update.php" method="post" >
      <p>Mã : </p>
      <p><input type="hidden" name="maktvcu" value="<?php echo @$maktvcu; ?>" style="width:100%;">
      <input type="text" name="maktvmoi" value="<?php echo @$maktvcu; ?>" style="width:100%;"></p>
      <p>Tên : </p>
      <p><input type="text" name="tenktv" value="<?php echo @$tenktv; ?>" style="width:100%;"></p>   
      <p>Thông tin : </p>
      <p><input type="text" name="ghichu" value="<?php echo @$ghichu; ?>" style="width:100%;"></p>     
      <p>Id vân tay : </p>
      <p><input type="text" name="vantay" value="<?php echo @$mavantay; ?>" style="width:100%;"></p>     
      <p>Ghi chú DV : </p>
      <p><input type="text" name="ghichudichvu" value="<?php echo @$ghichudichvu; ?>" style="width:100%;"></p>       
      <p>Tên Hình : </p>
      <p><input type="text" name="tenhinh" value="<?php echo @$tenhinh; ?>" style="width:100%;">
      </p>
      <p style="padding-top:20px;"></p>
      <input type="submit" name="btn_update" value="Cập nhật">
    </form>
  </div>
</div>

<?php
if($chinhsua == "1" || $themmoi == 1)  // co thong tin nhập típ
{
  $chinhsua = "0"; // tắt cờ nhập típ
  $themmoi = 1;
?>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//btn.onclick = function() {
    modal.style.display = "block";
//}

span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<?php
}//end if co danh gia -> hien modal
?>
<!-- End The Modal -->

<div  id="ktv_list_selected">
    <div class="form-group" >
       <div class="col-sm-6 col-md-2">
            <select  class="form-control">
              <option selected="true" disabled="disabled">Chọn Nhóm KTV</option>
              <option value="all">Tất cả</option>
        <?php
        $ktvGroup = $ktv->getKTVGroup();
        foreach($ktvGroup as $r)
        {
        ?>
          <option value="<?=$r['Ten']?>"><?=$r['Ten']?></option>

        <?php
        }
        ?>
           </select>
        </div>
    </div>
</div>
<div  id="ktv_list_tour_order">
    <div class="form-group">
       <div class="col-sm-6 col-md-2">
            <select  class="form-control">
              <option selected="true" disabled="disabled">Chọn thứ tự tour</option>
              <option value = 'all'>Tất cả </option>
							<option value = 1>Có </option>
              <option value = 0>Không </option>
           </select>
        </div>
    </div>
</div>


<div class="row">
</div>
	         <div class="row">
		          <div class="col-md-12">
                <table class="table" id="ktv_list">
                <thead>
                  <tr>
                    <th>Mã</th>           
                    <th>KTV</th>    
                    <th>Nhóm</th>
                    <th>Thứ tự làm</th>
                    <th>Số tour theo lượt</th>
                    <th>Số tour yêu cầu</th>          
                    <th>Giờ vào</th>             
                    <th>Giờ ra</th>              
                    <th>Action</th>             
                  </tr>
            </thead>
            <tbody>
<?php 
$ktv_list = $ktv->getAllKTV();
$ktv_arr = array();

foreach($ktv_list as $r)
{
  $ktv_arr[] = [
          'MaNV' => $r['MaNV'], 
          'TenNV' => $r['TenNV'], 
          'NhomNhanVien' => $r['NhomNhanVien'], 
          'TenNhomNV' => $r['TenNhomNV'], 
          'ThuTuDieuTour' => $r['ThuTuDieuTour'], 
          'GhiChuNV' => $r['GhiChuNV'], 
          //'HinhAnhTemp' => $r['HinhAnhTemp'], 
          'GioBatDau' => $r['GioBatDau'], 
          'GioKetThuc' => $r['GioKetThuc'], 
          'GhiChu' => $r['GhiChu'],
          'MaPhieuDieuTour' => $r['MaPhieuDieuTour'],
          'MaBanPhong' => $r['MaBanPhong'],
          'TenHangBan' => $r['TenHangBan'],
          'GioThucHien' => $r['GioThucHien'],
          'SoLanPhucVu' => $r['SoLanPhucVu'],
          'SoSaoDuocYeuCau' => $r['SoSaoDuocYeuCau']
  ];
}
//var_dump( $ktv_arr[0]['ThuTuDieuTour']);
$manvtemp = "";
$ktv_list =  customizeArrayKTV( $ktv_arr );//var_dump(($ktv_list["001"]));die;  
foreach( $ktv_list as $ktv )
{
  $manvtemp = $ktv->MaNV.",".$ktv->NhomNhanVien;
?>
    <tr class="success">
        <td><?php echo $ktv->MaNV;?></td>            
        <td><?php echo $ktv->TenNV;?>
        </td>      
        <td><?php echo $ktv->TenNhomNV;?></td>
        <td><?php echo $ktv->ThuTuDieuTour;?></td>
        <td><?php echo $ktv->SoLanPhucVu;?></td>
        <td><?php echo $ktv->SoSaoDuocYeuCau;?></td>
        <td><?=isset($ktv->GioBatDau) ? $ktv->GioBatDau : ""?></td>
        <td><?=isset($ktv->GioKetThuc) ? $ktv->GioKetThuc : ""?></td>
        <td><?php 
        if( $ktv->ThuTuDieuTour > 0 )
            { ?>
              <button name="raca" id="raca" style="background-color: red;color:white;width:90px" value="<?=$manvtemp?>">Ra ca</button>
          <?php } else 
          { ?>
            <button name="vaoca" id="vaoca" style="background-color: green;color: white;width:90px"  value="<?=$manvtemp?>">Vào ca</button>  
          <?php } ?></td>
    </tr>
          
<?php } ?>


<script>


$(function() {

    var selectedKTV = $('#ktv_list_selected');
   $('#ktv_list_selected').remove();

   var orderTour = $('#ktv_list_tour_order');
   $('#ktv_list_tour_order').remove();

    // $.noConflict(); 
    function createTable () { 
        $('#ktv_list').DataTable({
          "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
           "pageLength": 10,
          "drawCallback": function( settings ) {
             $('#ktv_list_filter').after(selectedKTV);
             $('#ktv_list_selected').after(orderTour);

          } 
        });
    }
    
    createTable();

        $('#ktv_list_selected select').change(function(){

              let selected = $(this);
              var ktv = selected.val();

              let table = $('#ktv_list').DataTable();
              
              if(ktv !== "all")
              {
                table.column(2).search( ktv ).draw();//(1)
                table.on( 'search.dt', function () {//(2)
                   // console.log('Currently applied global search: '+table.search() );
                 });
              } 

              if (ktv === "all") 
              {
               
                if ( $('#ktv_list_tour_order select option:selected').val() == 'all')
                {
                    table.destroy();
                    createTable ();
                }
                else
                {   
                    let selectedOrderTour =  $('#ktv_list_tour_order select option:selected').val();
                   
                    if(selectedOrderTour == 0)
                    {
                      let regExSearch  = '^$|^0$' ;//match empty or 0
                        table.columns().search( '' ).columns( 3 ).search( regExSearch, true, false ).order( [ 1, 'desc' ] ).draw();
                    }
                    else if (selectedOrderTour == 1)
                    {
                       let regExSearch  = '[1-9]';
                        table.columns().search( '' ).columns( 3 ).search( regExSearch, true, false ).order( [ 3, 'asc' ] ).draw();
                    }    

                }
              }

          });

         $('#ktv_list_tour_order select').change(function(){//alert($(this).val());

              let selected = $(this);
              let orderTour = parseInt( selected.val() );
              let table = $('#ktv_list').DataTable();

              switch (orderTour){
                case 0:{
                  let regExSearch  = '^$|^0$' ;//match empty or 0
                  table.column( 3 ).search( regExSearch, true, false ).order( [ 1, 'desc' ] ).draw();
                   break;
                }
                case 1:{
                  let regExSearch  = '[1-9]';
                  table.column( 3 ).search( regExSearch, true, false ).order( [ 3, 'asc' ] ).draw();
                   break;
                }
                default: {
                  
                  if ( $('#ktv_list_selected select option:selected').val() == 'all')
                  {
                    table.destroy();
                    createTable ();
                  }
                  else
                  {  
                    table.columns().search( '' ).columns( 2 ).search( $('#ktv_list_selected select option:selected').val() ).draw();
                  }

               }

              }

          });



  } );


</script>
              </tbody>
              </table> 
		          </div>
		          <!-- /#col-md-12 -->
	         </div>


<script>
var first = true; 

$(document).on("click","#raca", function () {

    if(first)
    {
      $(this).css({"background":"green"});
      $(this).html('Vào ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':0}; 
        $.post(ajaxurl, data, function (response) {
        });
     // setTimeout('window.location="KTV_list.php"',0);
    }
    else
    {
      $(this).css({"background":"red"});
      $(this).html('Ra ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':1};
        $.post(ajaxurl, data, function (response) {
        });
       // setTimeout('window.location="KTV_list.php"',0);
    }

    first = !first; // Invert `first`
});
</script>
<script>
var first1 = true; 

$(document).on("click","#vaoca", function () {

    if(!first1)
    {
      $(this).css({"background":"green"});
      $(this).html('Vào ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':0};
        $.post(ajaxurl, data, function (response) {
        });

      setTimeout('window.location="KTV_list.php"',0);
    }
    else
    {
      $(this).css({"background":"red"});
      $(this).html('Ra ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':1};
        $.post(ajaxurl, data, function (response) {
        });
      setTimeout('window.location="KTV_list.php"',0);
    }

    first1 = !first1; // Invert `first`
});
</script>

<!-- Note
(1): this is to avoid jQuery conflict. Ref: https://stackoverflow.com/a/7882412/11297747

 -->