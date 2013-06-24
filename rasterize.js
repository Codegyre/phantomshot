var page = require('webpage').create(),
    fs = require('fs'),
    system = require('system'),
    address, output;

if (system.args.length < 2 || system.args.length > 5) {
    console.log("Usage: phantomjs rasterize.js <web-address> [<output-file=shot.png>] [<viewport-size=1200*800>] [<zoom-factor=1>]");
    phantom.exit();
}
else {
    address = system.args[1];

    if (system.args.length > 2) {
        output = system.args[2];
    }
    else {
        output = 'shot.png';
    }

    var width = 1200, height = 1024;
    if (system.args.length > 3) {
        var size = system.args[3].split('*');
        width = parseInt(size[0]);
        height = parseInt(size[1]);
    }
    page.viewportSize = { width: width, height: height };
    page.clipRect = { top: 0, left: 0, width: width, height: height};

    if (system.args.length > 4) {
        page.zoomFactor = system.args[4];
    }

    page.open(address, function (status) {
        if (status !== 'success') {
            console.log('Unable to load the address! (' + address + ')');
            phantom.exit();
        } else {
            window.setTimeout(function () {
                page.render(output);
                console.log('Done!');
                phantom.exit();
            }, 200);
        }
    });
}

