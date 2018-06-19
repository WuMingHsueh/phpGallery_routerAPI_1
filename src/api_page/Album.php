<?php
namespace GalleryAPI\api_page ;

use GalleryAPI\service\XmlService;
use GalleryAPI\service\AuthService;
use GalleryAPI\page_data\AlbumData;

class Album
{
    private $dataTool;
    private $xmlTool;
    private $authTool;

    public function __construct()
    {
        $this->dataTool = new AlbumData();
        $this->xmlTool = new XmlService();
        $this->authTool = new AuthService();
    }

    public function create($request)
    {
        $loginUser = 'joshTest';  // $loginUser = $this->authTool->getLoginUser();
        $albumId = $this->generateAlbumId();
        $this->dataTool->insertAlbum($albumId, $request['title'], $request['description'], $loginUser);
        return $this->xmlTool->xmlEncodeOneLevelWithContent(["type" => "string" ,"status" => "200", "success" => 1], $albumId); // xmlEncodeOneLevelWithContent 為一層的xml 含有標籤內文
    }

    public function delete($albumId)
    {
        return "delete album Id : $albumId";
    }

    public function update($request, $albumId)
    {
        return "patch ". print_r($request, true) . " Id : " . $albumId;
    }

    public function queryAlbumInfo($albumId)
    {
        return "query album Id : $albumId";
    }

    public function queryHot($albumId)
    {
        return "get hot of $albumId";
    }

    public function queryLatest($albumId)
    {
        return "get latest of $albumId";
    }

    private function generateAlbumId()
    {
        // 產生 5~11 字的亂數字串為album 的 Id
        return substr(hash('md5',uniqid()), 0, rand(5, 11)); 
    }
}
