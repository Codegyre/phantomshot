#!/usr/bin/env node
(function() {
    var argv = require('optimist')
        .usage('Usage: $0 [options] <url>')
        .option('o', {
            alias: 'output',
            default: 'shot.png',
            describe: 'target output file'
        })
        .option('w', {
            alias: 'width',
            default: 1024,
            describe: 'browser window width'
        })
        .option('h', {
            alias: 'height',
            default: 768,
            describe: 'browser window height'
        })
        .option('z', {
            alias: 'zoom',
            default: 1.0,
            describe: 'browser zoom factor'
        })
        .demand(1)
        .argv;

    var options = {
        screenSize: {
            width: argv.w,
            height: argv.h
        },
        shotSize: {
            width: argv.w,
            height: argv.h
        },
        zoomFactor: argv.z
    };

    var webshot = require('webshot');
    webshot(argv._.pop(), argv.o, options, function(err) {
        if (err) {
            console.error(err);
        }
    });
})();