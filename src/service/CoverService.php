<?php
namespace GalleryAPI\service;

use GalleryAPI\Environment;
use Intervention\Image\ImageManagerStatic as Image;

class CoverService
{
    private $coverSouceFolder;
    private $coverFolder;
    private $coverFile;
    private $coverExtensionFix = 'jpg';
    private $coverFirstSize = ['width' => 90, 'height' => 90];
    
    private $albumId;
    private $fileName;

    public function __construct($albumId)
    {
        $this->coverSouceFolder = dirname($_SERVER['DOCUMENT_ROOT']) . "/phpWarehouse/" . Environment::PROJECT_NAME . "/upload/";
        $this->coverFolder = $_SERVER['DOCUMENT_ROOT'] . "/" . Environment::PROJECT_NAME . "/image/cover/";
        $this->albumId = $albumId;
        $this->fileName = "{$albumId}.{$this->coverExtensionFix}";
        $this->coverFile = $this->coverFolder . $this->fileName;
    }

    public function combineCover(array $fileNameData)
    {
        $functionName = 'generateCoverLevel' . count($fileNameData);
        $this->$functionName($fileNameData);
    }

    public function generateCoverLevel1(array $fileNameData)
    {
        $firstImage = Image::make($this->coverSouceFolder . $fileNameData[0]);
        $firstImage->resize(
            $this->coverFirstSize['width'],
            $this->coverFirstSize['height']
        )->save(
            $this->coverFile
        );
    }

    public function generateCoverLevel2(array $fileNameData)
    {
        $cover = Image::make($this->coverFile);
        $first = Image::make($this->coverSouceFolder . $fileNameData[0]);
        $second = Image::make($this->coverSouceFolder . $fileNameData[1]);
        $cover->resize(
            $this->coverFirstSize['width'],
            $this->coverFirstSize['height']
        )->insert(
            $first->resize(
                $this->coverFirstSize['width'] / 2,
                $this->coverFirstSize['height']
            ),
            'left'
        )->insert(
            $second->resize(
                $this->coverFirstSize['width'] / 2,
                $this->coverFirstSize['height']
            ),
            'right'
        )->save();
    }

    public function generateCoverLevel3(array $fileNameData)
    {
        $this->generateCoverLevel1($fileNameData);
        $cover = Image::make($this->coverFile);
        $second = Image::make($this->coverSouceFolder . $fileNameData[1]);
        $third = Image::make($this->coverSouceFolder . $fileNameData[2]);
        $cover->insert(
            $second->resize(
                $this->coverFirstSize['width'] / 2,
                $this->coverFirstSize['height'] / 2
            ),
            'bottom-left'
        )->insert(
            $third->resize(
                $this->coverFirstSize['width'] / 2,
                $this->coverFirstSize['height'] / 2
            ),
            'bottom-right'
        )->save();
    }
}
