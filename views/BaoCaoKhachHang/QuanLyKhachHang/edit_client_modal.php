<style>
.removeIcon{
  margin-top: 9px;
}

small.field-msg.error{
  color:red;
  
}

.hiddenError {
  display: none;
}

.telNumber.input-group{
  float: left;
  margin-left: 14px;
} 
</style>

  <div class="modal fade" id="editClient_<?=$r->MaDoiTuong?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span>
                </a>
                <div class="row">
                  <h3 class="modal-title col-md-8">Thông Tin  Khách Hàng</h3><?php //var_dump($_SESSION['error']); ?>
                  <div class="col-md-2 col-md-offset-1 removeIcon">
                    <button type="button" class="btn btn-sm btn-warning clearAll"> <span class="glyphicon glyphicon-trash"></span></button>
                  </div>
                </div>
            </div>
            <div class="modal-body">
              
                <form class="form-horizontal" id="editForm" role="form" action="action/add_action.php" method="post">

                  <div class="form-group">
                      <label for="client_name" class="col-md-3 control-label">Tên:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="client_name" id="client_name" value="<?php echo isset($_SESSION['client_name']) ? $_SESSION['client_name'] : "";  ?>" style="text-transform: uppercase">
                        <?=isset($_SESSION['error']['empty_clientName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['empty_clientName'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>

<script type="text/javascript">




</script>
<?php
/**
 * Note
 */
//(1): unselect the option (cách 1)
//(2): unselect the option (cách 2)