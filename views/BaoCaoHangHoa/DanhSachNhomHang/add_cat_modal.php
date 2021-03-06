<style>
.removeIcon{
  margin-top: 9px;
}
</style>

  <div class="modal fade addNewCat" id="addNewCat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span>
                </a>
                <div class="row">
                  <h3 class="modal-title col-md-8">Thông Tin Nhóm Hàng Bán</h3>
                  <div class="col-md-2 col-md-offset-1 removeIcon">
                    <button type="button" class="btn btn-sm btn-warning clearAll"> <span class="glyphicon glyphicon-trash"></span></button>
                  </div>
                </div>
            </div>
            <div class="modal-body">
              
                <form class="form-horizontal" id="addForm" role="form" action="action/add_action.php" method="post">


                  <div class="form-group">
                      <label for="cat_id" class="col-md-3 control-label">Mã:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="cat_id" id="cat_id" value="<?php echo isset($_SESSION['cat_id']) ? $_SESSION['cat_id'] : ""; unset($_SESSION['cat_id']); ?>" >
                        <?=isset($_SESSION['error']['empty_catID']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['empty_catID'] . '</small>' : "" ?>
                        <?=isset($_SESSION['error']['duplicate_CatID']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['duplicate_CatID'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove clearField"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="cat_name" class="col-md-3 control-label">Tên:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?php echo isset($_SESSION['cat_name']) ? $_SESSION['cat_name'] : ""; unset($_SESSION['cat_name']); ?>" >
                        <?=isset($_SESSION['error']['empty_catName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['empty_catName'] . '</small>' : "" ?>
                        <?=isset($_SESSION['error']['duplicate_CatName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['error']['duplicate_CatName'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit" name="add_cat" value="submit">
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
  });
</script>