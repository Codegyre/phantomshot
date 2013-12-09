var webshot = require('webshot');


module.exports = function capture(o, cb) {
    var opts = {
        windowSize: {
            width: o.windowX,
            height: o.windowY
        },
        zoomFactor: o.zoomFactor
    };

    if(cb) {
        webshot(o.site, opts, cb);
    }
    else {
        webshot(o.site, o.output, opts, function(err) {
            if(err) return console.error(err);
        });
    }
};
