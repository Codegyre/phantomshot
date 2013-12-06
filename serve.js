#!/usr/bin/env node
var http = require('http');

var express = require('express');

var capture = require('./capture');


main();

function main() {
    var app = express();

    // all environments
    app.set('port', process.env.PORT || 3000);
    app.use(express.logger('dev'));
    //app.use(express.json());
    //app.use(express.urlencoded());
    //app.use(express.methodOverride());
    app.use(app.router);

    // development only
    if ('development' == app.get('env')) {
      app.use(express.errorHandler());
    }

    app.get('/', function(req, res) {
        var site = req.query.site;

        if(!site) return res.send(403, 'Missing site parameter!');

        capture({
            site: site,
            windowX: req.query.windowX || 1024,
            windowY: req.query.windowY || 768
        }, function(err, stream) {
            if(err) return res.send(500, 'Failed to process the site!');

            stream.pipe(res);
        });
    });

    http.createServer(app).listen(app.get('port'), function(){
      console.log('Express server listening on port ' + app.get('port'));
    });
}
