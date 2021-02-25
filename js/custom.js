// $(function() {

//     $('#side-menu').metisMenu();

// });

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
      
    });

});

function formatDate( date ){
   var d = new Date( date ),
      day = '' + d.getDate(),//(2)
      month = d.getMonth() + 1,
      year = d.getFullYear();
//console.log(month);
  if(day.length < 2 ){//(3)
    day = '0' + day;
  }

  if( month <= 9 ){
    month = '0' + month;
  }

  return [day, month].join('/');

}

Date.prototype.addDays = function(days){
    d = new Date(this.getTime());//(1)
    d.setDate(d.getDate() + days);

    return d;
};

function getDates(start, end) {

  var currentDate = start;
  var dateArray = [];
  while(currentDate <= end){
    dateArray.push(currentDate);
    currentDate = currentDate.addDays(1);
  }
  return  dateArray;
}//ref: https://stackoverflow.com/a/4413721/11297747


function getMonthRange(start, end)
{
  var dateStart = moment(start);
  var dateEnd = moment(end);
  var timeValues = [];

  while (dateEnd > dateStart || dateStart.format('M') === dateEnd.format('M')) {
     timeValues.push(dateStart.format('MM-YYYY'));
     dateStart.add(1,'month');
  }

  return timeValues;
}//ref: https://stackoverflow.com/questions/29466944/how-to-list-all-month-between-2-dates-with-moment-js



// this function is to prevent Chartjs Bar Chart from showing old data when hovering. ref: https://stackoverflow.com/a/48223887/11297747

function addData_LineChart(chart, labels, data) {
    chart.data.labels = labels;
    chart.data.datasets[0].data = data;
}


function addData_BarChart(chart, label, bgColor, data, labels ) {
   chart.data.datasets = [];
   for(var i = 0; i < data.length; i++){
      chart.data.labels = labels;
      chart.data.datasets.push({
        label: label[i],
        backgroundColor: bgColor[i],        
        data:  data[i],        
      }); 
    }
}


function addCommas(nStr)
{    
    nStr += ''; 
    x = nStr.split('.');
    x1 = x[0];//console.log(x1);
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;var i = 0;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');//console.log(++i);
       //console.log(x1);      
    }
    //console.log(i);
    //console.log(x1);console.log(x2);
    return x1 + x2;
}

function formatAmount( obj ) {

    // remove all the characters except the numeric values
    number = obj.value.replace( /[^0-9]/g, '' );

    var rgx = /(\d+)(\d{3})/;
    while( rgx.test( number ) ) {
        number = number.replace( rgx, '$1' + '.' + '$2' );
    }
    obj.value = number;
}
//ref: https://jsfiddle.net/dcardoso/CkqzL/
//https://codepen.io/559wade/pen/LRzEjj

