<style>
.form-horizontal{
  width: 78%;
}


.toggle.btn{
  vertical-align: 2px;
}
</style>
<?php 
    if(  isset($_SESSION['signup_success']) && $_SESSION['signup_success'] == 1 )
    {
    echo "<div class='alert alert-success'>
          <strong>Success!</strong> Sign up successful...
        </div>";unset($_SESSION['signup_success']); 
    }

    elseif ( isset($_SESSION['signup_success']) && $_SESSION['signup_success'] == 0  )
    {
    echo "<div class='alert alert-danger'>
          <strong>Alert!</strong> Sign up fail...
    </div>";unset($_SESSION['signup_success']); 
    }

    elseif(  isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == -1 ) 
    {
     echo "<div class='alert alert-warning'>
          <strong>Alert!</strong> Password mismatch...
    </div>";unset($_SESSION['password_mismatch']); 
    }

  elseif(  isset($_SESSION['duplicate_username']) && $_SESSION['duplicate_username'] == -1 ) 
    {
     echo "<div class='alert alert-warning'>
          <strong>Alert!</strong> Username already existed...
    </div>";unset($_SESSION['duplicate_username']);
  }
?>
  <div class="btn-toolbar" style="margin-bottom:10px"> 
    <button class="btn btn-primary" data-toggle="modal" data-target="#them_user">Thêm User </button> 
    <a href="exportExcel" class="btn btn-warning pull-right" >Export Spreadsheet </a> 
  </div>
  <!-- Modal Add User -->
  <div class="modal fade them_user" id="them_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Thông Tin User</h3>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" action="them" method="post">
                  <div class="form-group">
                      <label for="username" class="col-md-3 control-label">ID:</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ""; unset($_SESSION['username']); ?>" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="password" class="col-md-3 control-label">Password:</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="password" id="password" required>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="confirm_password" class="col-md-3 control-label">Confirm Password:</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="confirm_password" id="confirm_password" required >
                          <span id='message'></span>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Tên NV:</label>
                        <div class="col-md-8">
                          <select name="maNV" id="maNV" class="form-control input-lg" required="required" >
                              <option value="" disabled selected> Tên NV</option>
                              <?php
                              $list_NV_arr =  $data['users']; 
                              $maNV = $_SESSION['maNV'];//if(isset( $maNV  ) ) echo "yes";
                              foreach ( $list_NV_arr as $r ) 
                              {
                                if( isset( $maNV  ) && $maNV == $r['MaNV'] )
                                {
                                    echo '<option value="' . $r["MaNV"] . '" selected="selected">' . $r['TenNV'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $r["MaNV"] . '">' . $r['TenNV'] . '</option>';
                                }

                               
                              } unset($_SESSION['maNV']); 
                              ?>

                            </select>
                        </div>
                  </div>

                   <div class="form-group">
                      <label for="reports" class="col-md-3 control-label">Báo Cáo:</label>
                      <div class="col-md-9">
                        <div class="row"></div>
                        <?php
                        $danh_sach_bao_cao = $data["reports"];
                        $bao_cao_duoc_xem_arr = isset($_SESSION['report_arr']) ? $_SESSION['report_arr'] : array();
                        
                        foreach ( $danh_sach_bao_cao as $r ) {
                          if (  in_array( $r['MaBaoCao'], $bao_cao_duoc_xem_arr ) )
                          {
                              echo '
                                <input type="checkbox" checked data-toggle="toggle" name="report_arr[]" value="' . $r['MaBaoCao'] . '" >
                                 <span style="vertical-align:11px">' . $r['TenBaoCao']  . '</span>
                                 <br>
                            ';
                          }
                          else
                          {
                              echo '
                                <input type="checkbox"  data-toggle="toggle" name="report_arr[]" value="' . $r['MaBaoCao'] . '" >
                                 <span style="vertical-align:11px">' . $r['TenBaoCao']  . '</span>
                                 <br>
                            ';
                          }
                        }  unset($_SESSION['report_arr']); ?>
                        </div>
                    </div>


                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit">
                       Submit</button>
                    </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>  
  <!-- End Modal Add User -->
  <div class="well col-md-11" style="background:#fff; font-size: 1.2em;">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>ID</th>
            <th>Tên</th>
            <th>Báo cáo được xem</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
           <?php
          $i = 1;
          $users_list = $data['users']; //var_dump($users_list);die;
          foreach ( $users_list as $r ) { ?>
                                            
          <tr>
            <td><?=$i?></td>
            <td><?=$r['TenSD']?></td>
            <td><?=$r['TenNV']?></td>
            <td><ul style="padding-left:0px">
              <?php 
                  $bao_cao_duoc_xem_arr = ( !empty( $r['BaoCaoDuocXem'] )   ?  unserialize(str_replace('&quot;','"',$r['BaoCaoDuocXem'])) :"" ); 
                  $ten_bao_cao = "";
                  $report_name = "";
                  if ( !empty($bao_cao_duoc_xem_arr ) )
                  foreach ($bao_cao_duoc_xem_arr as $bao_cao_duoc_xem) {
                          $ten_bao_cao = Controller_Users_DanhSachUsers::layBaoCao($bao_cao_duoc_xem);
                          $report_name .=  '<li>' .
                                      $ten_bao_cao . 
                                   '</li>'
                              ;
                  }
                  echo $report_name;
              ?>
            </ul></td>
            <td>
            <?php
              if( $i !== 1 )
                { ?> 
                <a href="" data-toggle="modal" data-target="#edit_user_<?=$r['TenSD']?>"><i class="glyphicon glyphicon-pencil" style="font-size: 1.3em;"></i></a>
                <?php } ?>
            </td>
            <td>
               <?php
               if( $i !== 1 )
                { ?> <a href="xoaUser/<?=$r['TenSD']?>" onclick="return confirm('Are you sure you want to delete?');" role="button" data-toggle="modal"><i class="glyphicon glyphicon-remove-sign" style="color:#F44336; font-size: 1.3em;"></i></a> 
                <?php } ?>
                
            </td>

          </tr>



           <?php $i++; } ?>
        </tbody>
      </table>
  </div> 
<?php
$users_list = $data['users']; //var_dump($users_list);die;
foreach ( $users_list as $r ) 
  { ?>
                              
<!-- Modal Edit User -->
  <div class="modal fade edit_user" id="edit_user_<?=$r['TenSD']?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Edit User</h3>
            </div>
            <div class="modal-body" style="display: block;overflow: auto;">

                <form class="form-horizontal" role="form" action="edit" method="post">
                  <?php 
                    if(  isset($_SESSION['signup_success']) && $_SESSION['signup_success'] == 1 )
                    {
                    echo "<div class='alert alert-success'>
                          <strong>Success!</strong> Sign up successful...
                        </div>";unset($_SESSION['signup_success']); 
                    }

                    elseif ( isset($_SESSION['signup_success']) && $_SESSION['signup_success'] == 0  )
                    {
                    echo "<div class='alert alert-danger'>
                          <strong>Alert!</strong> Sign up fail...
                    </div>";unset($_SESSION['signup_success']); 
                    }

                    elseif(  isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == -1 ) 
                    {
                     echo "<div class='alert alert-warning'>
                          <strong>Alert!</strong> Password mismatch...
                    </div>";unset($_SESSION['password_mismatch']); 
                    }

                    ?>

                  <input type="hidden" class="form-control" name="username" id="username" value="<?=$r['TenSD']?>" >

                  <div class="password_group">
                      <div class="form-group">
                          <label class="col-md-4 control-label">* Đổi mật khẩu</label>
                          <div class="col-md-8">
                            <input type="checkbox" class="" name="changePassword" id="changePassword">
                          </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-3 control-label">Password:</label>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="password" id="password" value="" disabled required>
                              </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="col-md-3 control-label">Confirm Password:</label>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="confirm_password" id="confirm_password" disabled required>
                                <span id='message'></span>
                              </div>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Tên NV:</label>
                        <div class="col-md-8">
                          <select name="maNV" id="maNV" class="form-control input-lg" required="required" >
                              <option value="" disabled selected> Tên NV</option>
                              <?php
                              $list_NV_arr =  $data['users']; 
                              foreach ( $list_NV_arr as $nv ) {

                                if($r["MaNV"] == $nv['MaNV'])
                                {
                                    echo '<option value="' . $r["MaNV"] . '" selected="selected">' . $r['TenNV'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $nv["MaNV"] . '">' . $nv['TenNV'] . '</option>';
                                }

                              }
                              ?>

                            </select>
                        </div>
                  </div>

                   <div class="form-group">
                      <label for="reports" class="col-md-3 control-label">Báo Cáo:</label>
                      <div class="col-md-9">
                        <div class="row"></div>
                        <?php
                          $danh_sach_bao_cao = $data["reports"];//var_dump($danh_sach_bao_cao);
                          $bao_cao_duoc_xem_arr = ( !empty( $r['BaoCaoDuocXem'] )   ? unserialize($r['BaoCaoDuocXem'] ) :array() );
                          foreach ( $danh_sach_bao_cao as $baocao ) {
                              if(  in_array( $baocao['MaBaoCao'], $bao_cao_duoc_xem_arr ) ){
                              echo '<div class="">
                                <label>
                                  <input type="checkbox" checked data-toggle="toggle" name="report_arr[]" value="' . $baocao['MaBaoCao'] . '">
                                   ' . $baocao['TenBaoCao']  . '
                                </label>
                              </div>';
                              }
                              else{
                                  echo '<div class="">
                                <label>
                                  <input type="checkbox" data-toggle="toggle" name="report_arr[]" value="' . $baocao['MaBaoCao'] . '">
                                   ' . $baocao['TenBaoCao']  . '
                                </label>
                              </div>';
                              }

                          } 
                          ?>
                        </div>
                    </div>


                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit">
                       Submit</button>
                    </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>  


  <!-- End Modal Edit User -->


<?php } ?>

<script type="text/javascript">
$('#password, #confirm_password').on('keyup', function () {
  if ( $('#password').val() == $('#confirm_password').val() && $('#password').val() !== '') {
    $('#message').html('Matching').css('color', 'green');
  } else
    $('#message').html('Not Matching').css('color', 'red');
});


$(document).on('change', '#changePassword', function(){
    if($(this).is(':checked'))
    { 
      $(this).parent().parent().parent().find('#password').removeAttr("disabled");
      $(this).parent().parent().parent().find('#confirm_password').removeAttr("disabled");
    }
    else if(!$(this).is(':checked'))
    {
      $(this).parent().parent().parent().find('#password').prop("disabled",true);
      $(this).parent().parent().parent().find('#confirm_password').prop("disabled",true);
      //alert('aa');
    }
});

$(function(){
  $('.them_user').on('submit', 'button', function(){e.preventDefault();
      pass = $('#password').val();
      passAgain = $('#confirm_password').val();
      if( pass !== passAgain ){
        alert('password not matched');
        
      }
  });

});

  </script>
