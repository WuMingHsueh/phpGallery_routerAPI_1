<?php
namespace GalleryAPI\api_page;

class Internal
{
    public function moveImage($request)
    {
        return "POST moveImage ". print_r($request, true);
    }

    public function undeleteImage($request)
    {
        return "POST undeleteImage ". print_r($request, true);
    }
}
