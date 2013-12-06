#!/usr/bin/env node
var fs = require('fs');

var program = require('commander');
var webshot = require('webshot');


main();

function main() {
    program.version(require('./package.json').version).
        option('-s --site <url>', 'site to capture').
        option('-o --output <filename>', 'output name, defaults to shot.png').
        option('-wx --windowX <pixels>', 'window x pixels, defaults to 1024').
        option('-wy --windowY <pixels>', 'window y pixels, defaults to 768').
        parse(process.argv);

    if(!program.site) return console.warn('Missing site to capture!');
    if(!program.output) program.output = 'shot.png';
    if(!program.windowX) program.windowX = 1024;
    if(!program.windowY) program.windowY = 768;

    capture(program);
}

function capture(o) {
    webshot(o.site, o.output, {
        windowSize: {
            x: o.windowX,
            y: o.windowY
        }
    }, function(err) {
        if(err) return console.error(err);
    });
}
