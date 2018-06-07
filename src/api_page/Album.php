<?php
namespace GalleryAPI\api_page ;

class Album
{
    public function create($request)
    {
        return print_r($request, true);
    }

    public function queryAlbumInfo($albumId)
    {
        return "query album Id : $albumId";
    }

    public function update($request, $albumId)
    {
        return "patch ". print_r($request, true) . " Id : " . $albumId;
    }

    public function delete($albumId)
    {
        return "delete album Id : $albumId";
    }

    public function queryLatest($albumId)
    {
        return "get latest of $albumId";
    }

    public function queryHot($albumId)
    {
        return "get hot of $albumId";
    }
}
