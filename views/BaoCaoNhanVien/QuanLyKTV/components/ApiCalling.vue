<template>
  <div class="col-md-12">
    <div class="col-md-12" style="margin: 9px 0;">
        <button class="btn btn-primary" data-toggle="modal" data-target="#add_kvt" >Thêm User </button>
    </div>
    <ktv-modal :group="nhomNV" @update-list="updateList"></ktv-modal>
    <div class="alert alert-danger alert-dismissible" role="alert" v-if="error">
       <b>Alert:</b>
       <ul  v-if="typeof error === []">
           <li v-for="(e, index) in error" :key="index">
               {{ e }}
           </li>
       </ul>
       <p  v-if="typeof error !== []">{{ error }}</p>
       <button type="button" class="close" @click="error = null">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
    <table class="table" id="ktv_list">
      <thead>
        <tr>
          <th>Mã</th>           
          <th>KTV</th>    
          <th>Nhóm</th>
          <th>Thứ tự làm</th>
          <th>Số tour theo lượt</th>
          <th>Số tour yêu cầu</th>                     
          <th>Giờ vào</th>             
          <th>Giờ ra</th>   
          <th>Điểm danh</th>  
          <th scope="col">Actions</th>         
        </tr>
      </thead>
      <tbody>
        <tr v-for="(person, index) in KTVList" :key="person.MaNV">
            <td>{{ person.MaNV }}</td>

            <td v-if="!person.isEdit"> {{ index }} - {{ person.TenNV }}</td>
            <td v-else><input type="text" v-model="person.TenNV" class="form-control" name="TenNV" /></td>

            <td v-if="!person.isEdit"> {{ person.NhomNhanVien }} </td>
            <td v-else>
              <select class="form-control" name="nhomNV"  v-model="person.NhomNhanVien">
                <!--(2) cách 1 --><option v-for="(group, index) in nhomNV" :key="group.Ma" :value="group.Ma">{{ group.Ma }}</option>
              </select>
            </td>

            <td v-if="!person.isEdit"> {{ person.ThuTuDieuTour }}</td>
            <td v-else><input type="text" v-model="person.ThuTuDieuTour" class="form-control" name="ThuTuDieuTour" /></td> 

            <td v-if="!person.isEdit"> {{ person.SoLanPhucVu }}</td>
            <td v-else><input type="text" v-model="person.SoLanPhucVu" class="form-control" name="SoLanPhucVu" /></td>

            <td v-if="!person.isEdit"> {{ person.SoSaoDuocYeuCau }}</td>
            <td v-else><input type="text" v-model="person.SoSaoDuocYeuCau" class="form-control" name="SoSaoDuocYeuCau" />
            </td>

            <td v-if="!person.isEdit"> {{ person.GioBatDau }}</td>
            <td v-else><input type="text" v-model="person.GioBatDau" class="form-control" name="GioBatDau" v-bind:id=" 'GioBatDau_'+  person.MaNV"/>
            </td>

            <td v-if="!person.isEdit"> {{ person.GioKetThuc }}</td>
            <td v-else><input type="text" v-model="person.GioKetThuc" class="form-control" name="GioKetThuc" v-bind:id=" 'GioKetThuc_'+  person.MaNV"/>
            </td>

            <td v-if="person.status === 'raCa'"> 
               <button  v-bind:id="'raCa_' +  person.MaNV" class="btn btn-warning btn-sm" @click="raCa(index, person.MaNV)">Out</button onclick="test()">
            </td>
            <td v-else>
               <button  v-bind:id="'vaoCa_' +  person.MaNV" class="btn btn-success btn-sm" @click="vaoCa(index, person.MaNV)">In</button>
            </td>

            <td v-if="!person.isEdit"> 
              <button type="button" @click="editKTV(person)" class="btn btn-primary btn-sm btn-block"><span class="glyphicon glyphicon-pencil"></span></button> 
              <button type="button" @click="deleteKTV(person, index)" class="btn btn-danger btn-sm btn-block" name="action" value="delete" onclick="return confirm('Are you sure you want to delete?');"><span class="glyphicon glyphicon-remove"></span></button>
            </td>
            <td v-else>
              <button type="button" @click="updateKTV(index)" class="btn btn-primary btn-sm btn-block" name="action" value="update">Update</button>
              <button type="button" @click="person.isEdit = false" class="btn btn-warning btn-sm btn-block">Cancel</button>
            </td>
        </tr>
      </tbody>
    </table> 

  </div>

