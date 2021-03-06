<form action="" method="post" id="yearSelected">
<?php require_once('datetimepicker_byyear.php'); ?> 
</form> 

<div class="row">
    <div class="col-md-12" >
      <canvas id="yearlyChart_First" ></canvas>
      <canvas id="yearlyChart_Ajax" ></canvas>
    </div>
</div>

<?php
$firstMonth = date('Y-01'); 
$thisMonth = date('Y-m'); 

$firstMonth = new DateTime($firstMonth);
$thisMonth = new DateTime($thisMonth);
$thisMonth =  $thisMonth->add( new DateInterval('P1M') );

$interval = DateInterval::createFromDateString('1 month');
$month_range = new DatePeriod($firstMonth,  $interval, $thisMonth);

$month_diff =  iterator_count($month_range );

$clientNoByMonth = $clientDev->getClientNoByYear( $month_range, $month_diff ) ;
$clientNoByMonth = (strToInt($clientNoByMonth));
//var_dump($clientNoByMonth);
?>

<script type="text/javascript">
          
         /**
         * Date processing javascript
         * 
         */
    
        var d = new Date();
        var firstMonth = new Date( d.getFullYear(), d.getMonth() );
        var thisMonth = new Date( d.getFullYear(), d.getMonth() );

       var monthArray = getMonthRange(firstMonth,thisMonth);//console.log(dateArray);
       // var monthArrayStr = [];
       // for(var i = 0; i < dateArray.length; i++){
       //   dateArrayStr.push( dateArray[i] );
       // }
      // console.log(monthArray);

      if(monthArray.length >1)
      {
         /**
         * ChartJs
         */
         
          var yearlyChart = document.getElementById('yearlyChart_First');

          var data = {
            labels: monthArray,
            datasets: [{
              label: "Số lượng khách theo năm",
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
                        return "Tháng " + data.labels[tooltipItem.index] + ': ' + formatNum; 
                    }
                }
             } 
          };

          var lineChartYear_First = new Chart(yearlyChart, {
              type: 'line',
              data: data,
              options: options,
              //make data figure above point
              // plugins: [{
              //       afterDatasetsDraw: function(chart) {
              //          var ctx = chart.ctx;
              //          chart.data.datasets.forEach(function(dataset, index) {
              //             var datasetMeta = chart.getDatasetMeta(index);
              //             if (datasetMeta.hidden) return;
              //             datasetMeta.data.forEach(function(point, index) {
              //                var value = dataset.data[index],
              //                    x = point.getCenterPoint().x,
              //                    y = point.getCenterPoint().y,
              //                    radius = point._model.radius,
              //                    fontSize = 10,
              //                    fontFamily = 'Verdana',
              //                    fontColor = 'black',
              //                    fontStyle = 'normal';
              //                ctx.save();
              //                ctx.textBaseline = 'middle';
              //                ctx.textAlign = 'center';
              //                ctx.font = fontStyle + ' ' + fontSize + 'px' + ' ' + fontFamily;
              //                ctx.fillStyle = fontColor;
              //                ctx.fillText(addCommas( value ), x, y - radius - fontSize);
              //                ctx.restore();
              //             });
              //          });
              //       }
              //    }]
          });

        
        /**End Charjs **/
      }
</script>

<script type="text/javascript">
var lineChartYear_Ajax;
      
$('form#yearSelected').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $('#yearlyChart_First').remove();

    $.ajax({
      url:"ajax/process_year.php",
      method:"POST",
      data:formValues,
      dataType:"json",
      success:function(response)
      { 
        /**
         * Date processing javascript
         * 
         */
    
        var start =$('#tuThang').val();
            start = start.substr(3,4) + '-' + start.substr(0,2);
            start = new Date( start );
        var end = $('#denThang').val();
            end = end.substr(3,4) + '-' + end.substr(0,2);
            end = new Date( end );
       

       var monthArray = getMonthRange(start,end);//console.log(dateArray);
       // var monthArrayStr = [];
       // for(var i = 0; i < dateArray.length; i++){
       //   dateArrayStr.push( dateArray[i] );
       // }
       //console.log(monthArray);

       /**
        * Ajax result Processing
        * 
        */
        var result = [];console.log(response);
        for (var x in response) {
          result.push( response[x] );
        }

        /**
         * ChartJs
         */
        if ( lineChartYear_Ajax ) 
        { 

          const data = result;
          const labels = monthArray;
          addData_LineChart(lineChartYear_Ajax, labels, data );

          lineChartYear_Ajax.update();
         
        } 
        else
        {
            var yearlyChart = document.getElementById('yearlyChart_Ajax');

            var data = {
                labels: monthArray,
                datasets: [{
                label: "Số lượng khách theo năm",
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
                          return "Tháng " + data.labels[tooltipItem.index] + ': ' + formatNum; 
                      }
                  }
               } 
            };

            lineChartYear_Ajax = new Chart(yearlyChart, {
                    type: 'line',
                    data: data,
                    options: options,
            });
        }
        /**End Charjs **/
      }

    });
});
</script>

<?php
/*
**Note
 */
