<?php
namespace GalleryAPI\service;

use GalleryAPI\Environment;
use Imagine\Imagick\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Intervention\Image\ImageManager;

class ImageService
{
    private $image;
    private $imageSouceFolder;
    private $imageFolder;
    private $fixComporessSchema = ['height' => 50, 'width' => 50];
    private $imageComporessSchema = ['i' => 960, 'm' => 320, 's' => 90];
    private $imageName;
    private $imageExtensionFix = 'jpg';

    private $height;
    private $width;

    public function __construct()
    {
        $this->imageSouceFolder = dirname($_SERVER['DOCUMENT_ROOT']) . "/phpWarehouse/". Environment::PROJECT_NAME . "/upload/";
        $this->imageFolder = $_SERVER['DOCUMENT_ROOT'] . "/". Environment::PROJECT_NAME . "/image/";
    }

    public function compressImage($fileName)
    {
        $this->initalCompressImage($fileName);
        $this->image->save("{$this->imageFolder}{$this->imageName}.{$this->imageExtensionFix}");

        $this->image->thumbnail(
            new Box($this->fixComporessSchema['height'], $this->fixComporessSchema['width']),
            ImageInterface::THUMBNAIL_OUTBOUND
        )->save("{$this->imageFolder}{$this->imageName}t.{$this->imageExtensionFix}");

        foreach ($this->imageComporessSchema as $index => $size) {
            if ($this->height >= $size or $this->width >= $size) {
                $resizeBound = $this->resizeImageRateByBound($this->height, $this->width, $size);
                $this->image->resize(new Box($resizeBound['width'], $resizeBound['height']))
                            ->save("{$this->imageFolder}{$this->imageName}$index.{$this->imageExtensionFix}");
            }
        }
    }

    private function initalCompressImage($fileName)
    {
        $this->image = (new Imagine)->open($this->imageSouceFolder . $fileName);
        $this->height = $this->image->getSize()->getHeight();
        $this->width = $this->image->getSize()->getWidth();
        $this->imageName = explode('.', $fileName)[0];
    }

    private function resizeImageRateByBound($height, $width, $size)
    {
        $rate = $height / $width;
        if ($height > $width) { // 
            $newHeigh = $size;
            $newWidth = $size / $rate;
        } else {
            $newWidth = $size;
            $newHeigh = $size * $rate;
        }
        return ["height" => $newHeigh, "width" => $newWidth];
    }
}