</template>


<script>

module.exports = {
    data: function() {
        return {
          ktv: {
              id: '',
              name: '',
              group: '',
              thuTuLam: '',
              soTourTheoLuot: '',
              soTourTheoYC: '',
              gioVao:'',
              gioRa:'',
              Action:'',
          },
          KTVList: [],
          selectedKTV: '',
          nhomNV: '',
          error: null,
          clientForm: 'clientForm_',
          form:{
                first_name: 'first_name',
                last_name: 'last_name',
                email: 'email'
            }
        }
    },
    components: {
       'ktv-modal': httpVueLoader('components/add_ktv.vue')
    },
    created() {
      this.getKTVList();
      this.getnhomNV();
    },
    methods: {
      async vaoCa(index, MaNV) {

        try 
          { 
            const response = await axios.get('api/ktv.php?action=vaoCa&id=' + MaNV);
            console.log(response);
            if( response.data ) {
              this.error = 'Sth Wrong...';
              return;
             
            }
             this.KTVList[index].status = 'raCa';
          }
          catch (error)
          {
              this.error = error.response;
          }


      },
      async raCa(index, MaNV) { 
        try 
          {
            const response = await axios.get('api/ktv.php?action=raCa&id=' + MaNV);
            console.log(response);
            if( response.data ) {
              this.error = 'Sth Wrong...';
              return;
             
            }
            this.KTVList[index].status = 'vaoCa';

          }
          catch (error)
          {
              this.error = error.response;
          }    

      },
      
      async  getKTVList(){
          try 
          {
            const response = await axios.get('api/ktv.php?action=getAllKTV');

            this.KTVList = response.data;
            setTimeout(function(){initDatatable() ;}, 0);//(1)
            
            this.KTVList.forEach(person => {
              Vue.set(person, 'isEdit', false);
              person.ThuTuDieuTour > 0  ? Vue.set(person, 'status', 'raCa') : Vue.set(person, 'status', 'vaoCa');
            }); 

            // console.log( this.KTVList );

          }
          catch (error)
          {
              this.error = error.response;
          }            
      },
      editKTV(person) 
      {
        if( typeof this.selectedKTV === 'object' && this.selectedKTV !== null )
        {
          this.selectedKTV.isEdit = false;  
          this.selectedKTV = person; 
          this.selectedKTV.isEdit = true; 
        }
        else
        {
          this.selectedKTV = person;
          this.selectedKTV.isEdit = true;
        }
        
        setTimeout(function(){
          $('#GioBatDau_' + person.MaNV).datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            widgetPositioning: {
              horizontal: 'right',
              vertical: 'auto',
            },
            //useCurrent: true,
            // daysOfWeekDisabled: [0,6],//disable Sat and Sun
            // minDate: new Date(),
            // showClear: true,
            // keepOpen: true,
            // inline: true,
            // debug: true,
          });

          $('#GioKetThuc_' + person.MaNV).datetimepicker({
              format: 'YYYY-MM-DD HH:mm:ss',
              widgetPositioning: {
                horizontal: 'right',
                vertical: 'auto',
              },

          });
        })
        

      },
      async getnhomNV(){
        try 
          {
            const response = await axios.get('api/ktv.php?action=getnhomNV');

            this.nhomNV = response.data;
           
          }
          catch (error)
          {
              this.error = error.response;
          }      
      },
      updateList(ktvObj)
      {
        this.KTVList.unshift(ktvObj);
        console.log(this.KTVList);
      },
      async updateKTV(index)
      {
        let bodyFormData = new FormData();  

        bodyFormData.append('action', 'update');
        bodyFormData.append('MaNV', this.selectedKTV.MaNV);
        bodyFormData.append('TenNV', this.selectedKTV.TenNV);
        bodyFormData.append('NhomNhanVien', this.selectedKTV.NhomNhanVien);
        bodyFormData.append('ThuTuDieuTour', this.selectedKTV.ThuTuDieuTour);
        bodyFormData.append('SoLanPhucVu', this.selectedKTV.SoLanPhucVu);
        bodyFormData.append('SoSaoDuocYeuCau', this.selectedKTV.SoSaoDuocYeuCau);
        bodyFormData.append('GioBatDau', $('#GioBatDau_' + this.selectedKTV.MaNV).val() );
        bodyFormData.append('GioKetThuc', $('#GioKetThuc_' + this.selectedKTV.MaNV).val() );

        //console.log( this.KTVList[index].NhomNhanVien );
        this.KTVList[index].GioBatDau =  $('#GioBatDau_' + this.selectedKTV.MaNV).val();
        this.KTVList[index].GioKetThuc =  $('#GioKetThuc_' + this.selectedKTV.MaNV).val();
        let config = {
            header : {
             'Content-Type' : 'multipart/form-data'
             //'content-type': 'application/x-www-form-urlencoded'
            }
        }
        
        const response = await axios.post('api/ktv.php', bodyFormData, config);

        if( response.data )
        {//cái này để show lỗi chính xác, như duplicate username, password mismatch,...
          if( response.data.success === false )
          {  Vue.$toast.open({
                message: response.data.msg,
                type: 'error',
                // all of other options may go here
            });
          }
          else
          {//cái này để show lỗi chung chung như php error notice, warning or fatal error.
            Vue.$toast.open({
                message: 'Sth Wrong...',
                type: 'error',
                // all of other options may go here
            });
          }
          return;
        }

        this.KTVList[index].isEdit = false;

        let table =  $('#ktv_list').DataTable();
        setTimeout(function(){
          table.destroy();
          initDatatable();
        }, 0);
        

      },
      async deleteKTV(person, index){
        try
        { 
           Vue.$toast.open({
                message: 'item removed successfully',
                type: 'error',
                // all of other options may go here
            });
          let table =  $('#ktv_list').DataTable();
              table.destroy();//(3)

          let bodyFormData = new FormData();  

          bodyFormData.append('action', 'delete');
          bodyFormData.append('MaNV', person.MaNV);

          let config = {
              header : {
               'Content-Type' : 'multipart/form-data'
               //'content-type': 'application/x-www-form-urlencoded'
              }
          }
           const response = await axios.post('api/ktv.php', bodyFormData, config);
           this.KTVList.splice(index, 1);
      

            this.$nextTick(() => {
               initDatatable();
            });//(3)

           
        }
        catch (error) {
          //console.log(error);
          this.error = error.response.data;
        }
      }


        }
}


