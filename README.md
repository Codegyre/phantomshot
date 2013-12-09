# PhantomShot

PHP tool to make web-shots using PhantomJS

## Installation

### add composer requirements

    "require": {
        "codegyre/phantomshot": "dev-master"
    }


### add post-install and post-update hooks to your composer.json

    "scripts": {
        "post-install-cmd": [
            "Codegyre\\PhantomShot\\ComposerHook::hook"
        ],
        "post-update-cmd": [
            "Codegyre\\PhantomShot\\ComposerHook::hook"
        ]
    }

We need this to install required dependencies through npm.

## Making webshot

    $webPage = new \Codegyre\PhantomShot\WebPage('http://github.com');
    $webPage->getShot('/tmp/github.png');

## Thumbnailing

    $tc = new \Codegyre\PhantomShot\ThumbnailCollector('http://github.com');
    $tc->createThumbnail('/destination/dir/1.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_MIDDLE);
    $tc->createThumbnail('/destination/dir/1.png', 350, 160, ThumbnailCollector::TRANSFORM_FILL_WIDTH_MIDDLE);

Make sure you have npm installed on your system

## Using as service

You have a possibility to use phantomshot as a web service to get website screenshots

    cd src/js && ./phantomshot-service.js --port=3000

It will start http server on localhost:3000. Usage:

    http://localhost:3000/?width=1024&height=768&url=http://example.com






