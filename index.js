var path = require('path');
const express = require('express');
var RewriteMiddleware = require('express-htaccess-middleware');
var RewriteOptions = {
  file: path.resolve(__dirname, '.htaccess'),
  verbose: (process.env.ENV_NODE == 'development'),
  watch: (process.env.ENV_NODE == 'development'),
};

const app = express();
app.use(RewriteMiddleware(RewriteOptions));

// app.get('/', (req, res) => res.send('Hello World!'))

// must specify options hash even if no options provided!
var phpExpress = require('php-express')({
  // assumes php is in your PATH
  binPath: 'php'
});

// set view engine to php-express
app.set('views', './');
app.engine('php', phpExpress.engine);
app.set('view engine', 'php');

app.get('/', phpExpress.router);

// routing all .php file to php-express
app.all(/.+\.php$/, phpExpress.router);
// app.all(/.+\.js$/, phpExpress.router);

const port = process.env.PORT || 80;
var server = app.listen(port, function () {
  var host = server.address().address;
  var port = server.address().port;
  var node = process.env.ENV_NODE;
  console.log('PHPExpress app listening at http://%s:%s | %s', host, port, node);
});
