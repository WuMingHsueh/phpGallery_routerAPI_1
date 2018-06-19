<?php
namespace GalleryAPI\api_page;

use GalleryAPI\Environment;
use GalleryAPI\service\AuthService;
use GalleryAPI\service\ImageService;
use GalleryAPI\service\UploadService;
use GalleryAPI\service\XmlService;
use GalleryAPI\page_data\ImageData;

class Image
{
    private $dataTool;
    private $imageTool;
    private $uploadTool;
    private $xmlTool;
    private $authTool;

    public function __construct()
    {
        $this->dataTool = new ImageData();
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
        $imageId = $this->generateImageId(); // 產生圖檔名同時也是 pk
        $uploadData = $this->uploadTool->uploadFile($imageId, $postFileName); //上傳圖片
        
        // 建立縮圖
        $this->imageTool->compressImage($uploadData['name']);
        $imageData = $this->imageTool->getImageSize();
        
        // 寫入圖片資料到db
        $uploadDate = date('U');
        $this->dataTool->insertImage($imageId, $request['title'], $request['description'],
                           $uploadDate, $imageData['width'], $imageData['height'],
                           $uploadData['size'], $this->getImageLinkUrl($imageId), $albumId);

        // 輸出xml 
        $uploadData = array_merge(['datetime'=> $uploadDate], $imageData, ['size' => $uploadData['size']]);
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

    private function getImageLinkUrl($imageId) {
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/" . Environment::PROJECT_NAME . "/image/{$imageId}.jpg";
    }
}
