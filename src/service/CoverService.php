<?php
namespace GalleryAPI\service;

use GalleryAPI\Environment;
use Intervention\Image\ImageManagerStatic as Image;

class CoverService
{
    private $coverSouceFolder;
    private $coverFolder;
    private $coverFile;
    
    private $albumId;
    private $fileName;

    public function __construct($albumId)
    {
        $this->coverSouceFolder = dirname($_SERVER['DOCUMENT_ROOT']) . "/phpWarehouse/" . Environment::PROJECT_NAME . "/upload/";
        $this->coverFolder = $_SERVER['DOCUMENT_ROOT'] . "/" . Environment::PROJECT_NAME . "/cover/";
        $this->albumId = $albumId;
        $this->fileName = $albumId . '.jpg';
        $this->coverFile = $this->coverFolder . $this->fileName;
    }

    public function combineCover(array $fileNameData)
    {
        $functionName = 'generateCoverLevel' . count($fileNameData);
        $this->$functionName($fileNameData);
    }

    public function generateCoverLevel1(array $fileNameData)
    {
        print_r($fileNameData);
    }

    public function generateCoverLevel2(array $fileNameData)
    {
        print_r($fileNameData);
    }

    public function generateCoverLevel3(array $fileNameData)
    {
        print_r($fileNameData);
    }
}
