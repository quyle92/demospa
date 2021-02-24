<style>
.removeIcon{
  margin-top: 9px;
}
</style>

  <div class="modal fade" id="editProd_<?=( $r['MaHangBan'] =='!KM' ) ? 'khuyenMai' : ( ($r['MaHangBan'] =='!lt') ? 'dichVuKhac' :  $r['MaHangBan'] )?>">
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
              
                <form class="form-horizontal editForm"  role="form" action="action/edit_action.php" method="post">

                  <input type="hidden" class="form-control" name="prod_id"  value="<?=$r['MaHangBan']?>" />


                  <div class="form-group">
                      <label for="prod_name_edit" class="col-md-3 control-label">Tên Hàng Bán:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="prod_name"  value="<?php echo isset($_SESSION['prod_name_edit']) ? $_SESSION['prod_name_edit'] : $r['TenHangBan']; unset($_SESSION['prod_name_edit']); ?>" />
                        <?=( isset($_SESSION['prod_id_edit']) && $_SESSION['prod_id_edit'] !== $r['MaHangBan'] ) ? '' : ( (isset($_SESSION['fail']['empty_ProdName'])) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['fail']['empty_ProdName'] . '</small>' : "" )?>
                        <?=isset($_SESSION['fail']['duplicate_ProdName']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['fail']['duplicate_ProdName'] . '</small>' : "" ?>
                        </div>
                        <div class="col-md-3 control-label">
                          <button type="button" class="btn btn-xs btn-warning pull-left clearField"> <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Nhóm Hàng Bán:</label>
                        <div class="col-md-8">
                          <select name="cat_id"  class="form-control cat_id"  >
                              <option disabled class="default"> Select... </option>
                              <?php 
                              $productCats = $product->getAllProductCats();
                              foreach ( $productCats as $cat ) 
                              {
                                if( isset( $_SESSION['cat_id_edit'] ) && $_SESSION['cat_id_edit'] == $cat['Ma'] )
                                {
                                    echo '<option value="' . $cat["Ma"] . '" selected="selected">' . $cat['Ten'] . '</option>';
                                }
                                elseif(  $r['MaNhomHangBan'] == $cat['Ma'] )
                                {
                                    echo '<option value="' . $cat["Ma"] . '" selected="selected">' . $r['Ten'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $cat["Ma"] . '">' . $cat['Ten'] . '</option>';
                                }

                               
                              } unset($_SESSION['cat_id_edit']); 
                              ?>

                            </select>
                            <?=( isset($_SESSION['prod_id_edit']) && $_SESSION['prod_id_edit'] !== $r['MaHangBan']) ? '' : ( isset($_SESSION['fail']['empty_CatID']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['fail']['empty_CatID'] . '</small>' : "" )?>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Mã ĐVT:</label>
                        <div class="col-md-8">
                          <select name="donViTinh" class="form-control donViTinh"  >
                              <option value="" disabled selected="selected" class="default"> Select... </option>
                              <?php
                              $donViTinh = $product->getDonViTinh();
                              foreach ( $donViTinh as $unit ) 
                              {
                                if( isset( $_SESSION['donViTinh_edit'] ) && $_SESSION['donViTinh_edit'] == $unit['MaDVTCoBan'] )
                                {
                                    echo '<option value="' . $r["MaDVTCoBan"] . '" selected="selected">' . $r['MaDVTCoBan'] . '</option>';
                                }
                                elseif(  $r['MaDVTCoBan'] == $unit['MaDVTCoBan'] )
                                {
                                    echo '<option value="' . $r["MaDVTCoBan"] . '" selected="selected">' . $r['MaDVTCoBan'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $unit["MaDVTCoBan"] . '">' . $unit['MaDVTCoBan'] . '</option>';
                                }

                               
                              } unset($_SESSION['donViTinh_edit']); 
                              ?>

                            </select>
                            <?=( isset($_SESSION['prod_id_edit']) && $_SESSION['prod_id_edit'] !== $r['MaHangBan']) ? '' : ( isset($_SESSION['fail']['donViTinh']) ? '<small class="field-msg error" data-error="invalidName" >'.  $_SESSION['fail']['donViTinh'] . '</small>' : "" )?>
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

  $('#editProd_<?=( $r['MaHangBan'] =='!KM' ) ? 'khuyenMai' : ( ($r['MaHangBan'] =='!lt') ? 'dichVuKhac' :  $r['MaHangBan'] )?>').on('click','.clearAll', function(){
    let modal = $(this).parentsUntil('#editProd_<?=( $r['MaHangBan'] =='!KM' ) ? 'khuyenMai' : ( ($r['MaHangBan'] =='!lt') ? 'dichVuKhac' :  $r['MaHangBan'] )?>');

      $(modal).find('form.editForm input[name="prod_name_edit"]').val('');

      $(modal).find('select.cat_id option').each(function(){
          if($(this).is(':selected'))
          {
            $(this).prop('selected',false);
          }
      });
      $(modal).find('select.cat_id option[class="default"]').prop('selected', true);

      $(modal).find("select.donViTinh option:selected").prop("selected", false);
      $(modal).find('select.donViTinh option[class="default"]').prop('selected', true);

  });
</script>
