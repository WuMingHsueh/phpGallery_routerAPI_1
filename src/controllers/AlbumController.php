<?php
namespace GalleryAPI\controllers;

use GalleryAPI\api_page\Album;
use GalleryAPI\api_page\Image;

class AlbumController
{

    public function __construct($pathInfo, $method, $headers)
    {
        switch ($headers['Content-Type']) {
            case 'application/xml':
                $request = json_decode(
                    json_encode(
                        file_get_contents("php://input")),
                        true
                    );
                break;

            case 'multipart/form-data':
                $request = $_FILES;
                break;   

            default:
                exit;
                break;
        }
        if ($method == 'POST' and count($pathInfo) == 1) {
            $provider = new Album();
            echo $provider->create($request);
        }
        if (count($pathInfo) == 2 ) {
            $provider = new Album();
            switch ($method) {
                case 'PATCH':
                    echo $provider->update($request, $pathInfo[1]);
                break;
                case 'DELETE':
                    echo $provider->delete($pathInfo[1]);
                break;
                case 'GET':
                    echo $provider->queryAlbumInfo($pathInfo[1]);
                break;
            }
        }
        if (count($pathInfo) == 3 and $pathInfo[2] == 'latest' and $method == 'GET') {
            $provider = new Album();
            echo $provider->queryLatest($pathInfo[1]);
        }
        if (count($pathInfo) == 3 and $pathInfo[2] == 'hot' and $method == 'GET') {
            $provider = new Album();
            echo $provider->queryHot($pathInfo[1]);
        }
        if (count($pathInfo) == 3 and $pathInfo[2] == 'image' and $method == 'POST') {
            $provider = new Image();
            echo $provider->uploadImage($request, $pathInfo[1]);
        }
        if (count($pathInfo) == 4 and $pathInfo[2] == 'images') {
            $provider = new Image();
            switch ($method) {
                case 'PATCH':
                    echo $provider->update($request, $pathInfo[1], $pathInfo[3]);
                break;
                case 'DELETE':
                    echo $provider->delete($pathInfo[1], $pathInfo[3]);
                break;
                case 'GET':
                    echo $provider->queryImage($pathInfo[1], $pathInfo[3]);
                break;
            }
        }
        if (count($pathInfo) == 3 and $pathInfo[2] == 'cover.jpg') {
            $provider = new Album();
            echo $provider->queryCover($pathInfo[1]);
        }   
    }
}
