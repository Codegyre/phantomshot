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

    /**
     * @param $url
     * @throws \Exception
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * Make screenshot of web-page
     *
     * @param string $destinationFile
     * @param string $size
     * @param int $zoomFactor
     * @param int $timeout
     * @param int $delay
     * @throws \Exception
     */
    public function getShot($destinationFile, $size = self::SIZE_DESKTOP_19, $zoomFactor = 1, $timeout = 0, $delay = 0) {
        list($width, $height) = explode('*', $size);

        $cmdParts = array(
            './phantomshot.js',
            '--output='.escapeshellarg($destinationFile),
            '--width='.escapeshellarg($width),
            '--height='.escapeshellarg($height),
            '--zoom='.escapeshellarg($zoomFactor),
            '--timeout='.escapeshellarg($timeout),
            '--delay='.escapeshellarg($delay),
            escapeshellarg($this->url),
        );
        $cmd = implode(' ', $cmdParts);

        $descriptorSpec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w"),
        );
        $process = proc_open($cmd, $descriptorSpec, $pipes, __DIR__.'/js');

        if (is_resource($process)) {
            $error = stream_get_contents($pipes[2]);
            proc_close($process);
            if (!empty($error)) {
                throw new \Exception("Webshot creation failed: $error");
            }
        }
        else {
            throw new \Exception("Can't run phantomshot.js");
        }
    }
}