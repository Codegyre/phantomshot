<?php

require_once dirname(__DIR__).'/src/Codegyre/PhantomShot/WebPage.php';
require_once dirname(__DIR__).'/src/Codegyre/PhantomShot/ThumbnailCollector.php';

use Codegyre\PhantomShot\ThumbnailCollector;

$destDir = '/tmp/tc-test';
if (!file_exists($destDir)) {
    mkdir($destDir);
}

try {
    $tc = new ThumbnailCollector('http://github.com', $destDir, \Codegyre\PhantomShot\WebPage::SIZE_NETBOOK_13, 1, 5000, 1200);

    $tc->createThumbnail($destDir.'/wt.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_WIDTH_TOP);
    $tc->createThumbnail($destDir.'/wm.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_WIDTH_MIDDLE);
    $tc->createThumbnail($destDir.'/wb.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_WIDTH_BOTTOM);

    $tc->createThumbnail($destDir.'/hl.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_LEFT);
    $tc->createThumbnail($destDir.'/hm.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_MIDDLE);
    $tc->createThumbnail($destDir.'/hr.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_RIGHT);

    echo "Done!\n";
}
catch (Exception $e) {
    echo "Error happened: {$e->getMessage()}\n";
}
