<form action="" method="post" id="weekSelected">
   <?php require_once('./datetimepicker_byweek.php'); ?> 
</form> 

<div class="row">
    <div class="col-md-12" >
      <canvas id="weeklyChart_First" ></canvas>
      <canvas id="weeklyChart_Ajax" ></canvas>
    </div>
</div>

<?php
$from = date("Y-m-d", strtotime('monday this week'));
$clientRevByWeek = $client->getClientRevByWeek( $from );

$khach_le= (strToInt($clientRevByWeek[0]));
$khach_the = (strToInt($clientRevByWeek[1]));
// var_dump($khach_le);
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
        
        var resultKhachLe = [];
         <?php  foreach ($khach_le as $k => $v) { ?>
           resultKhachLe.push( <?php echo $v ?>);

        <?php } ?>

        var resultKhachThe = [];
         <?php  foreach ($khach_the as $k => $v) { ?>
          resultKhachThe.push( <?php echo $v ?>);

        <?php } ?>

        
        /**
         * ChartJs
         */

        var weeklyChart_First = document.getElementById('weeklyChart_First');

        var data = {
          labels: dateArrayStr,
          datasets: [{
              label: "Khách lẻ",
              data: resultKhachLe, 
              backgroundColor: "#90CBF4"

            },
            {
              label: "Khách thẻ",
              data: resultKhachThe, 
              fill: false,
              backgroundColor: "#FF7693"
            }
          ]
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
                      return data.datasets[tooltipItem.datasetIndex].label + ': ' + formatNum; 
                  }
              }
           } 
        };


        var barChartWeek_First = new Chart(weeklyChart_First, {
            type: 'bar',
            data: data,
            options: options,

        });


        /**  End ChartJs **/
</script>

<script type="text/javascript">

var barChartWeek_Ajax; 

$('form#weekSelected').on('submit', function (event){
    event.preventDefault();
    $('#weeklyChart_First').remove();//(1)

    var dateRange = $('#weeklyDatePicker').val();
    var start = dateRange.split('-')[0].trim(); 
       start = moment(start).format('YYYY-MM-DD');

    
    $.ajax({
      url:"../views/BaoCaoBieuDo/DoanhThuKhachLeThe/ajax/process_week.php",
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

     
       var dateArray = getDates(start, start.addDays(6));//console.log(start.addDays(6));
       var dateArrayStr = [];
       for(var i = 0; i < dateArray.length; i++){
         dateArrayStr.push( formatDate( dateArray[i] ) );
       }
      

       /**
        * Ajax result Processing
        * 
        */
        var resultKhachLe = [];
        for (var x in response['khachLe']) {
          resultKhachLe.push( response['khachLe'][x] );
        }
 
        var resultKhachThe = [];
        for (var y in response['khachThe']) {
          resultKhachThe.push( response['khachThe'][y] );
        }


        /**
         * ChartJs
         */
        
        if ( barChartWeek_Ajax) 
        { 

          const label = []; label.push('Khách lẻ', 'Khách thẻ');
          const bgColor = []; bgColor.push('#90CBF4', '#FF7693');
          const data = []; data.push(resultKhachLe, resultKhachThe);
          const labels = dateArrayStr;
          addData_BarChart(barChartWeek_Ajax,  label, bgColor, data, labels );

          barChartWeek_Ajax.update();//(2)
         
        }
        else
        {

          const weeklyChart_Ajax = document.getElementById('weeklyChart_Ajax');

          const data = {
            labels: dateArrayStr,
            datasets: [{
                label: "Khách lẻ",
                data:  resultKhachLe, 
                backgroundColor: "#90CBF4"
              },
              {
                label: "Khách thẻ",
                data: resultKhachThe, 
                backgroundColor: "#FF7693"
              }
            ]
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
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + formatNum; 
                    }
                }
             } 
          };


           barChartWeek_Ajax = new Chart(weeklyChart_Ajax, {
              type: 'bar',
              data: data,
              options: options,

          });
        }
        /**  End ChartJs **/

      } //end success ajax

    });
});
</script>
<?php
/*
**Note
 */
//(1)  chart rendered on page load must be removed so that ajax-rendered chart rendered by ajax call will not be showing previous data when hovering
//(2) .update(): this is to reprevent Chartjs Bar Chart from showing old data when hovering - ref: https://stackoverflow.com/a/42789929/11297747