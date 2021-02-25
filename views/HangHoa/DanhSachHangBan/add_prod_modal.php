<style>
.removeIcon{
  margin-top: 9px;
}
</style>

  <div class="modal fade addNewProd" id="addNewProd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span>
                </a>
                <div class="row">
                  <h3 class="modal-title col-md-8">Thông Tin  Hàng Bán</h3><?php //var_dump($_SESSION['error']); ?>
                  <div class="col-md-2 col-md-offset-1 removeIcon">
                    <button type="button" class="btn btn-sm btn-warning clearAll"> <span class="glyphicon glyphicon-trash"></span></button>
                  </div>
                </div>
            </div>
            <div class="modal-body">
              
                <form class="form-horizontal" id="addForm" role="form" action="action/add_action.php" method="post">


                  <div class="form-group">
                      <label for="prod_id" class="col-md-3 control-label">Mã:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="prod_id" id="prod_id" value="<?php echo isset($_SESSION['prod_id']) ? $_SESSION['prod_id'] : ""; unset($_SESSION['prod_id']); ?>" >
                        <?=isset($_SESSION['error']['empty_prodID']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['empty_prodID'] . '</small>' : "" ?>
                        <?=isset($_SESSION['error']['duplicate_ProdID']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['duplicate_ProdID'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove clearField"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="prod_name" class="col-md-3 control-label">Tên Hàng Bán:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="prod_name" id="prod_name" value="<?php echo isset($_SESSION['prod_name']) ? $_SESSION['prod_name'] : ""; unset($_SESSION['prod_name']); ?>" >
                        <?=isset($_SESSION['error']['empty_ProdName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['empty_ProdName'] . '</small>' : "" ?>
                        <?=isset($_SESSION['error']['duplicate_ProdName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['duplicate_ProdName'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="prod_price" class="col-md-3 control-label">Giá Hàng Bán:</label>
                      <div class="col-md-4 input-group priceTag">
                        <span class="input-group-addon">VND</span>
                        <input type="text" class="form-control" name="prod_price" id="prod_price" value="<?php echo isset($_SESSION['prod_price']) ? $_SESSION['prod_price'] : ""; unset($_SESSION['prod_price']); ?>" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  onkeyup="formatAmount(this)">
                        <?=isset($_SESSION['error']['empty_ProdPrice']) ? '<small class="field-msg error"  >'.  $_SESSION['error']['empty_ProdPrice'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Nhóm Hàng Bán:</label>
                        <div class="col-md-8">
                          <select name="cat_id" id="cat_id" class="form-control"  >
                              <option value="" disabled selected="selected" class="default"> Select... </option>
                              <?php
                              $rs = $product->getAllProductCats();
                              foreach ( $rs as $r ) 
                              {
                                if( isset( $_SESSION['cat_id'] ) && $_SESSION['cat_id'] == $r['Ma'] )
                                {
                                    echo '<option value="' . $r["Ma"] . '" selected="selected">' . $r['Ten'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $r["Ma"] . '">' . $r['Ten'] . '</option>';
                                }

                               
                              } unset($_SESSION['cat_id']); 
                              ?>

                            </select>
                            <?=isset($_SESSION['error']['empty_CatID']) ? '<small class="field-msg error"  >'.  $_SESSION['error']['empty_CatID'] . '</small>' : "" ?>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Mã ĐVT:</label>
                        <div class="col-md-8">
                          <select name="donViTinh" id="donViTinh" class="form-control"  >
                              <option value="" disabled selected="selected" class="default"> Select... </option>
                              <?php
                              $rs = $product->getDonViTinh();
                              foreach ( $rs as $r ) 
                              {
                                if( isset( $_SESSION['donViTinh'] ) && $_SESSION['donViTinh'] == $r['MaDVTCoBan'] )
                                {
                                    echo '<option value="' . $r["MaDVTCoBan"] . '" selected="selected">' . $r['MaDVTCoBan'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $r["MaDVTCoBan"] . '">' . $r['MaDVTCoBan'] . '</option>';
                                }

                               
                              } unset($_SESSION['donViTinh']); 
                              ?>

                            </select>
                            <?=isset($_SESSION['error']['donViTinh']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['donViTinh'] . '</small>' : "" ?>
                        </div>
                  </div>
                  

                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit" name="add_prod" value="submit">
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
  });

  $('.clearAll').click( function(){
      $('form#addForm input').each( function() {
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