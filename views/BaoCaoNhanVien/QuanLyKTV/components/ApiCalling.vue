<template>
  <div class="col-md-12">
    <table class="table" id="ktv_list">
      <thead>
        <tr>
          <th>Mã</th>           
          <th>KTV</th>    
          <th>Nhóm</th>
<!--           <th>Thứ tự làm</th>
          <th>Số tour theo lượt</th>
          <th>Số tour yêu cầu</th>          
          <th>Giờ vào</th>             
          <th>Giờ ra</th>              
          <th>Action</th>  -->   
          <th scope="col">Actions</th>         
        </tr>
      </thead>
      <tbody>
        <tr v-for="(person, index) in KTVList" :key="person.MaNV">
            <td>{{ person.MaNV }}</td>
            <td v-if="!person.isEdit"> {{ person.TenNV }}</td>
            <td v-else><input type="text" v-model="person.TenNV" class="form-control" name="TenNV" /></td>

            <td v-if="!person.isEdit"> {{ person.NhomNhanVien }} </td>
            <td v-else>
              <select class="form-control" name="nhomNV"  v-model="person.NhomNhanVien">
                <!--cách 1 (2)--><option v-for="(group, index) in nhomNV" :key="group.Ma" :value="group.Ma">{{ group.Ma }}</option>
                <!--cách 2 (3): <option v-for="(group, index) in nhomNV" :key="group.Ma" :value="group.Ma" :selected="group.Ma == person.NhomNhanVien ? 'selected' : ''">{{ group.Ma }}</option> -->
              </select>
            </td>
            <td v-if="!person.isEdit"> 
              <button type="button" @click="editKTV(person)" class="btn btn-primary">Edit</button>
              <button type="button" @click="deleteKTV(person, index)" class="btn btn-danger">Delete</button>
            </td>
            <td v-else>
              <button type="button" @click="updateKTV(index)" class="btn btn-primary">Update</button>
              <button type="button" @click="person.isEdit = false" class="btn btn-primary">Cancel</button>
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
      'nhom': httpVueLoader('components/select_option.vue')
    },
    created() {
      this.getKTVList();
      this.getnhomNV();
    },
    methods: {
      async getKTVList(){
          try 
          {
            const response = await axios.get('api/ktv.php?action=getAllKTV');

            this.KTVList = response.data;
            setTimeout(function(){initDatatable() ;}, 0);//(1)
            
            this.KTVList.forEach(person => {
              Vue.set(person, 'isEdit', false);
            }); 

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
      async updateKTV(index)
      {
        let bodyFormData = new FormData();  

        bodyFormData.append('MaNV', this.selectedKTV.MaNV);
        bodyFormData.append('TenNV', this.selectedKTV.TenNV);
        bodyFormData.append('NhomNhanVien', this.selectedKTV.NhomNhanVien);

        let config = {
            header : {
             'Content-Type' : 'multipart/form-data'
             //'content-type': 'application/x-www-form-urlencoded'
            }
        }
        
        const response = await axios.post('api/ktv.php', bodyFormData, config);
        //this.KTVList[index].isEdit = false;
        //setTimeout(function(){initDatatable() ;}, 0);// đang bug (ko re-initialize đc datatables)
       // response = response.data;
        console.log(response.data);
        if(response.data.success === false)
          Vue.$toast.open({
              message: response.data.msg,
              type: 'error',
              // all of other options may go here
          });

      }



    }
}
</script>
<!-- 
Note:
(1): phải cho initDatatable() vào setTimeout() vì setTimeout so với Promise thì nó chạy sau Promise. Nếu ko thì initDatatable() sẽ chạy trước khi data đc đưa vào DOM và lúc đó <table> sẽ ko có đc format theo dataTAble
(2): preselect value with select option: https://stackoverflow.com/a/48408319/11297747 (using v-model make the value directly bind to the option value.)
(3): https://stackoverflow.com/a/43367234/11297747  

More:
why we cannot access data value in axios.then: https://stackoverflow.com/questions/40996344/axios-cant-set-data
-->

