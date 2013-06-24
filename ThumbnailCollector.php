<?php

namespace Codegyre\PhantomShot;

class ThumbnailCollector {

    const TRANSFORM_FILL_WIDTH_TOP = 'fill-width-top';
    const TRANSFORM_FILL_WIDTH_MIDDLE = 'fill-width-middle';
    const TRANSFORM_FILL_WIDTH_BOTTOM = 'fill-width-bottom';

    const TRANSFORM_FILL_HEIGHT_LEFT = 'fill-height-left';
    const TRANSFORM_FILL_HEIGHT_MIDDLE = 'fill-height-middle';
    const TRANSFORM_FILL_HEIGHT_RIGHT = 'fill-height-right';

    private $image;
    private $sourceWidth;
    private $sourceHeight;

    /**
     * @param string $url
     * @param string $tmpDir
     * @param string $viewportSize
     * @throws \Exception
     */
    public function __construct($url, $tmpDir = '/tmp', $viewportSize = WebPage::SIZE_NETBOOK_15) {
        if (!is_dir($tmpDir) || !is_writable($tmpDir)) {
            throw new \Exception("Destination dir '$tmpDir' must exist and be writable");
        }

        do {
            $tmpFile = $tmpDir.'/'.uniqid().'.png';
        }
        while(file_exists($tmpFile));

        $webPage = new WebPage($url);
        $webPage->getShot($tmpFile, $viewportSize);

        $this->image = imagecreatefrompng($tmpFile);
        unlink($tmpFile);

        $this->sourceWidth = imagesx($this->image);
        $this->sourceHeight = imagesy($this->image);
    }

    /**
     * @param string $fileName
     * @param int $width
     * @param int $height
     * @param string $transform
     * @throws \Exception
     */
    public function createThumbnail($fileName, $width, $height, $transform = self::TRANSFORM_FILL_WIDTH_TOP) {
        $dstImage = imagecreatetruecolor($width, $height);
        imagealphablending($dstImage, false);
        $transparency = imagecolorallocatealpha($dstImage, 0, 0, 0, 127);
        imagefill($dstImage, 0, 0, $transparency);
        imagesavealpha($dstImage, true);

        $ratioX = (float)$width / $this->sourceWidth;
        $ratioXHeight = $this->sourceHeight * $ratioX;
        if ($ratioXHeight > $height) {
            $calculatedSourceHeight = $this->sourceHeight - ($ratioXHeight - $height) / $ratioX;
            $calculatedDestHeight = $height;

            $destYTop = 0;
            $destYBottom = 0;

            $srcYTop = 0;
            $srcYBottom = ($this->sourceHeight - $height / $ratioX);
        }
        else {
            $calculatedSourceHeight = $this->sourceHeight;
            $calculatedDestHeight = $ratioXHeight;

            $destYTop = 0;
            $destYBottom = ($height - $ratioXHeight);

            $srcYTop = 0;
            $srcYBottom = 0;
        }
        $srcYMiddle =  $srcYBottom / 2;
        $destYMiddle = $destYBottom / 2;

        $ratioY = (float)$height / $this->sourceHeight;
        $ratioYWidth = $this->sourceWidth * $ratioY;
        if ($ratioYWidth > $width) {
            $calculatedSourceWidth = $this->sourceWidth - ($ratioYWidth - $width) / $ratioY;
            $calculatedDestWidth = $width;

            $destXLeft = 0;
            $destXRight = 0;

            $srcXLeft = 0;
            $srcXRight = ($this->sourceWidth - $width / $ratioY);
        }
        else {
            $calculatedSourceWidth = $this->sourceWidth;
            $calculatedDestWidth = $ratioYWidth;

            $destXLeft = 0;
            $destXRight = ($width - $ratioYWidth);

            $srcXLeft = 0;
            $srcXRight = 0;
        }
        $srcXMiddle =  $srcXRight / 2;
        $destXMiddle = $destXRight / 2;

        switch ($transform) {
            case self::TRANSFORM_FILL_WIDTH_TOP:
                imagecopyresized($dstImage, $this->image, 0, $destYTop, 0, $srcYTop, $width, $calculatedDestHeight, $this->sourceWidth, $calculatedSourceHeight);
                break;
            case self::TRANSFORM_FILL_WIDTH_MIDDLE:
                imagecopyresized($dstImage, $this->image, 0, $destYMiddle, 0, $srcYMiddle, $width, $calculatedDestHeight, $this->sourceWidth, $calculatedSourceHeight);
                break;
            case self::TRANSFORM_FILL_WIDTH_BOTTOM:
                imagecopyresized($dstImage, $this->image, 0, $destYBottom, 0, $srcYBottom, $width, $calculatedDestHeight, $this->sourceWidth, $calculatedSourceHeight);
                break;
            case self::TRANSFORM_FILL_HEIGHT_LEFT:
                imagecopyresized($dstImage, $this->image, $destXLeft, 0, $srcXLeft, 0, $calculatedDestWidth, $height, $calculatedSourceWidth, $this->sourceHeight);
                break;
            case self::TRANSFORM_FILL_HEIGHT_MIDDLE:
                imagecopyresized($dstImage, $this->image, $destXMiddle, 0, $srcXMiddle, 0, $calculatedDestWidth, $height, $calculatedSourceWidth, $this->sourceHeight);
                break;
            case self::TRANSFORM_FILL_HEIGHT_RIGHT:
                imagecopyresized($dstImage, $this->image, $destXRight, 0, $srcXRight, 0, $calculatedDestWidth, $height, $calculatedSourceWidth, $this->sourceHeight);
                break;
            default:
                throw new \Exception('Unknown transform');
        }

        imagepng($dstImage, $fileName);
    }
}