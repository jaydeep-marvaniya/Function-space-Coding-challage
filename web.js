var express = require("express");
var logfmt = require("logfmt");
var mathjs = require("mathjs");
var app = express();
math = mathjs();
var boxMullerRandom = (function () {
    var phase = 0,
        RAND_MAX,
        array,
        random,
        x1, x2, w, z;

        random = Math.random;
 
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
		time = (new Date()).getTime()
    for (t = -steps; t <= 0; t++) {
        value = value*Math.exp((0.50 + 0.02*randFunc()));
		//value = randFunc();
        points.push([ (time + 1000 * t),math.round(value,3)]);
    }

    return points;
}

function getYValues(points) {
    return points.map(function (point) {
       
		return point[1];
    });
}
function getbothValues(points) {
    return points.map(function (point) {
       
		return  [point[0], Math.abs(point[1])];
    });
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





app.use(logfmt.requestLogger());
app.use(express.static('public'))

app.get('/', function(req, res) {
  
  res.redirect('simulatorNew.html');
});


app.get('/giveprices', function(req, res) {
  res.send(getbothValues(randomWalk()));
});


app.get('/givenext', function(req, res,lastpt) {
// res.json(getnxtpt(x,lastpt,randFunc));
 res.json(getYValues(randomWalk(1)));
});


var port = Number(process.env.PORT || 5000);
app.listen(port, function() {
  console.log("Listening on " + port);
});