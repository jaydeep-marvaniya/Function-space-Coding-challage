var express = require("express");
var logfmt = require("logfmt");
var math = require("mathjs");
var app = express();

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



app.use(logfmt.requestLogger());
app.use(express.static('public'))

app.get('/', function(req, res) {
  
//  res.send('  HEllo World ');
  res.redirect('simulatorNew.html');
});


app.get('/giveprices', function(req, res) {
 //res.send('Hello World!');
  res.json(getYValues(randomWalk()));
});


app.get('/givenext', function(req, res,lastpt) {
 //res.send('Hello World!');
// res.json(getnxtpt(x,lastpt,randFunc));
 res.json(getYValues(randomWalk(1)));
});


var port = Number(process.env.PORT || 5000);
app.listen(port, function() {
  console.log("Listening on " + port);
});