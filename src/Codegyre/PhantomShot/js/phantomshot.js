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
        .option('t', {
            alias: 'timeout',
            default: 0,
            describe: 'number of milliseconds to wait before killing the phantomjs process and assuming webshotting has failed. (0 is no timeout.)'
        })
        .option('d', {
            alias: 'delay',
            default: 0,
            describe: 'number of milliseconds to wait after a page loads before taking the screenshot'
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
        zoomFactor: argv.z,
        timeout: argv.t,
        renderDelay: argv.d
    };

    var webshot = require('webshot');
    webshot(argv._.pop(), argv.o, options, function(err) {
        if (err) {
            console.error(err);
            process.exit(1);
        }
    });
})();