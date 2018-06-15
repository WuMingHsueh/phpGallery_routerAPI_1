<?php
namespace GalleryAPI\controllers;

use GalleryAPI\api_page\Image;

class IController
{
    public function __construct($pathInfo, $method, $contentType, $authorization)
    {
        if (count($pathInfo) == 2 and $method == 'GET') {
            $provider = new Image();
            echo $provider->queryImageInfo($pathInfo[1]);
        }   
    }
}
