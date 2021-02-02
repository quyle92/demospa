<?php
$tuNgay = isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] :  date('d-m-Y');
$denNgay = isset( $_POST['denNgay'] ) ? $_POST['denNgay'] : date('d-m-Y', strtotime('+1 day'));
$tuGio =  isset( $_POST['tuGio'] ) ? $_POST['tuGio'] :"08:00";
$denGio =  isset( $_POST['denGio'] ) ? $_POST['denGio'] :"08:00";

?>


  <div class="row">
      	<div class="col-md-2" >Từ ngày: </div>
	        <div class="col-md-3" >
            <div class="form-group">
              <div class='input-group date'>
                 <input type='text'  name="tuNgay" class="form-control" value="<?=isset($tuNgay) ? $tuNgay : ""?>" id="tuNgay"/>
                 <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                 </span>
              </div>
            </div>
          </div>
	        <div class="col-md-2" >Từ giờ: </div>
            <div class="col-md-3" >
  	          <div class="form-group">
                <div class='input-group date'  >
                   <input type='text' class="form-control"  id='tuGio' name="tuGio" value="<?=isset($tuGio) ? $tuGio : ""?>"/>
                   <span class="input-group-addon">
                   <span class="glyphicon glyphicon-time"></span>
                   </span>
                </div>
              </div>
            </div>
        <div class="col-md-2" ></div>
	</div>
	<div class="row">
      	<div class="col-md-2" >Đến ngày:</div>
	        <div class="col-md-3" >
            <div class="form-group">
              <div class='input-group date'>
                 <input type='text'  name="denNgay" class="form-control" value="<?=isset($denNgay) ? $denNgay : ""?>" id="denNgay"/>
                 <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                 </span>
              </div>
            </div>
          </div>
	        <div class="col-md-2" >Đến giờ: </div>
	        <div class="col-md-3" >
              <div class="form-group">
                <div class='input-group date'   >
                   <input type='text' class="form-control"  id='denGio'  name="denGio" value="<?=isset($denGio) ? $denGio : ""?>"/>
                   <span class="input-group-addon">
                   <span class="glyphicon glyphicon-time"></span>
                   </span>
                </div>
              </div>
            </div>
        <div class="col-md-2" ><button type="submit" class="btn btn-primary">Lọc</button></div>
	</div>


<script type="text/javascript">

$(function () {

   $('#tuNgay').datetimepicker({
      //viewMode: 'years',
      format: 'DD-MM-YYYY',
      showClear: true
   });

  $('#denNgay').datetimepicker({
      format: 'DD-MM-YYYY',
      showClear: true,
      useCurrent: false
  });

  $("#tuNgay").on("dp.change", function (e) {
   
       $('#denNgay').data("DateTimePicker").minDate(e.date.add(1, 'day'));//(1)
  });

  $("#denNgay").on("dp.change", function (e) {
       $('#tuNgay').data("DateTimePicker").maxDate(e.date.subtract(1, 'day'));
  });

  $('#tuGio').datetimepicker({
      format: 'HH:mm'
  });

  $('#denGio').datetimepicker({
      format: 'HH:mm'
  });


});
</script>