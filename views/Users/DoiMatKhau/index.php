<?php //var_dump($_SESSION['change_success']);
 if(  isset($_SESSION['change_success']) && $_SESSION['change_success'] == 1 )
    {
    echo "<div class='alert alert-success'>
          <strong>Success!</strong> Password Change Successfully...
        </div>";unset($_SESSION['change_success']); 
    }

    elseif ( isset($_SESSION['change_success']) && $_SESSION['change_success'] == 0  )
    {
    echo "<div class='alert alert-danger'>
          <strong>Alert!</strong> Password Change failed...
    </div>";unset($_SESSION['change_success']); 
    }

    elseif(  isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == -1 ) 
    {
     echo "<div class='alert alert-warning'>
          <strong>Alert!</strong> Password mismatch...
    </div>";unset($_SESSION['password_mismatch']); 
    }
?>
<div class="table-responsive">
    <form action="process" method="post">
      <table class="table">
         	<input type="hidden" size="35" name='username' value='<?=$_SESSION['TenSD']?>'>
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Mật khẩu mới:</th>
            <td> <input name="password" type="password" size="35" ></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Nhập lại mật khẩu:</th>
            <td> <input name="confirm_password" type="password" size="35" ></td>
            <td class="error"></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="submit" value="Xác nhận"></td>          
            <td></td>
            <td></td>
          </tr>
    
      </table>
    </form>
</div><!-- /.table-responsive -->