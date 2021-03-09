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

  <div class="modal fade addNewClient" id="addNewClient">
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
              
                <form class="form-horizontal" id="addForm" role="form" action="action/add_action.php" method="post">

                  <div class="form-group">
                      <label for="client_name" class="col-md-3 control-label">Tên:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="client_name" id="client_name" value="<?php echo isset($_SESSION['client_name']) ? $_SESSION['client_name'] : ""; unset($_SESSION['client_name']); ?>" style="text-transform: uppercase">
                        <?=isset($_SESSION['error']['empty_ProdName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['empty_ProdName'] . '</small>' : "" ?>
                        <?=isset($_SESSION['error']['duplicate_ProdName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['duplicate_ProdName'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="client_tel" class="col-md-3 control-label">SĐT:</label>
                      <div class="col-md-4 input-group telNumber">    
                        <span class="input-group-addon">+84</span>                    
                        <input type="text" class="form-control " name="client_tel" id="client_tel" value="<?php echo isset($_SESSION['client_tel']) ? $_SESSION['client_tel'] : ""; unset($_SESSION['client_tel']); ?>" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  onfocusout="is_phonenumber(this)" onkeyup="formatTel(this)" oninput="if (this.value.length > this.maxLength) this.value = this.value.slice( this.maxLength, this.value - 1 );" maxlength="11"/>
                        
                        <?=isset($_SESSION['error']['empty_ProdPrice']) ? '<small class="field-msg error"  >'.  $_SESSION['error']['empty_ProdPrice'] . '</small>' : "" ?>
                      </div>
                        <small class="field-msg error hiddenError"  data-error="invalidEmail">* Invalid phone number!</small>
                      <div class="col-md-3 control-label">
                        <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="client_address" class="col-md-3 control-label">Địa chỉ:</label>
                      <div class="col-md-6">
                        
                        <textarea class="form-control" id="client_address" name="client_address" rows="2"></textarea>
                        <?=isset($_SESSION['error']['empty_ProdPrice']) ? '<small class="field-msg error"  >'.  $_SESSION['error']['empty_ProdPrice'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Nhóm:</label>
                        <div class="col-md-4">
                          <select name="client_group" id="client_group" class="form-control"  >
                              <option value="" disabled selected="selected" class="default"> Select... </option>
                              <?php
                              $rs = $client->getMaNhomKH();
                              foreach ($rs as $r )
                              { ?>
                                <option value="<?=$r['Ma']?>"  class="default"> <?=$r['Ten']?></option>
                              <?php
                              }
                              ?>
                            </select>
                            <?=isset($_SESSION['error']['empty_CatID']) ? '<small class="field-msg error"  >'.  $_SESSION['error']['empty_CatID'] . '</small>' : "" ?>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="prod_price" class="col-md-3 control-label">Ghi chú:</label>
                      <div class="col-md-6 ">
                        <textarea class="form-control" id="client_notes" name="client_notes" rows="6"></textarea>
                      </div>
                      <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit" name="add_client" value="submit">
                       Submit</button>
                    </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>

<script type="text/javascript">
  $('.clearField').click(function(){
      $(this).parent().parent().find('input').val('');
       $(this).parent().parent().find('textarea').val('');
  });

  $('.clearAll').click( function(){
      $('form#addForm input').each( function() {
        $(this).val('');
      });

      $('form#addForm textarea').each( function() {
        $(this).val('');
      });

      $('select#cat_id option').each(function(){
          if($(this).is(':selected'))
          {
            $(this).prop('selected',false);
          }
      });//(1)
      $('select#cat_id option[class="default"]').prop('selected', true);

      $("select#donViTinh option:selected").prop("selected", false);//(2)
      $('select#donViTinh option[class="default"]').prop('selected', true);

      // $('select#donViTinh option').prop('selected', function(){
      //   return this.defaultSelected;
      // });
  });



</script>
<?php
/**
 * Note
 */
//(1): unselect the option (cách 1)
//(2): unselect the option (cách 2)