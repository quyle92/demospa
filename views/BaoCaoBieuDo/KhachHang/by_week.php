<form action="" method="post" id="weekSelected">
   <?php require_once('datetimepicker_byweek.php'); ?> 
</form> 

<div class="row">
    <div class="col-md-12" >
      <canvas id="weeklyChart_First" ></canvas>
      <canvas id="weeklyChart_Ajax" ></canvas>
    </div>
</div>


<?php
$from = date("Y-m-d", strtotime('monday this week'));
$clientNoByWeek = $clientDev->getClientNoByWeek( $from );
$clientNoByWeek = (strToInt($clientNoByWeek));
//var_dump($clientNoByWeek);  
?>
<script type="text/javascript">
         moment.locale('en', {
            week: { dow: 1 } // Monday is the first day of the week
          });
         /**
          * Date processing
          * @type {[type]}
          */
        var start = moment().weekday(0).format("YYYY-MM-DD");
        start = new Date(start);
        var dateArray = getDates(start, start.addDays(6));
        var dateArrayStr = [];
        for(var i = 0; i < dateArray.length; i++ )
        {
          dateArrayStr.push( formatDate(dateArray[i]) );
        }

        
        
        /**End of date processing***/
        var result = [];
         <?php  foreach ($clientNoByWeek as $k => $v) { ?>
          result.push( <?php echo $v ?>);

        <?php } ?>

        
        /**
         * ChartJs
         */

        var weeklyChart = document.getElementById('weeklyChart_First');

        var data = {
          labels: dateArrayStr,
          datasets: [{
            label: "Số lượng khách theo ngày",
            data: result, 
            fill: false,
            // cubicInterpolationMode : 'monotone',
            lineTension: 0,
            borderColor: 'rgb(51, 153, 255)',
            backgroundColor: 'rgb(51, 153, 255)',
            pointBorderColor: 'rgb(255, 102, 0)',
           // pointBackgroundColor: 'rgb(255, 102, 0)',
            pointRadius: 5,
            pointHoverRadius: 5,  
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rectRounded',
            // pointBackgroundColor: function(context) {
            // var index = context.dataIndex; //console.log(index);
            // var value = context.dataset.data[index];
            // return value < 50 ? 'red' :  // draw negative values in red
            //    // index % 2 ? 'blue' :    // else, alternate values in blue and green
            //     'green';
           // } 
          }]
        };

        var options = {
          legend: {
            display: true,
            position: 'top',
            labels: {
              boxWidth: 80,
              fontColor: 'black'
            }
          },
          plugins: {
                datalabels: false
          },
          scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                    // Convert the number to a string and splite the string every 3 charaters from the end
                    value = value.toString();
                    value = value.split(/(?=(?:...)*$)/);

                    // Convert the array to a string and format the output
                    value = value.join('.');
                    return  value;
                    }

                }
               
            }]},
          xAxes: [{

                gridLines:{
                   
                    offsetGridLines: true
                }
              }]
           ,
           title: {
            display:true,
            text:title
           },
           tooltips:{
              callbacks: {
                  label: function(tooltipItem, data) {
                      var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                      return "Ngày " + data.labels[tooltipItem.index] + ': ' + formatNum; 
                  }
              }
           } 
        };


        var lineChartWeek_First = new Chart(weeklyChart, {
            type: 'line',
            data: data,
            options: options,
        });

        /**  End ChartJs **/
</script>

<script type="text/javascript">
var lineChartWeek_Ajax; 

$('form#weekSelected').on('submit', function (event){
    event.preventDefault();
    $('#weeklyChart_First').remove();

    var dateRange = $('#weeklyDatePicker').val();
    var start = dateRange.split('-')[0].trim(); 
       start = moment(start).format('YYYY-MM-DD');

    $.ajax({
      url:"../views/BaoCaoBieuDo/KhachHang/ajax/process_week.php",
      method:"POST",
      data:{start: start},
      dataType:"json",
      success:function(response)
      { 
        
      /**
       * Date processing
       * 
       */

      start = new Date( start );

      var dateArray = getDates(start, start.addDays(6));//console.log(dateArray);
      var dateArrayStr = [];
      for(var i = 0; i < dateArray.length; i++){
         dateArrayStr.push( formatDate( dateArray[i] ) );
       }
      // console.log(dateArrayStr);

       /**
        * Ajax result Processing
        * 
        */
        var result = [];
        for (var x in response) {
          result.push( response[x] );
        }

        /**
         * ChartJs
         */
         if ( lineChartWeek_Ajax ) 
        { 

          const data = result;
          const labels = dateArrayStr;

          addData_LineChart(lineChartWeek_Ajax, labels, data );

          lineChartWeek_Ajax.update();//(2)
         
        }
        else
        {
          const  weeklyChart = document.getElementById('weeklyChart_Ajax');

          const data = {
              labels: dateArrayStr,
              datasets: [{
              label: "Số lượng khách theo ngày",
              data: result, 
              fill: false,
              // cubicInterpolationMode : 'monotone',
              lineTension: 0,
              borderColor: 'rgb(51, 153, 255)',
              backgroundColor: 'rgb(51, 153, 255)',
              pointBorderColor: 'rgb(255, 102, 0)',
             // pointBackgroundColor: 'rgb(255, 102, 0)',
              pointRadius: 5,
              pointHoverRadius: 5,  
              pointHitRadius: 30,
              pointBorderWidth: 2,
              pointStyle: 'rectRounded',
              // pointBackgroundColor: function(context) {
              // var index = context.dataIndex; //console.log(index);
              // var value = context.dataset.data[index];
              // return value < 50 ? 'red' :  // draw negative values in red
              //    // index % 2 ? 'blue' :    // else, alternate values in blue and green
              //     'green';
             // } 
            }]
          };

          const options = {
            legend: {
              display: true,
              position: 'top',
              labels: {
                boxWidth: 80,
                fontColor: 'black'
              }
            },
            plugins: {
                  datalabels: false
            },
            scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true,
                      callback: function(value, index, values) {
                      // Convert the number to a string and splite the string every 3 charaters from the end
                      value = value.toString();
                      value = value.split(/(?=(?:...)*$)/);

                      // Convert the array to a string and format the output
                      value = value.join('.');
                      return  value;
                      }

                  }
                 
              }]},
            xAxes: [{

                  gridLines:{
                     
                      offsetGridLines: true
                  }
                }],
             title: {
              display:true,
              text:title
             },
             tooltips:{
                callbacks: {
                    label: function(tooltipItem, data) {
                        var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                        return "Ngày " + data.labels[tooltipItem.index] + ': ' + formatNum; 
                    }
                }
             } 
          };


          lineChartWeek_Ajax = new Chart(weeklyChart, {
              type: 'line',
              data: data,
              options: options,

          });

          /**  End ChartJs **/
        }
      }

    });
});
</script>

<?php
/*
**Note
 */
