<div class="col-md-4 form-group">
  <!-- <label for="tu-Ngay">Từ:</label> -->
  <div class="input-group date" style="margin-bottom:5px">
    <input name="tuNgay" type='text' class="form-control" id="tuNgay" placeholder="From..."/>
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
  </div>
</div>

<div class="col-md-4 col-md-offset-1">
  <!-- <label for="den-Ngay">Đến:</label> -->
  <div class="input-group date" style="margin-bottom:5px">
    <input name="denNgay" type='text' class="form-control" id="denNgay" placeholder="To..."/>
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
  </div>
</div>

<div class="col-md-1  form-group">
  <button type="submit" class="btn btn-info">Submit</button>
</div>
 


<script type="text/javascript">

$(function () {

   $('#tuNgay').datetimepicker({
      //viewMode: 'years',
      format: 'DD/MM/YYYY'
   });

  $('#denNgay').datetimepicker({
      format: 'DD/MM/YYYY',
      useCurrent: false
  });

  $("#tuNgay").on("dp.change", function (e) {
   
       $('#denNgay').data("DateTimePicker").minDate(e.date.add(1, 'day'));//(1)
  });

  $("#denNgay").on("dp.change", function (e) {
       $('#tuNgay').data("DateTimePicker").maxDate(e.date.subtract(1, 'day'));
  });

 if(dateArrayStr.length > 1)
 {
    var d = new Date();
    var tuNgay =  '01' + '/' + ( ( d.getMonth() < 9 ) ? 0 + (d.getMonth() + 1).toString() : d.getMonth() + 1 )  + '/' + d.getFullYear();//console.log(tuNgay);
    var denNgay =  ( ( d.getDate().toString().length ===1 ) ? '0' + d.getDate() : d.getDate() ) +  '/' + ( ( d.getMonth() < 9 ) ? 0 + (d.getMonth() + 1).toString() : d.getMonth() + 1 ) + '/' + d.getFullYear();
    $('#tuNgay').val(tuNgay);
    $('#denNgay').val(denNgay);
  }


});     
  

</script>
<?php
/**
 * Note
 */
//(1): add 1 day to mindate. ref:https://stackoverflow.com/questions/48815270/bootstrap-datetimepicker-add-1-day-to-mindate