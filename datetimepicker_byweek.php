<div class="col-md-4 form-group">
  <div class="input-group date" style="margin-bottom:5px">
    <input type='text' id='weeklyDatePicker'  class="form-control"  name="timeRange" placeholder="Week..."/>
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
  </div>
</div>
<div class="col-md-4 form-group">
  <button type="submit" class="btn btn-info" >Submit</button>
</div>
 



<script type="text/javascript">

$(document).ready(function(){  
    moment.locale('en', {
      week: { dow: 1 } // Monday is the first day of the week
    });
    //$('#weeklyDatePicker').datetimepicker().on('click', function(){alert(11)});
  //Initialize the datePicker(I have taken format as mm-dd-yyyy, you can     //have your owh)
  $("#weeklyDatePicker").datetimepicker({
      format: 'MMM DD, YYYY',
      useCurrent: true,
      //daysOfWeekDisabled: [0,6],//disable Sat and Sun
      //minDate: new Date(),
      //showClear: true,
      // keepOpen: true,
      // inline: true,
      // debug: true,
     // allowInputToggle: true,
  });

  $('#weeklyDatePicker').data("DateTimePicker").keyBinds({
    pageUp: function (widget) {console.log(widget);
            if (widget.find('.datepicker').is(':visible')) {
                this.date(this.date().clone().add(1, 'M'));
            }
        },
      escape: function () {
            this.hide();
        },
        t: function () {
            this.date(moment());
        },
        'control down': function (widget) {
            if (widget.find('.datepicker').is(':visible')) {console.log('visible');
                this.date(this.date().clone().add(1, 'y'));
            } else {console.log('invisible');
                this.date(this.date().clone().subtract(1, 'M'));
            }
        },
  });

  //$('#weeklyDatePicker').data("DateTimePicker").show();

   //Get the value of Start and End of Week YYYY-MM-DD | MMM DD, YYYY | DD-MM-YYYY
  $('#weeklyDatePicker').on('dp.change', function (e) {

      var value = $("#weeklyDatePicker").val();//console.log(value);
      var firstDate = moment(value).day(1).format("MMM DD, YYYY");//console.log(firstDate);(1)
      var lastDate =  moment(value).day(7).format("MMM DD, YYYY");//console.log(lastDate);
      $("#weeklyDatePicker").val(firstDate + " - " + lastDate);

      //Styling only
      var targetTr = $('.bootstrap-datetimepicker-widget .datepicker-days table tbody tr td.active').parent();
      targetTr.css({'background': 'rgb(253, 249, 28)'});
      $('.bootstrap-datetimepicker-widget table td.active').css({'background': 'initial' , 'color': 'initial'});
  });

  /**
   * set first date and last date of current week
   * @type {[type]}
   */
  var firstDate = moment().weekday(0).format("MMM DD, YYYY");
  var lastDate = moment().weekday(7).format("MMM DD, YYYY");
   $("#weeklyDatePicker").val(firstDate + " - " + lastDate);
   var targetTr = $('.bootstrap-datetimepicker-widget .datepicker-days table tbody tr td.active').parent();
      targetTr.css({'background': 'rgb(253, 249, 28)'});
});
</script>