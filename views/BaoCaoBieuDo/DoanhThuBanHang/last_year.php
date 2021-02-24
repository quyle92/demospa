  <div class="panel-body no-padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" >
          <canvas id="lastYear"></canvas>
        </div>
      </div>

    </div>
      
  </div>
           
         

<?php
$doanh_thu = $chartReport->getSalesLastYear();

?>
<script type="text/javascript">
//var ctx = document.getElementById('myChart').getContext('2d');
var salesLastYear = document.getElementById('lastYear');
 var doanhThu = new Array();
    <?php foreach( $doanh_thu as $dt ){ ?>
        doanhThu.push( parseInt('<?php echo $dt; ?>') );
    <?php } ?>

var data = {
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July","Aug","Sep","Oct","Nov","Dec"],
  datasets: [{
    label: "Revenue",
    data: doanhThu,
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
    pointBackgroundColor: function(context) {
    var index = context.dataIndex; //console.log(index);
    var value = context.dataset.data[index];
    return value < 50 ? 'red' :  // draw negative values in red
       // index % 2 ? 'blue' :    // else, alternate values in blue and green
        'green';
    } 
  }]
};
 
var options = {
  legend: {
    display: false,
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
    text: title
   },
   tooltips:{
      callbacks: {
          label: function(tooltipItem, data) {
              var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
              return  data.labels[tooltipItem.index] + ': ' + formatNum; 
          }
      }
   } 
};

var lineChart = new Chart(salesLastYear, {
    type: 'line',
    data: data,
    options: options
});

 

</script>