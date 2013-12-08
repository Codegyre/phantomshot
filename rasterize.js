#!/usr/bin/env node
var program = require('commander');

var capture = require('./capture');


main();

function main() {
    program.version(require('./package.json').version).
        option('-s --site <url>', 'site to capture').
        option('-o --output <filename>', 'output name, defaults to shot.png').
        option('-wx --windowX <pixels>', 'window x pixels, defaults to 1024', parseInt).
        option('-wy --windowY <pixels>', 'window y pixels, defaults to 768', parseInt).
        option('-z --zoomFactor <factor as float>', 'zoom factor, defaults to 1.0', parseFloat).
        parse(process.argv);

    if(!program.site) return console.warn('Missing site to capture!');
    if(!program.output) program.output = 'shot.png';
    if(!program.windowX) program.windowX = 1024;
    if(!program.windowY) program.windowY = 768;
    if(!program.zoomFactor) program.zoomFactor = 1.0;

    capture(program);
}
