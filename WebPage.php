<?php

namespace Codegyre\PhantomShot;

class WebPage {

    const SIZE_SMARTPHONE = '320*480';
    const SIZE_SMARTPHONE_VERTICAL = '480*320';

    const SIZE_NETBOOK_10 = '1024*600';
    const SIZE_NETBOOK_12 = '1024*768';
    const SIZE_NETBOOK_13 = '1280*800';
    const SIZE_NETBOOK_15 = '1366*768';

    const SIZE_DESKTOP_19 = '1440*900';
    const SIZE_DESKTOP_20 = '1600*900';
    const SIZE_DESKTOP_22 = '1680*1050';
    const SIZE_DESKTOP_23 = '1920*1080';
    const SIZE_DESKTOP_24 = '1920*1200';

    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function getShot($destinationFile, $size = self::SIZE_DESKTOP_19, $zoomFactor = 1) {
        $cmdParts = array(
            'phantomjs', // TODO find phantomjs in system
            'rasterize.js',
            escapeshellarg($this->url),
            escapeshellarg($destinationFile),
            escapeshellarg($size),
            escapeshellarg($zoomFactor),
        );
        exec(implode(' ', $cmdParts));
    }
}