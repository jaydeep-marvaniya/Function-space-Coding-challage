
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
	
	
var boxMullerRandom = (function () {
    var phase = 0,
        RAND_MAX,
        array,
        random,
        x1, x2, w, z;

    if (crypto && typeof crypto.getRandomValues === 'function') {
        RAND_MAX = Math.pow(2, 32) - 1;
        array = new Uint32Array(1);
        random = function () {
            crypto.getRandomValues(array);

            return array[0] / RAND_MAX;
        };
    } else {
        random = Math.random;
    }

    return function () {
        if (!phase) {
            do {
                x1 = 2.0 * random() - 1.0;
                x2 = 2.0 * random() - 1.0;
                w = x1 * x1 + x2 * x2;
            } while (w >= 1.0);

            w = Math.sqrt((-2.0 * Math.log(w)) / w);
            z = x1 * w;
        } else {
            z = x2 * w;
        }

        phase ^= 1;

        return z;
    }
}());

function randomWalk(steps, randFunc) {
    steps = steps >>> 0 || 100;
    if (typeof randFunc !== 'function') {
        randFunc = boxMullerRandom;
    }

    var points = [],
        value = 0,
        t;
		//time = (new Date()).getTime()

    for (t = 0; t < steps; t += 1) {
        value +=  randFunc();
		//value = randFunc();
        points.push([t,value]);
    }

    return points;
}

function getYValues(points) {
    return points.map(function (point) {
        return Math.abs(point[1]);
    });
}

function generatePlots(howMany) {
    howMany = howMany >>> 0 || 10;
    var plots = [],
        index;

    for (index = 0; index < howMany; index += 1) {
        plots.push({
            name: 'plot' + index,
            data: getYValues(randomWalk())
        });
    }

    return plots;
}


function BlackScholes(PutCallFlag, S, X, T, r, v) {

var d1, d2;
d1 = (Math.log(S / X) + (r + v * v / 2.0) * T) / (v * Math.sqrt(T));
d2 = d1 - v * Math.sqrt(T);


if (PutCallFlag== "c")
return S * CND(d1)-X * Math.exp(-r * T) * CND(d2);
else
return X * Math.exp(-r * T) * CND(-d2) - S * CND(-d1);

}

/* The cummulative Normal distribution function: */

function CND(x){

var a1, a2, a3, a4 ,a5, k ;

a1 = 0.31938153, a2 =-0.356563782, a3 = 1.781477937, a4= -1.821255978 , a5= 1.330274429;

if(x<0.0)
return 1-CND(-x);
else
k = 1.0 / (1.0 + 0.2316419 * x);
return 1.0 - Math.exp(-x * x / 2.0)/ Math.sqrt(2*Math.PI) * k
* (a1 + k * (-0.356563782 + k * (1.781477937 + k * (-1.821255978 + k * 1.330274429)))) ;

}


	function getnxtpt(x,lastpt,randFunc)
{
   var newpt;
if (typeof randFunc !== 'function') {
        randFunc = boxMullerRandom;
    }
  // newpt =  lastpt * ( (Math.exp( (  0.23 - (0.0167*0.0167/2)) - 0.0167*(Math.random()))));

 newpt = lastpt + randFunc();
   //newpt =  lastpt * ( (Math.exp( (0.095/365) - 0.10*((Math.random()*2) - 1))));
     // newpt =    lastpt + BlackScholes(c, lastpt, 65, 0.25, 8, 30)
//newpt = lastpt + lastpt*( (Math.exp( (  0.07 - (0.0165*0.0165/2)) - 0.0165*(randFunc()))));
// newpt =  lastpt+ ( lastpt * ( (Math.exp( ( 0.11 - (0.03*0.03/2)) ))) )  + (randFunc());
 
 //newpt =  lastpt + lastpt*(0.62*(1/52) + Math.sqrt(1/52)*0.26*(randFunc()));
 //  newpt =  lastpt + lastpt * ( (Math.exp( (0.095/365) - 0.10*((Math.random()*2) - 1))));

   return newpt;
}

	   var controller = 'home';
            var base_url = 'http://studygujarat.com'; //you have to load the "url_helper" to use this function ?>';
 
            function load_data_ajax(){
                $.ajax({
                    'url' : base_url + '/' + controller + '/getjson',
                    'type' : 'POST', //the way you want to send data to your URL
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#ajax'); //jquery selector (get element by id)
                        if(data){
                            container.html(data);
                        }
                    }
                });
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
						y3 = getnxtpt(x,endValue1);
						y1 = getnxtpt(x,endValue2);
						y2 = getnxtpt(x,endValue3);
//						y =  lastpt * ( (Math.exp( (0.095/365) - 0.010*((Math.random()*2) - 1))));;
						
						
						series.addPoint([x, y3], true, true);
						series2.addPoint([x, y1], true, true);
						series3.addPoint([x, y2], true, true);


							$('#report').html('<h5> Series1 =' + y3 + '</h5>'+ '</br>' + 
											  '<h5> Series1 =' + y1 + '</h5>'+ '</br>'  +
											  '<h5> Series1 =' + y2 + '</h5>'+ '</br>' );

							//this.load_data_ajax();
					}, 100);
				}
			}
		},
		
		  yAxis: {
            title: {
                text: "Current Price %"
            },
           type: 'logarithmic',

          // type: 'liner',
           // reversed:true,
                 
        
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
    

		
		series :generatePlots(3)		
		  
	});
	


});


	    

</script>
   
  </head>

  <body>

<div class="container" >

<div id="container"></div>
<div id="report"></div>
<div id="ajax"></div>
</div>
 
    
  </body>
</html>
