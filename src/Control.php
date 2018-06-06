<?php
namespace GalleryAPI;

class Control implements IRouteResponse
{
    private $method;
    private $pathInfoData;
    private $responseJSON;

    public function __construct($method, $pathInfoData)
    {
        $this->method = $method;
        $this->pathInfoData = $pathInfoData;
        $this->responseJSON = '';
        $this->controlAPI();
    }

    public function controlAPI($request)
    {
        switch ($this->pathInfoData[0]) {
            case 'account':
                $provider = new Account();
                if (isset($this->pathInfoData[1]) and $method == 'GET') {
                    $this->responseJSON = $provider->userInfo($this->pathInfoData[1]);
                }
                if ($method == 'POST' and count($this->pathInfoData) == 1) {
                    $this->responseJSON = $provider->create($request);
                }
            break;
            case 'album':
                $provider = new Album();
                
            break;
            default:
                # code...
                break;
        }
    }

    public function response()
    {
        return $this->response;
    }
}
