<?php
namespace GalleryAPI\api_page ;

use GalleryAPI\page_data\AccountData;

class Account
{
    public function __construct() {}

    public function userInfo($id)
    {
        return "GET /account/{id} -> " . $id;
    }

    public function create($request)
    {
        return print_r($request, true);
    }
}
