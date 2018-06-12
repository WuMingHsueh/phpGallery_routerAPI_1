<?php
namespace GalleryAPI\controllers;

use GalleryAPI\api_page\Account as Account;

class AccountController
{
    public function __construct($pathInfo, $method, $headers)
    {
        if ($headers['Content-Type'] != "application/xml") {
            exit;
        }
        $provider = new Account();
        if (isset($pathInfo[1]) and $method == 'GET') {
            echo $provider->userInfo($pathInfo[1]);
        }
        if ($method == 'POST' and count($pathInfo) == 1) {
            $request = json_decode(json_encode(file_get_contents("php://input")),true);
            echo $provider->create($request);
        }
    }
}
