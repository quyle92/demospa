<form action="" method="post" id="monthSelected">
<?php require_once('datetimepicker_bymonth.php'); ?> 
</form> 

<div class="row">
    <div class="col-md-12" >
      <canvas id="monthlyChart_First" ></canvas>
      <canvas id="monthlyChart_Ajax" ></canvas>
    </div>
</div>

<?php
$firstDay = date('Y-m-01'); 
$today = date('Y-m-d'); 

$firstDay = new DateTime($firstDay);
$today = new DateTime($today);
$today =  $today->add( new DateInterval('P1D') );

$interval = DateInterval::createFromDateString('1 day');
$date_range = new DatePeriod($firstDay,  $interval, $today);

$datediff = $firstDay->diff($today);
$datediff = $datediff->days;

$clientNoByMonth = $clientDev->getClientNoByMonth(  $date_range, $datediff ) ;
$clientNoByMonth = (strToInt($clientNoByMonth));

?>

<script type="text/javascript">
        /**
       * Date processing
       * 
       */
      var d = new Date();
      var firstDay = new Date(d.getFullYear(), d.getMonth(), 1);
      var today = new Date(d.getFullYear(), d.getMonth(), d.getDate());
      
      var dateRange =  getDates(firstDay, today);
      var dateArrayStr = [];
      for (var i = 0; i < dateRange.length; i++){
        dateArrayStr.push(formatDate(dateRange[i]));
      }
     
     var result = [];
     <?php foreach( $clientNoByMonth as $k => $v ) { ?> 
        result.push(<?=$v?>);
     <?php } ?>
     //console.log(result);
     
     if(dateArrayStr.length >1)
      {
        /**
         * ChartJs
         */

        var monthlyChart = document.getElementById('monthlyChart_First');

        var data = {
            labels: dateArrayStr,
            datasets: [{
            label: "Số lượng khách theo tháng",
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


        var lineChartMonth_First = new Chart(monthlyChart, {
            type: 'line',
            data: data,
            options: options,

        });

        /** End ChartJs **/

      }
</script>

<script type="text/javascript">
  var lineChartMonth_Ajax; 

$('form#monthSelected').on('submit', function (event){
    event.preventDefault();
    $('#monthlyChart_First').remove();
    var formValues= $(this).serialize();
    //console.log(formValues);
    $.ajax({
      url:"ajax/process_month.php",
      method:"POST",
      data:formValues,
      dataType:"json",
      success:function(response)
      { 
        /**
         * Date processing javascript
         * 
         */
    
        var start =$('#tuNgay').val();
            start = start.substr(6,4) + '-' + start.substr(3,2) + '-' + start.substr(0,2);
            start = new Date( start );
        var end = $('#denNgay').val();
            end = end.substr(6,4) + '-' + end.substr(3,2) + '-' + end.substr(0,2);
            end = new Date( end );
       

       var dateArray = getDates(start,end);//console.log(dateArray);
       var dateArrayStr = [];
       for(var i = 0; i < dateArray.length; i++){
         dateArrayStr.push( formatDate( dateArray[i] ) );
       }
       //console.log(dateArrayStr);

       /**
        * Ajax result Processing
        * 
        */
        var result = [];
        for (var x in response) {
          result.push( response[x] );
        }
        //console.log(result);
        /**
         * ChartJs
         */

        if ( lineChartMonth_Ajax ) 
        { 

          const data = result;
          const labels = dateArrayStr;

          addData_LineChart(lineChartMonth_Ajax, labels, data );

          lineChartMonth_Ajax.update();//(2)
         
        } 
        else
        {
            const monthlyChart = document.getElementById('monthlyChart_Ajax');

            const data = {
              labels: dateArrayStr,
              datasets: [{
                label: "Số lượng khách theo tháng",
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


            lineChartMonth_Ajax = new Chart(monthlyChart, {//(4)
                type: 'line',
                data: data,
                options: options,

            });
        }
        /** End ChartJs **/
      }

    });
});
</script>
<?php
/*
**Note
 */
//(1): this ở đây là start.
//(2): '' là để convert Number to String. Cách 2:  day =  d.getDate().toString()
//(3): var day phải là string thì mới dùng length để đếm số kí tự đc.
//(4): nếu redeclare var lineChartMonth_Ajax thì khi chạy ajax lần 2,  if ( lineChartMonth_Ajax ) sẽ luôn là false => not what I want