<form action="" method="post" id="yearSelected">
<?php require_once('./datetimepicker_byyear.php'); ?> 
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

$clientRevByYear = $client->getClientRevByYear(  $month_range, $month_diff ) ;
$khach_le = (strToInt($clientRevByYear[0]));
$khach_the = (strToInt($clientRevByYear[1]));
//var_dump($clientRevByYear);
?>

<script type="text/javascript">
        /**
       * Date processing
       * 
       */
      var d = new Date();
        var firstMonth = new Date( d.getFullYear(), d.getMonth() );
        var thisMonth = new Date( d.getFullYear(), d.getMonth() );

       var monthArray = getMonthRange(firstMonth,thisMonth);
     
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

        var yearlyChart = document.getElementById('yearlyChart_First');

        var data = {
          labels: monthArray,
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


        var barChartyear_First = new Chart(yearlyChart, {
            type: 'bar',
            data: data,
            options: options,

        });

        /** End ChartJs **/


</script>

<script type="text/javascript">
  var barChartyear_Ajax; 

$('form#yearSelected').on('submit', function (event){
    event.preventDefault();
    $('#yearlyChart_First').remove();
    var formValues= $(this).serialize();
    //console.log(formValues);
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
       

       var monthArray = getMonthRange(start,end);


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

        if ( barChartyear_Ajax ) 
        { 

          const label = []; label.push('Khách lẻ', 'Khách thẻ');
          const bgColor = []; bgColor.push('#90CBF4', '#FF7693');
          const data = []; data.push(resultKhachLe, resultKhachThe);
          const labels = monthArray;
          addData_BarChart(barChartyear_Ajax,  label, bgColor, data, labels );

          barChartyear_Ajax.update();//(2)
         
        } 
        else
        {
            const yearlyChart = document.getElementById('yearlyChart_Ajax');

            const data = {
            labels: monthArray,
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


            barChartyear_Ajax = new Chart(yearlyChart, {
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
