  <div class="modal fade edit_user" id="edit_user_<?=$r['TenSD']?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Edit User</h3>
            </div>
            <div class="modal-body" style="display: block;overflow: auto;">

                <form class="form-horizontal" role="form" action="action/edit_action.php" method="post">
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
                              $list_NV_arr =  $user->getUsersList();
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
                          $danh_sach_bao_cao =  $user->layTatCaBaoCao();
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
                      <button class="btn btn-primary signup-btn" type="submit" name="edit_user" value="submit">
                       Submit</button>
                    </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>  