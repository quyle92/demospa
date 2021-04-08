<template>
  <div>
      <div class="modal fade add_kvt" id="add_kvt">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                    <h3 class="modal-title">Thông Tin User</h3>
                    <button type="button" class="btn btn-warning" @click.prevent='reset()'>Reset</button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success" v-if="message.success !== '' && message.success !== undefined">{{message.success}}</div>
                    <form class="form-horizontal">
                      <div class="form-group">
                          <label for="maNV" class="col-md-3 control-label">Mã NV:</label>
                          <div class="col-md-8">
                            <input type="text" v-model="nhanVien.maNV" class="form-control" name="maNV" id="maNV" required >
                            <small class="field-msg error" >{{message.empty_maNV}}</small>
                            <small class="field-msg error" >{{message.duplicate_maNV}}</small>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="tenNV" class="col-md-3 control-label">Tên NV:</label>
                          <div class="col-md-8">
                            <input type="text" v-model="nhanVien.tenNV" class="form-control" name="tenNV" id="tenNV" required >
                            <small class="field-msg error" >{{message.empty_tenNV}}</small>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="staff_card" class="col-md-3 control-label">Nhóm NV:</label>
                            <div class="col-md-8">
                              <select name="nhomNV" v-model="nhanVien.nhomNV" id="nhomNV" class="form-control" required >
                                  <option disabled selected class="default">Chọn...</option>
                                  <option v-for="(item, index) in group" :key="item.Ma" :value="item.Ma">{{ item.Ma }}</option>
                              </select>
                               <small class="field-msg error" >{{message.empty_nhomNhanVien}}</small>
                            </div>
                           
                      </div>

                       <div class="form-group">
                          <label for="staff_card" class="col-md-3 control-label">Giới tính:</label>
                            <div class="col-md-8">
                              <select v-model="nhanVien.gioiTinh" name="gioiTinh" id="gioiTinh" class="form-control" required >
                                  <option disabled selected class="default">Chọn...</option>
                                  <option value="1">Nam</option>
                                  <option value="0">Nữ</option>
                              </select>
                               <small class="field-msg error" >{{message.empty_gioiTinh}}</small>
                            </div>
                      </div>
                 
                      <div class="form-group">
                        <div class="col-md-3 col-md-offset-3">
                          <button class="btn btn-primary signup-btn" @click.prevent="addKVT()">
                           Submit</button>
                        </div>
                      </div>

                    </form>
                        
                </div>
            </div>
        </div>
      </div>
   
  </div>
</template>

<script>
module.exports ={
  props:{
    group:'',

  },
  data: function() {
     return {
       nhanVien: {
        maNV: '',
        tenNV: '',
        nhomNV: '',
        gioiTinh: ''
      },
      message: {
        empty_maNV: '',
        duplicate_maNV: '',
        empty_tenNV: '',
        empty_nhomNhanVien: '',
        empty_gioiTinh: '',
        success:''
      }        
     }
  },
  methods: {
      async addKVT() {
        try 
          { 
            //display notification
            Vue.$toast.open({
                message: 'New item added successfully!',
                type: 'success',
                // all of other options may go here
            });

            //destroy current dataTable structure for later re-init
            let table =  $('#ktv_list').DataTable();
              table.destroy();

            //pass data to parent for pushing new nhanVien obj to KTVList
            let ktvObj = {
              MaNV: this.nhanVien.maNV,
              TenNV: this.nhanVien.tenNV,
              NhomNhanVien: this.nhanVien.nhomNV
            }
            this.$emit('update-list', ktvObj)

            // submit data to server
            let bodyFormData = new FormData();  

            bodyFormData.append('action', 'addKVT');
            bodyFormData.append('maNV', this.nhanVien.maNV);
            bodyFormData.append('tenNV', this.nhanVien.tenNV);
            bodyFormData.append('nhomNV', this.nhanVien.nhomNV);
            bodyFormData.append('gioiTinh', this.nhanVien.gioiTinh);

            let config = {
              header : {
               'Content-Type' : 'multipart/form-data'
               //'content-type': 'application/x-www-form-urlencoded'
              }
            }
            const response = await axios.post('api/ktv.php', bodyFormData, config);

            //get response msg from server  
            if( response.data ) {

               switch(true) {
                
                  case (response.data.empty_maNV !== ''):
                    this.message.empty_maNV = response.data.empty_maNV;
                    
                  case (response.data.duplicate_maNV):
                    this.message.duplicate_maNV = response.data.duplicate_maNV;
                   
                  case (response.data.empty_tenNV):
                    this.message.empty_tenNV = response.data.empty_tenNV;
                   
                  case (response.data.empty_nhomNhanVien):
                    this.message.empty_nhomNhanVien = response.data.empty_nhomNhanVien;
                   
                  case (response.data.empty_gioiTinh):
                    this.message.empty_gioiTinh = response.data.empty_gioiTinh;
                    //break;
                  case (response.data.success):
                    this.message.success = response.data.success;
                }

              // re-init dataTable
             this.$nextTick(() => {
               initDatatable();
              });
            


            }
            
          }
          catch (error)
          {
              this.error = error.response;
          }

      },
      reset(){
          $('#add_kvt input').each( function() {
            $(this).val('');
          });
          $('#add_kvt select option').each(function(){
              if($(this).is(':selected'))
              {
                $(this).prop('selected',false);
              }
              if($(this).hasClass('default'))
              {
                 $(this).prop('selected',true);
              }
          });
          console.log(this.nhanVien.maNV);
          for ( item in this.nhanVien ) {
            delete this.nhanVien[item];
          }
          console.log(this.nhanVien.maNV);
      }
  }



 //end of module.exports 
}
</script>

<style scoped>

</style>
