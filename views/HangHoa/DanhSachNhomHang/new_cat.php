  <div class="modal fade new_cat" id="new_cat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Thông Tin Nhóm Hàng Bán</h3>
            </div>
            <div class="modal-body">
              
                <form class="form-horizontal" role="form" action="" method="post">
                  <div class="form-group">
                      <label for="cat_id" class="col-md-3 control-label">Mã:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="cat_id" id="cat_id" value="<?php echo isset($_SESSION['cat_id']) ? $_SESSION['cat_id'] : ""; unset($_SESSION['cat_id']); ?>" required>
                        </div>
                  </div>

                  <div class="form-group">
                      <label for="cat_name" class="col-md-3 control-label">Tên:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="cat_name" id="cat_name" value="<?php echo isset($_SESSION['cat_name']) ? $_SESSION['cat_name'] : ""; unset($_SESSION['cat_name']); ?>" required>
                        </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-3 col-md-offset-3">
                      <button class="btn btn-primary signup-btn" type="submit" name="cat_add_new">
                       Submit</button>
                    </div>
                  </div>

                </form>
                    
            </div>
        </div>
    </div>
  </div>