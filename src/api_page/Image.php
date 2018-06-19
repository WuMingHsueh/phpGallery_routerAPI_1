<?php
namespace GalleryAPI\api_page;

use GalleryAPI\service\AuthService;
use GalleryAPI\service\ImageService;
use GalleryAPI\service\UploadService;
use GalleryAPI\service\XmlService;

class Image
{
    private $dbTool;
    private $imageTool;
    private $uploadTool;
    private $xmlTool;
    private $authTool;

    public function __construct()
    {
        $this->uploadTool = new UploadService();
        $this->imageTool = new ImageService();
        $this->xmlTool = new XmlService();
        $this->authTool = new AuthService();
    }

    public function delete($albumId, $imageId)
    {
        return "delete albumId: $albumId, imagesId : $imageId";
    }

    public function update($request, $albumId, $imageId)
    {
        return "patch update " . print_r($request, true) . "albumID : $albumId, ImageID : $imageId";
    }

    public function uploadImage($request, $postFileName, $albumId)
    {
        $imageId = $this->generateImageId();
        $uploadData = $this->uploadTool->uploadFile($imageId, $postFileName);
        $this->imageTool->compressImage($uploadData['name']);
        // $this->insertImage($imageId, $request, $albumId);
        // $uploadData = $this->selectUploadImage($imageId);
        return $this->xmlTool->xmlEncodeDataArray($uploadData, ['success' => "1", 'status' => "200"]);
    }

    public function queryImage($albumId, $imageId)
    {
        return "get albumId: $albumId, imagesId : $imageId";
    }

    public function queryImageInfo($imageId)
    {
        return "get ImageId: $imageId";
    }

    private function generateImageId()
    {
        // 產生 10 字的亂數字串為 Image 的 Id
        return substr(hash('md5', uniqid()), 0, 10);
    }
}
