#!/usr/bin/env node
var argv = require('optimist')
    .usage('\nUsage: $0 <url>')
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
    .demand(1)
    .argv;

var webshot = require('webshot');
webshot(argv._.pop(), argv.o, {
    windowSize: {
        width: argv.w,
        height: argv.h
    }
}, function(err) {
    if (err) {
        console.error(err);
    }
});

