var express = require("express");
var logfmt = require("logfmt");
var math = require("express");
var app = express();

app.use(logfmt.requestLogger());

app.get('/', function(req, res) {
  res.send('<h1>Hello World!</h1>');
});


app.get('/giveprices', function(req, res) {


  res.send('Hello World!');
});


var port = Number(process.env.PORT || 5000);
app.listen(port, function() {
  console.log("Listening on " + port);
});