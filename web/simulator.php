
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Function Space Coding Challange</title>

<link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>

<script>
$(function() {
	
	Highcharts.setOptions({
		global : {
			useUTC : false
		}
	});
	
	
	function getnxtpt(lastpt)
{
   var newpt;

   newpt =  lastpt + lastpt * ( (Math.exp( (0.095/365) - 0.10*((Math.random()*2) - 1))));
   return  newpt;
}


	
	
	
	
// Create the chart
	$('#container').highcharts('StockChart', {
		chart : {
			events : {
				load : function() {
				//var chart = this,
                //series = chart.series[0];
                
					// set up the updating of the chart each second
					var series = this.series[0];
					var series2 = this.series[1];
					var series3 = this.series[2];
					    var endValue1 = this.series[0].processedYData[this.series[0].processedYData.length - 1];
						var endValue2 = this.series[1].processedYData[this.series[0].processedYData.length - 1];
						var endValue3 = this.series[2].processedYData[this.series[0].processedYData.length - 1];

					setInterval(function() {
					   
						var x = (new Date()).getTime(), // current time
					   // var data2 = this.chart.yAxis[0].series[0].processedYData;
	
						y3 = getnxtpt(endValue1);
						y1 = getnxtpt(endValue2);
						y2 = getnxtpt(endValue3);
//						y =  lastpt * ( (Math.exp( (0.095/365) - 0.010*((Math.random()*2) - 1))));;
						
						
						series.addPoint([x, y3], true, true);
						series2.addPoint([x, y1], true, true);
						series3.addPoint([x, y2], true, true);


							$('#report').html(lastpt);


					}, 10);
				}
			}
		},
		
		  yAxis: {
            title: {
                text: "Current Price %"
            },

            type: 'logarithmic',
           // reversed:true,
            //min:0.001,
            plotLines: [{
                color: '#CCCCCC',
                width: 2,
                value: 1,
                dashStyle: 'ShortDot'
            },{
                color: 'red',
                width: 2,
                value: 10,
                dashStyle: 'ShortDot'
            },{
                color: '#CCCCCCC',
                width: 2,
                value: 80,
                dashStyle: 'ShortDot'
            }],
        },
      
		
		rangeSelector: {
			buttons: [{
				count: 1,
				type: 'minute',
				text: '1M'
			}, {
				count: 5,
				type: 'minute',
				text: '5M'
			}, {
				type: 'all',
				text: 'All'
			}],
			inputEnabled: false,
			selected: 0
		},
		
		title : {
			text : 'Live random data'
		},
		
		exporting: {
			enabled: false
		},
		
		plotOptions:{
            series:{
                dataLabels: {
                    enabled: true,
				/*	formatter: function() {
               var s = [];
                
                $.each(this.point, function(i, point) {
                    s.push(this.point.y);
                });
                
                return null;
            }  */
                    formatter: function() {
					// var data2 = this.chart.yAxis[0].series[0].processedYData;
	
				//	lastpt= this.chart.series[1].data[5];
                         lastpt =  this.y;
                //         return null;
				//		var s = [];
                
              // $.each(this.points, function(i, point) {
                //   s.push(point.y);
               // });
                
                return null;

                    },
            shared: true
  
                } 
            }
        },
		
		 tooltip: {
            formatter: function() {
               var s = [];
                
                $.each(this.points, function(i, point) {
                    s.push('<span style="color:#D31B22;font-weight:bold;">'+ point.series.name +' : '+
                        point.y +'<span>');
                });
                
                return s.join(' and ');
            },
            shared: true
        },
    

		
		series : [{
			name : 'company 1',
			data : (function() {
				// generate an array of random data
				var data = [], time = (new Date()).getTime(), i;

				for( i = -999; i <= 0; i++) {
					data.push([
						time + i * 1000,
						 Math.round(Math.random() * 100)
					]);
				}
				return data;
			})()
			
			
		},
{
			name : 'company 2',
			data : (function() {
				// generate an array of random data
				var data = [], time = (new Date()).getTime(), i;

				for( i = -999; i <= 0; i++) {
					data.push([
						time + i * 1000,
						 Math.round(Math.random() * 100)
						//getnxtpt(data[i-1])
					]);
				}
				return data;
			})()
			
			
		},
{
			name : 'company 3',
			data : (function() {
				// generate an array of random data
				var data = [], time = (new Date()).getTime(), i;

				for( i = -999; i <= 0; i++) {
					data.push([
						time + i * 1000,
						Math.round(Math.random() * 100)
					]);
				}
				return data;
			})()
			
			
		}		
		]
		
		  
	});
	


});


	    

</script>
   
  </head>

  <body>

<div class="container" >

<div id="container"></div>
<div id="report"></div>
</div>
 
    
  </body>
</html>
