#!/usr/bin/env node
var program = require('commander');

var capture = require('./capture');


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
