<?php
require_once('lib/NhanVien.php');
$ktv = new NhanVien($conn);
$themmoi = 0; $chinhsua = "0"; 
?>


<div  id="ktv_list_selected">
    <div class="form-group" >
       <div class="col-sm-6 col-md-2">
            <select  class="form-control">
              <option selected="true" disabled="disabled">Chọn Nhóm KTV</option>
              <option value="all">Tất cả</option>
        <?php
        $ktvGroup = $ktv->getKTVGroup();
        foreach($ktvGroup as $r)
        {
        ?>
          <option value="<?=$r['Ten']?>"><?=$r['Ten']?></option>

        <?php
        }
        ?>
           </select>
        </div>
    </div>
</div>
<div  id="ktv_list_tour_order">
    <div class="form-group">
       <div class="col-sm-6 col-md-2">
            <select  class="form-control">
              <option selected="true" disabled="disabled">Chọn thứ tự tour</option>
              <option value = 'all'>Tất cả </option>
							<option value = 1>Có </option>
              <option value = 0>Không </option>
           </select>
        </div>
    </div>
</div>

     <div class="row">
        <div id="app">
            <api-calling></api-calling>
        </div>
     </div>



<script type="text/javascript">
  Vue.use(VueToast);
    const app = new Vue({
    el: '#app',
    components: {
      'api-calling': httpVueLoader('components/ApiCalling.vue')
    }

  });
</script>

<script type="text/javascript">

function initDatatable() {//(1)
    var selectedKTV = $('#ktv_list_selected');
   $('#ktv_list_selected').remove();

   var orderTour = $('#ktv_list_tour_order');
   $('#ktv_list_tour_order').remove();

    // $.noConflict(); 
    function createTable () { 
        $('#ktv_list').DataTable({
          "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
           "pageLength": 10,
          "drawCallback": function( settings ) {
             $('#ktv_list_filter').after(selectedKTV);
             $('#ktv_list_selected').after(orderTour);

          } 
        });
    }
    
    createTable();

        $('#ktv_list_selected select').change(function(){

              let selected = $(this);
              var ktv = selected.val();

              let table = $('#ktv_list').DataTable();
              
              if(ktv !== "all")
              {
                table.column(2).search( ktv ).draw();//(2)
                table.on( 'search.dt', function () {//(3)
                   // console.log('Currently applied global search: '+table.search() );
                 });
              } 

              if (ktv === "all") 
              {
               
                if ( $('#ktv_list_tour_order select option:selected').val() == 'all')
                {
                    table.destroy();
                    createTable ();
                }
                else
                {   
                    let selectedOrderTour =  $('#ktv_list_tour_order select option:selected').val();
                   
                    if(selectedOrderTour == 0)
                    {
                      let regExSearch  = '^$|^0$' ;//match empty or 0
                        table.columns().search( '' ).columns( 3 ).search( regExSearch, true, false ).order( [ 1, 'desc' ] ).draw();
                    }
                    else if (selectedOrderTour == 1)
                    {
                       let regExSearch  = '[1-9]';
                        table.columns().search( '' ).columns( 3 ).search( regExSearch, true, false ).order( [ 3, 'asc' ] ).draw();
                    }    

                }
              }

          });

         $('#ktv_list_tour_order select').change(function(){//alert($(this).val());

              let selected = $(this);
              let orderTour = parseInt( selected.val() );
              let table = $('#ktv_list').DataTable();

              switch (orderTour){
                case 0:{
                  let regExSearch  = '^$|^0$' ;//match empty or 0
                  table.column( 3 ).search( regExSearch, true, false ).order( [ 1, 'desc' ] ).draw();
                   break;
                }
                case 1:{
                  let regExSearch  = '[1-9]';
                  table.column( 3 ).search( regExSearch, true, false ).order( [ 3, 'asc' ] ).draw();
                   break;
                }
                default: {
                  
                  if ( $('#ktv_list_selected select option:selected').val() == 'all')
                  {
                    table.destroy();
                    createTable ();
                  }
                  else
                  {  
                    table.columns().search( '' ).columns( 2 ).search( $('#ktv_list_selected select option:selected').val() ).draw();
                  }

               }

              }

          });
    }


</script>

<script>
var first = true; 

$(document).on("click","#raca", function () {

    if(first)
    {
      $(this).css({"background":"green"});
      $(this).html('Vào ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':0}; 
        $.post(ajaxurl, data, function (response) {
        });
     // setTimeout('window.location="KTV_list.php"',0);
    }
    else
    {
      $(this).css({"background":"red"});
      $(this).html('Ra ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':1};
        $.post(ajaxurl, data, function (response) {
        });
       // setTimeout('window.location="KTV_list.php"',0);
    }

    first = !first; // Invert `first`
});
</script>
<script>
var first1 = true; 

$(document).on("click","#vaoca", function () {

    if(!first1)
    {
      $(this).css({"background":"green"});
      $(this).html('Vào ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':0};
        $.post(ajaxurl, data, function (response) {
        });

      setTimeout('window.location="KTV_list.php"',0);
    }
    else
    {
      $(this).css({"background":"red"});
      $(this).html('Ra ca');
      var manv = $(this).val();
      //alert(manv);
      var ajaxurl = 'KTV_updateca.php',
        data =  {'manv': manv,'vaoca':1};
        $.post(ajaxurl, data, function (response) {
        });
      setTimeout('window.location="KTV_list.php"',0);
    }

    first1 = !first1; // Invert `first`
});
</script>


<!-- Note
(1):Khi từ trong .then((res) => initDatatable()) mà gọi initDatatable() thì initDatatable() ko dc bỏ vào docuemnt.ready(function(){}), vì nếu bỏ vào thì initDatatable() chỉ run khi document ready, sau khi ready rồi thì function trong  ready() đó sẽ ko chạy nữa nên khi trong .then của Promise mà gọi initDatatable() thì sẽ ko gọi đc (vì initDatatable()  nằm trong ready() mà ready đã chạy rồi thì ko có chạy lại nữa trừ khi reload)
(2): https://datatables.net/reference/api/draw()
(3): https://datatables.net/reference/event/search
 -->