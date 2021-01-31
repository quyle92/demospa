  <div class="modal fade them_user" id="them_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Thông Tin User</h3>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" action="" method="post">
                  <div class="form-group">
                      <label for="username" class="col-md-3 control-label">ID:</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ""; unset($_SESSION['username']); ?>" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="password" class="col-md-3 control-label">Password:</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="password" id="password" required>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="confirm_password" class="col-md-3 control-label">Confirm Password:</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="confirm_password" id="confirm_password" required >
                          <span id='message'></span>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="staff_card" class="col-md-3 control-label">Tên NV:</label>
                        <div class="col-md-8">
                          <select name="maNV" id="maNV" class="form-control input-lg" required="required" >
                              <option value="" disabled selected> Tên NV</option>
                              <?php
                              $list_NV_arr = $user->getUsersList();
                              $maNV = $_SESSION['maNV'];//if(isset( $maNV  ) ) echo "yes";
                              foreach ( $list_NV_arr as $r ) 
                              {
                                if( isset( $maNV  ) && $maNV == $r['MaNV'] )
                                {
                                    echo '<option value="' . $r["MaNV"] . '" selected="selected">' . $r['TenNV'] . '</option>';
                                }
                                else
                                {
                                    echo '<option value="' . $r["MaNV"] . '">' . $r['TenNV'] . '</option>';
                                }

                               
                              } unset($_SESSION['maNV']); 
                              ?>

                            </select>
                        </div>
                  </div>

                   <div class="form-group">
                      <label for="reports" class="col-md-3 control-label">Báo Cáo:</label>
                      <div class="col-md-9">
                        <div class="row"></div>
                        <?php
                        $danh_sach_bao_cao = $user->layTatCaBaoCao();
                        $bao_cao_duoc_xem_arr = isset($_SESSION['report_arr']) ? $_SESSION['report_arr'] : array();
                        
                        foreach ( $danh_sach_bao_cao as $r ) {
                          if (  in_array( $r['MaBaoCao'], $bao_cao_duoc_xem_arr ) )
                          {
                              echo '
                                <input type="checkbox" checked data-toggle="toggle" name="report_arr[]" value="' . $r['MaBaoCao'] . '" >
                                 <span style="vertical-align:11px">' . $r['TenBaoCao']  . '</span>
                                 <br>
                            ';
                          }
                          else
                          {
                              echo '
                                <input type="checkbox"  data-toggle="toggle" name="report_arr[]" value="' . $r['MaBaoCao'] . '" >
                                 <span style="vertical-align:11px">' . $r['TenBaoCao']  . '</span>
                                 <br>
                            ';
                          }
                        }  unset($_SESSION['report_arr']); ?>
                        </div>
                    </div>


                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit" name="add_user">
                       Submit</button>
                    </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>