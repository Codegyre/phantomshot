<?php
require '../WebPage.php';
require '../ThumbnailCollector.php';

use Codegyre\PhantomShot\ThumbnailCollector;

$tc = new ThumbnailCollector('http://github.com');
$destDir = '/tmp/tc-test';
if (!file_exists($destDir)) {
    mkdir($destDir);
}
$tc->createThumbnail($destDir.'/wt.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_WIDTH_TOP);
$tc->createThumbnail($destDir.'/wm.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_WIDTH_MIDDLE);
$tc->createThumbnail($destDir.'/wb.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_WIDTH_BOTTOM);

$tc->createThumbnail($destDir.'/hl.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_LEFT);
$tc->createThumbnail($destDir.'/hm.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_MIDDLE);
$tc->createThumbnail($destDir.'/hr.png', 200, 400, ThumbnailCollector::TRANSFORM_FILL_HEIGHT_RIGHT);
