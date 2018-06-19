<?php
namespace GalleryAPI\controllers;

use GalleryAPI\api_page\Account as Account;
use GalleryAPI\service\AuthService;

class AccountController
{
    private $auth;

    public function __construct($pathInfo, $method, $contentType, $authorization)
    {
        $this->auth = new AuthService();
        $provider = new Account();
        if (isset($pathInfo[1]) and $method == 'GET' and $this->auth->tokenAuth($authorization)) {
            echo $provider->userInfo($pathInfo[1]);
        }
        if ($method == 'POST' and count($pathInfo) == 1 and $contentType == "application/xml") {
            $request = json_decode(json_encode(simplexml_load_string(file_get_contents("php://input"))), true);
            echo $provider->create($request);
        }
    }
}
