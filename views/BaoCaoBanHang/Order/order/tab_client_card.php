<!-- Search and Select plugin --> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<style>
.form-inline label {
    line-height: 34px;
}

.form-inline .form-group > div.col-md-8 {
    padding-left: 0;
    padding-right: 0;
}

.form-inline .form-group {
    margin-bottom: 15px;
  }

.selectize-input {
  width: 15em;
}

button#client_search, button#clear_info
{
  margin-bottom: 12px;
}

#tab2default .form-horizontal .form-group {
    margin-right: 7px;
    margin-left: -36px;
}
</style>

<script>
$(function() {
  //$.noConflict();
   $('select').selectize({
      sortField: 'text'
   });
});

</script>
<?php
$rs = $sgDep->getClientInfo($ma_doi_tuong="01-201909-006");
//var_dump($rs);
?>
<div class="panel panel-info">
  <div class="panel-heading">
        <ul class="nav nav-tabs"> <button type="button" class="btn btn-default test">button</button>
            <li class="active"><a href="#tab1default" data-toggle="tab">Khách Hàng</a></li>
            <li><a href="#tab2default" data-toggle="tab">Thẻ VIP</a></li>
        </ul>
   </div>
  <div class="panel-body">
    <div class="tab-content">

      <div class="tab-pane fade in active" id="tab1default" style="margin-top: -20px;">

          <button type="button" id="client_search"  class="btn btn-warning" data-toggle="modal" data-target="#search_popup"><i class="fa fa-search"></i> Search</button>
          <button type="button" id="clear_info"  class="btn btn-danger pull-right"><i class="fa fa-minus-circle"></i> Clear </button>
          <form  id="client_form" class="form-horizontal" role="form" action="customer/new-client.php" method="post">

            <?php
            if( isset( $_SESSION['insert_error'] ) )
            {
              echo '<div class="alert alert-danger" style="width:34%">' . 
                           $_SESSION['insert_error'] .
                        '</div>';
                        unset($_SESSION['insert_error']);
            }

            if( isset($_SESSION['insert_success']))
            {
              echo '<div class="alert alert-success" style="width:34%">' . 
                     $_SESSION['insert_success'] .
                  '</div>';
                  unset($_SESSION['insert_success']);
            }
            
            ?>
            <div class="form-group">
                <label for="client_code" class="col-md-4" >ID:</label>
                <div class="col-md-8">
                    <select type="text" class="form-control" name="client_code" value="<?=$makhachhang?>" id="client_code">
                        <option disabled selected></option>
                        <?php
                          $rs = $sgDep->getCustomersList();
                          foreach($rs as $r)
                          {
                            ?> 
                               <option value="<?=$r['MaDoiTuong']?>"><?=$r['MaDoiTuong']?></option>
                            <?php

                          }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="client_name" class="col-md-4" >Tên:</label>
                <div class="col-md-8">
                    <select type="text" class="form-control" name="client_name" value="<?=$tenkhachhang?>" id="client_name">
                        <option disabled selected></option>
                        <?php
                          $rs = $sgDep->getCustomersList();
                          foreach($rs as $r)
                          {
                            ?> 
                               <option value="<?=$r['TenDoiTuong']?>"><?=$r['TenDoiTuong']?></option>
                            <?php

                          }
                        ?>
                    </select>
                </div>
             </div>

            <div class="form-group">
                <label for="client_tel" class="col-md-4">SĐT:</label>
                <div class="col-md-8">
                  <select type="text" class="form-control" name="client_tel" value="<?=$tenkhachhang?>" id="client_tel">
                        <option disabled selected></option>
                        <?php
                          $rs = $sgDep->getCustomersList();
                          foreach($rs as $r)
                          {
                            ?> 
                               <option value="<?=$r['DienThoai']?>"><?=$r['DienThoai']?></option>
                            <?php

                          }
                        ?>
                    </select>
                </div>
            </div>
         
            <div class="form-group">
                <label for="client_address" class="col-md-4" >Địa chỉ:</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="client_address"  id="client_address" value="<?=$diachi?>" >
                </div>
            </div>

          </form>

      </div>

      <div class="tab-pane fade" id="tab2default">
          <form class="form-horizontal" role="form" action="customer/new-client.php" method="post">

            <div class="form-group">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="client_vip" class="col-md-4 control-label">VIP:</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="client_vip" id="client_vip" value="<?=$mathevip?>" >
                    </div>
                </div>
              </div>
            </div>


            <div class="form-group">
              <div class="col-md-12">
                <div class="form-group">
                    <label for="client_card" class="col-md-4 control-label">Loại Thẻ:</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="client_card" id="client_card" >
                      </div>
                </div>
              </div>
            </div>

          </form>
      </div>

    </div>
  </div>
</div>

<?php require('search_popup.php'); ?>

<script type="text/javascript">

$('#clear_info').click(function(){console.log($('#client_vip'));

    $('form#client_form select').each(  function() {
       $(this)[0].selectize.clear();
    });

    $('#client_address').val('');
    $('#client_vip').val('');
    $('#client_card').val('');

});


$('#client_search').on('click', function (event){
    //event.preventDefault();
    var client_code = $('#client_code').val();
    var client_name = $('#client_name').val();//console.log(denNgay);
    var client_tel = $('#client_tel').val();
    var k = 0;

    $.ajax({
      url:"../Order/order/ajax/client_search.php",
      method:"POST",
      data:{'client_code' : client_code, 'client_name' : client_name, 'client_tel' : client_tel},
      dataType:"json",
      success:function(output)
      {
        
          $('#search_popup table tbody').html(output);
      },
      error: function (xhr, textStatus, errorThrown) {
         console.log(xhr.responseText);
      },
      complete: function() { 

          var request = false; console.log(request);
          $("table#client_info").on('click', '[id^="client_selected"]', function(){
            console.log("click start: " + request);
            let client_code = $(this).parent().parent().find('td.sorting_1').text();
            console.log("loop start: " + request);
              if( request  == false )
              {
                $.ajax({
                  url:"../Order/order/ajax/client_selected.php",
                  method:"POST",
                  data:{'client_code' : client_code},
                  dataType:"json",
                  success:function(output)
                  {   
                    
                      $("#search_popup").modal("hide");

                      console.log(output);
                      i = 0;
                      $('form#client_form select').each(  function() {
                        //console.log(i + ": each loop");
                        selectizeInput = $(this)[0].selectize;//console.log(selectizeInput);
                        selectizeInput.clear();
                        selectizeInput.setValue(output[i], false);
                        i++;
                      });

                      $('#client_address').val(output[3]);
                      $('#client_vip').val(output[4]);
                      $('#client_card').val(output[5]);

                  },
                  complete: function() { request = !request; 
                  }
                });
              }
           });
 
      } 
       
      

    });

});

</script>