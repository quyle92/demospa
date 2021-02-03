<?php 
//require_once('./helper/security.php');
require_once('./lib/Users.php');
$user = new Users($conn); 

?>
<style>
.form-horizontal{
  width: 78%;
}


.toggle.btn{
  vertical-align: 2px;
}

small.field-msg.error{
  color:red;

}
</style>
<?php 
//Add status message
if( isset($_SESSION['error']) )
{
  echo "<div id=\"error\"></div>";

}

// if ( isset($_SESSION['add_success']) && $_SESSION['add_success'] == 0  )
// {
// echo "<div class='alert alert-danger'>
//       <strong>Alert!</strong> Add user failed...
// </div>";unset($_SESSION['add_success']); 
// }

// if(  isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == -1 ) 
// {
//  echo "<div class='alert alert-warning'>
//       <strong>Alert!</strong> Password mismatch...
// </div>";unset($_SESSION['password_mismatch']); 
// }

// if(  isset($_SESSION['duplicate_username']) && $_SESSION['duplicate_username'] == -1 ) 
// {
//  echo "<div class='alert alert-warning'>
//       <strong>Alert!</strong> Username already existed...
// </div>";unset($_SESSION['duplicate_username']);
// }

// if(  isset($_SESSION['add_success']) && $_SESSION['add_success'] == 1 )
// {
// echo "<div class='alert alert-success'>
//       <strong>Success!</strong> Add user successfully...
//     </div>";unset($_SESSION['add_success']); 
// }


//Edit status message

if ( isset($_SESSION['edit_success']) && $_SESSION['edit_success'] == 0  )
{
echo "<div class='alert alert-danger'>
      <strong>Alert!</strong> Edited fail...
</div>";unset($_SESSION['edit_success']); 
}

if(  isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == -1 ) 
{
 echo "<div class='alert alert-warning'>
      <strong>Alert!</strong> Password mismatch...
</div>";unset($_SESSION['password_mismatch']); 
}

if(  isset($_SESSION['edit_success']) && $_SESSION['edit_success'] == 1 )
{
echo "<div class='alert alert-success'>
      <strong>Success!</strong> Edited successfully...
    </div>";unset($_SESSION['edit_success']); 
}

//Delete status message
if(  isset($_SESSION['del_success']) && $_SESSION['del_success'] == 1 )
{
echo "<div class='alert alert-success'>
      <strong>Success!</strong> Deleted successfully...
    </div>";unset($_SESSION['del_success']); 
}

?>
  <div class="btn-toolbar" style="margin-bottom:10px"> 
    <button class="btn btn-primary" data-toggle="modal" data-target="#them_user">Thêm User </button> 
    <a href="../../views/Users/ExcelExport/index.php" class="btn btn-warning pull-right" >Export Spreadsheet </a> 
  </div>
<?php
require_once ('add_user_modal.php'); 
unset($_SESSION['error']);
?>
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
          $users_list = $user->getUsersList(); //var_dump($users_list);die;
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
                          $ten_bao_cao = $user->layBaoCao($bao_cao_duoc_xem);
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
                { ?> <a href="action/delete_action.php?xoaUser=<?=$r['TenSD']?>" onclick="return confirm('Are you sure you want to delete?');" role="button" data-toggle="modal"><i class="glyphicon glyphicon-remove-sign" style="color:#F44336; font-size: 1.3em;"></i></a> 
                <?php } ?>
                
            </td>

          </tr>



           <?php $i++; } ?>
        </tbody>
      </table>
  </div> 
<?php
$users_list = $user->getUsersList(); //var_dump($users_list);die;
foreach ( $users_list as $r ) 
  { ?>
                              
<!-- Modal Edit User -->
<?php 
include('edit_user_modal.php');
?>
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

var error = $('div#error');
if(error.length >0){
  $('#them_user').modal('show');
}

  </script>
