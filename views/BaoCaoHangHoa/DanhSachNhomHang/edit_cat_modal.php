<style>
.removeIcon{
  margin-top: 9px;
}
</style>

  <div class="modal fade editCat" id="editCat_<?=$r['Ma']?>">
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
              
                <form accept-charset="UTF-8" class="form-horizontal" id="editForm_<?=$r['Ma']?>" role="form" action="action/edit_action.php" method="post">

                  <input type="hidden" name="cat_id" id="cat_id" value="<?=$r['Ma']?>" />

                  <div class="form-group">
                      <label for="cat_name" class="col-md-3 control-label">Tên:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?=( empty($_SESSION['cat_name']) )  ? $r['Ten']  : ( (  !empty($_SESSION['cat_id_edit']) && !empty($_SESSION['cat_name']) ) ? $_SESSION['cat_name'] : '' ); unset($_SESSION['cat_name']); ?>" >
                        <?=( isset($_SESSION['cat_id_edit']) && $_SESSION['cat_id_edit'] !== $r['Ma'] ) ? '' : ( isset($_SESSION['fail']['empty_catName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['fail']['empty_catName'] . '</small>' : "" )?>
                        <?=( isset($_SESSION['cat_id_edit']) && $_SESSION['cat_id_edit'] !== $r['Ma'] ) ? '' : ( isset($_SESSION['fail']['duplicate_CatName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['fail']['duplicate_CatName'] . '</small>' : "" )?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit" name="edit_cat" value="submit">
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

var catID = '<?=$r["Ma"]?>';
  $('#editCat_<?=$r['Ma']?>').on('click','.clearAll', function(){console.log($('form#editForm_<?=$r["Ma"]?>'));
      $('form#editForm_<?=$r["Ma"]?> input').each( function() {
        $(this).val('');
      });
  });
</script>