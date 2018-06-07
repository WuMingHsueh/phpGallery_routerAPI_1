<?php
namespace GalleryAPI\api_page ;

use GalleryAPI\IRouteResponse;

class Account
{
    public function userInfo($id)
    {
        return "GET /account/{id} -> " . $id;
    }

    public function create($request)
    {
        return print_r($request, true);
    }
}
