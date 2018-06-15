<?php
namespace GalleryAPI\api_page ;

use GalleryAPI\service\DbService;
use GalleryAPI\service\ImageService;
use GalleryAPI\service\UploadService;
use GalleryAPI\service\XmlService;
use GalleryAPI\service\AuthService;


class Image
{
    private $dbTool;
    private $imageTool;
    private $uploadTool;
    private $xmlTool;
    private $authTool;

    public function __construct()
    {
        $this->dbTool = new DbService();
        $this->imageTool = new ImageService();
        $this->uploadTool = new UploadService();
        $this->xmlTool = new XmlService();
        $this->authTool = new AuthService();        
    }

    public function uploadImage($request, $fileContent, $albumId)
    {
        return "Post upload Data ". print_r($request, true). "albumID : $albumId";
    }

    public function update($request, $albumId, $imageId)
    {
        return "patch update " . print_r($request, true). "albumID : $albumId, ImageID : $imageId";
    }

    public function delete($albumId, $imageId)
    {
        return "delete albumId: $albumId, imagesId : $imageId";
    }

    public function queryImage($albumId, $imageId)
    {
        return "get albumId: $albumId, imagesId : $imageId";
    }

    public function queryImageInfo($imageId)
    {
        return "get ImageId: $imageId";
    }
}
