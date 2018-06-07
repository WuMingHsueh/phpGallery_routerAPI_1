<?php
namespace GalleryAPI;

use GalleryAPI\api_page\Account;
use GalleryAPI\api_page\Album;
use GalleryAPI\api_page\Image;
use GalleryAPI\api_page\Internal;

class Control
{
    private $method;
    private $pathInfoData;
    private $responseJSON;

    public function __construct($method, $pathInfoData)
    {
        $this->method = $method;
        $this->pathInfoData = $pathInfoData;
        $this->responseJSON = '';
    }

    public function controlAPI($request)
    {
        switch ($this->pathInfoData[0]) {
            case 'account':
                $provider = new Account();
                if (isset($this->pathInfoData[1]) and $this->method == 'GET') {
                    $this->responseJSON = $provider->userInfo($this->pathInfoData[1]);
                }
                if ($this->method == 'POST' and count($this->pathInfoData) == 1) {
                    $this->responseJSON = $provider->create($request);
                }
            break;
            case 'album':
                if ($this->method == 'POST' and count($this->pathInfoData) == 1) {
                    $provider = new Album();
                    $this->responseJSON = $provider->create($request);
                }
                if (count($this->pathInfoData) == 2 ) {
                    $provider = new Album();
                    switch ($this->method) {
                        case 'PATCH':
                            $this->responseJSON = $provider->update($request, $this->pathInfoData[1]);
                        break;
                        case 'DELETE':
                            $this->responseJSON = $provider->delete($this->pathInfoData[1]);
                        break;
                        case 'GET':
                            $this->responseJSON = $provider->queryAlbumInfo($this->pathInfoData[1]);
                        break;
                    }
                }
                if (count($this->pathInfoData) == 3 and $this->pathInfoData[2] == 'latest' and $this->method == 'GET') {
                    $provider = new Album();
                    $this->responseJSON = $provider->queryLatest($this->pathInfoData[1]);
                }
                if (count($this->pathInfoData) == 3 and $this->pathInfoData[2] == 'hot' and $this->method == 'GET') {
                    $provider = new Album();
                    $this->responseJSON = $provider->queryHot($this->pathInfoData[1]);
                }
                if (count($this->pathInfoData) == 3 and $this->pathInfoData[2] == 'image' and $this->method == 'POST') {
                    $provider = new Image();
                    $this->responseJSON = $provider->uploadImage($request, $this->pathInfoData[1]);
                }
                if (count($this->pathInfoData) == 4 and $this->pathInfoData[2] == 'images') {
                    $provider = new Image();
                    switch ($this->method) {
                        case 'PATCH':
                            $this->responseJSON = $provider->update($request, $this->pathInfoData[1], $this->pathInfoData[3]);
                        break;
                        case 'DELETE':
                            $this->responseJSON = $provider->delete($this->pathInfoData[1], $this->pathInfoData[3]);
                        break;
                        case 'GET':
                            $this->responseJSON = $provider->queryImage($this->pathInfoData[1], $this->pathInfoData[3]);
                        break;
                    }
                }
                if (count($this->pathInfoData) == 3 and $this->pathInfoData[2] == 'cover.jpg') {
                    $provider = new Album();
                    $this->responseJSON = $provider->queryCover($this->pathInfoData[1]);
                }
            break;
            case 'i':
                if (count($this->pathInfoData) == 2 and $this->method == 'GET') {
                    $provider = new Image();
                    $this->responseJSON = $provider->queryImageInfo($this->pathInfoData[1]);
                }
            break;
            case 'internal':
                $provider = new Internal();
                if (count($this->pathInfoData) == 2 and $this->method == 'POST' and $this->pathInfoData[1] == 'move-image') {
                    $this->responseJSON = $provider->moveImage($request);
                }
                if (count($this->pathInfoData) == 2 and $this->method == 'POST' and $this->pathInfoData[1] == 'undelete-image') {
                    $this->responseJSON = $provider->undeleteImage($request);
                }
            break;
        }
    }

    public function response()
    {
        return $this->responseJSON;
    }
}