</script>
<!-- 
Note:
(1): phải cho initDatatable() vào setTimeout() vì setTimeout so với Promise thì nó chạy sau Promise. Nếu ko thì initDatatable() sẽ chạy trước khi data đc đưa vào DOM và lúc đó <table> sẽ ko có đc format theo dataTAble
(2): preselect value with select option: https://stackoverflow.com/a/48408319/11297747 (using v-model make the value directly bind to the option value.)
cách 2 : <option v-for="(group, index) in nhomNV" :key="group.Ma" :value="group.Ma" :selected="group.Ma == person.NhomNhanVien ? 'selected' : ''">{{ group.Ma }}</option>
ref: https://stackoverflow.com/a/43367234/11297747  
(3): this is on how to update datatable after axios delete or post method
- destroy the current table 
- perform the axios delete
- put the $("#table").DataTable({}) within this.$nextTick() to make the table display the updated DOM. 
(ref: https://stackoverflow.com/a/57352409/11297747)
OR : cách 2 : init DataTable widget wihtin document.ready()
$(function() {
     $("#table").DataTable({});
  });
(Ref: https://stackoverflow.com/a/59919419/11297747)
More:
- why we cannot access data value in axios.then: 
Answer: the way you declare your axios .then and .catch functions creates a new scope for this
https://stackoverflow.com/a/57807039/11297747
https://stackoverflow.com/questions/40996344/axios-cant-set-data
-->

