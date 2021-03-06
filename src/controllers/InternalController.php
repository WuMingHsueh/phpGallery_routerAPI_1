<?php
namespace GalleryAPI\controllers;

use GalleryAPI\api_page\Internal;

class InternalController
{
    public function __construct($pathInfo, $method, $contentType, $authorization)
    {
        if ($contentType != "application/xml") {
            exit;
        }
        $provider = new Internal();
        if (count($pathInfo) == 2 and $method == 'POST' and $pathInfo[1] == 'move-image') {
            echo $provider->moveImage($request);
        }
        if (count($pathInfo) == 2 and $method == 'POST' and $pathInfo[1] == 'undelete-image') {
            echo $provider->undeleteImage($request);
        }   
    }
}
