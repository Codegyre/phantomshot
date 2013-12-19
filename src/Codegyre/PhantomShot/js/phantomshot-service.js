#!/usr/bin/env node
(function() {
    var argv = require('optimist')
        .usage('Usage: [options] $0')
        .option('p', {
            alias: 'port',
            default: 3000
        })
        .boolean('dev')
        .argv;

    var http = require('http');
    var express = require('express');
    var webshot = require('webshot');

    var app = express();

    // all environments
    app.set('port', argv.p);
    app.use(express.logger('dev'));
    app.use(app.router);

    // development only
    if (argv.dev) {
        app.use(express.errorHandler());
    }

    app.get('/', function(req, res) {
        var url = req.query.url;

        if (!url) {
            res.send(403, 'Missing url parameter!');
            return;
        }

        var width = parseInt(req.query['width']);
        if (!width) {
            width = 1024;
        }

        var height = parseInt(req.query['height']);
        if (!height) {
            height = 768;
        }

        var zoomFactor = parseFloat(req.query['zoom']);
        if (!zoomFactor) {
            zoomFactor = 1.0;
        }

        var options = {
            screenSize: {
                width: width,
                height: height
            },
            shotSize: {
                width: width,
                height: height
            },
            zoomFactor: zoomFactor
        };

        webshot(url, options, function(err, stream) {
            if (err) {
                res.send(500, 'Failed to process the site!');
                return;
            }
            stream.pipe(res);
        });
    });

    http.createServer(app).listen(app.get('port'), function(){
      console.log('Express server listening on port ' + app.get('port'));
    });
})();
