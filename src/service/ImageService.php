<?php
namespace GalleryAPI\service;

use GalleryAPI\Environment;
use Intervention\Image\ImageManagerStatic as Image;

class ImageService
{
    private $image;
    private $imageSouceFolder;
    private $imageFolder;
    private $fixComporessSchema = ['height' => 50, 'width' => 50];
    private $imageComporessSchema = ['l' => 960, 'm' => 320, 's' => 90];
    private $imageName;
    private $imageExtensionFix = 'jpg';

    private $height;
    private $width;

    public function __construct()
    {
        $this->imageSouceFolder = dirname($_SERVER['DOCUMENT_ROOT']) . "/phpWarehouse/" . Environment::PROJECT_NAME . "/upload/";
        $this->imageFolder = $_SERVER['DOCUMENT_ROOT'] . "/" . Environment::PROJECT_NAME . "/image/";
    }

    public function compressImage($fileName)
    {
        $this->initalCompressImage($fileName);
        $this->image->save("{$this->imageFolder}{$this->imageName}.{$this->imageExtensionFix}");

        $this->image->resize(
            $this->fixComporessSchema['width'],
            $this->fixComporessSchema['height']
        )->save(
            "{$this->imageFolder}{$this->imageName}t.{$this->imageExtensionFix}"
        );

        foreach ($this->imageComporessSchema as $index => $size) {
            if ($this->height >= $size or $this->width >= $size) {
                $resizeBound = $this->resizeImageRateByBound($this->height, $this->width, $size);
                $this->image->resize($resizeBound['width'], $resizeBound['height'])
                    ->save("{$this->imageFolder}{$this->imageName}$index.{$this->imageExtensionFix}", 100);
            }
        }
    }

    public function getImageSize(): array
    {
        return ['width' => $this->width, 'height' => $this->height];
    }

    private function initalCompressImage($fileName)
    {
        $this->image = Image::make($this->imageSouceFolder . $fileName);
        $this->height = $this->image->height();
        $this->width = $this->image->width();
        $this->imageName = explode('.', $fileName)[0];
    }

    private function resizeImageRateByBound($height, $width, $size)
    {
        $rate = $height / $width;
        if ($height > $width) { //
            $newHeigh = $size;
            $newWidth = $size / $rate; // 照比例尺計算
        } else {
            $newWidth = $size;
            $newHeigh = $size * $rate; // 照比例尺計算
        }
        return ["height" => $newHeigh, "width" => $newWidth];
    }
}
