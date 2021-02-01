<form action="" method="post" id="monthSelected">
<?php require_once('./datetimepicker_bymonth.php'); ?> 
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

$clientRevByMonth = $client->getClientRevByMonth(  $date_range, $datediff ) ;
$khach_le = (strToInt($clientRevByMonth[0]));
$khach_the = (strToInt($clientRevByMonth[1]));
//var_dump($clientRevByMonth);
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
     
     var resultKhachLe = [];
     <?php  foreach ($khach_le as $k => $v) { ?>
       resultKhachLe.push( <?php echo $v ?>);

    <?php } ?>

    var resultKhachThe = [];
     <?php  foreach ($khach_the as $k => $v) { ?>
      resultKhachThe.push( <?php echo $v ?>);

    <?php } ?>
     
     if(dateArrayStr.length >1)
      {
        /**
         * ChartJs
         */

        var monthlyChart = document.getElementById('monthlyChart_First');

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

                gridbars:{
                   
                    offsetGridbars: true
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


        var barChartMonth_First = new Chart(monthlyChart, {
            type: 'bar',
            data: data,
            options: options,

        });

        /** End ChartJs **/

      }
</script>

<script type="text/javascript">
  var barChartMonth_Ajax; 

$('form#monthSelected').on('submit', function (event){
    event.preventDefault();
    $('#monthlyChart_First').remove();
    var formValues= $(this).serialize();
    //console.log(formValues);
    $.ajax({
      url:"../views/BaoCaoBieuDo/DoanhThuKhachLeThe/ajax/process_month.php",
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

        if ( barChartMonth_Ajax ) 
        { 

          const label = []; label.push('Khách lẻ', 'Khách thẻ');
          const bgColor = []; bgColor.push('#90CBF4', '#FF7693');
          const data = []; data.push(resultKhachLe, resultKhachThe);
          const labels = dateArrayStr;
          addData_BarChart(barChartMonth_Ajax,  label, bgColor, data, labels );

          barChartMonth_Ajax.update();//(2)
         
        } 
        else
        {
            const monthlyChart = document.getElementById('monthlyChart_Ajax');

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

                    gridbars:{
                       
                        offsetGridbars: true
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


            barChartMonth_Ajax = new Chart(monthlyChart, {//(4)
                type: 'bar',
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
