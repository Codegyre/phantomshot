# PhantomShot

PHP tool to make web-shots using PhantomJS

## Making webshot

    $webPage = new \Codegyre\PhantomShot\WebPage('http://github.com');
    $webPage->getShot('/tmp/github.png');

## Thumbnailing

    $tc = new \Codegyre\PhantomShot\ThumbnailCollector('http://github.com');
    $tc->createThumbnail('/destination/dir/1.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_MIDDLE);
    $tc->createThumbnail('/destination/dir/1.png', 350, 160, ThumbnailCollector::TRANSFORM_FILL_WIDTH_MIDDLE);

Make sure you have the latest version of PhantomJS on your system

