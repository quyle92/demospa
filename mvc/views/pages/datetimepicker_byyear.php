

<div class="col-md-4 form-group">
  <!-- <label for="tu-Thang">Từ:</label> -->
  <div class="input-group date" style="margin-bottom:5px">
    <input name="tuThang" type='text' class="form-control" id="tuThang" placeholder="From..."/>
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
  </div>
</div>

<div class="col-md-4 col-md-offset-1">
  <!-- <label for="den-Thang">Đến:</label> -->
  <div class="input-group date" style="margin-bottom:5px">
    <input name="denThang" type='text' class="form-control" id="denThang" placeholder="To..."/>
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
   $('#tuThang').datetimepicker({
      viewMode: 'years',
      format: 'MM/YYYY'
   });

    $('#denThang').datetimepicker({
      viewMode: 'years',
      format: 'MM/YYYY',
      useCurrent: false
    });

    $("#tuThang").on("dp.change", function (e) {//console.log(e);
       $('#denThang').data("DateTimePicker").minDate(e.date.add(1,'month'));
    });

    $("#tuThang").on("dp.show", function () {
        $(this).datetimepicker({
        viewMode: 'years',
        format: 'MM/YYYY',
       
      });
    });

    $("#denThang").on("dp.change", function (e) {
       $('#tuThang').data("DateTimePicker").maxDate(e.date.subtract(1,'month'));
    });

 if( monthArray.length >1 ){
      var d = new Date();
      var tuThang = '01' + '/' + d.getFullYear() ;//console.log(tuThang);
      var denThang =( ( d.getMonth() < 9 ) ? 0 + (d.getMonth() + 1).toString() : d.getMonth() + 1 ) + '/' +  d.getFullYear();
      $('#tuThang').val(tuThang);
      $('#denThang').val(denThang);
  }

});

</script>