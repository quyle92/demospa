<style>
.control-label {
  text-align: left!important;
}
</style>
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

    <form action="process" method="POST" class="form-horizontal col-sm-offset-4" role="form">
        <div class="form-group">
          <legend >Change Password</legend>

        </div>

        <div class="form-group form-inline">
          <label for="password" class="col-sm-2 control-label">Password:</label>
          <div class="col-sm-5 input-group">
            <input type="password" class="form-control" name="password" id="password">
            <span class="input-group-btn">
              <button class="btn btn-default reveal" type="button"><i class="glyphicon glyphicon-eye-open"></i></button>
            </span>
          </div>
        </div>

        <div class="form-group form-inline">
          <label for="confirm_password" class="col-sm-2"> Password Again:</label>
          <div class="col-sm-5 input-group">
            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
            <span class="input-group-btn">
              <button class="btn btn-default reveal" type="button"><i class="glyphicon glyphicon-eye-open"></i></button>
            </span>
          </div>
        </div>
        
    
        <div class="form-group">
          <div class="col-sm-10 ">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
    </form>

<script type="text/javascript">

  $('.reveal').mousedown(function(){
    $(this).parent().parent().find('input').attr('type', 'text');
  }).mouseup(function(){
    $(this).parent().parent().find('input').attr('type', 'password');
  });

</script>