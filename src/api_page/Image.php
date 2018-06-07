<?php
namespace GalleryAPI\api_page ;

class Image
{
    public function uploadImage($request, $albumId)
    {
        return "Post upload Data ". print_r($request, true). "albumID : $albumId";
    }

    public function update($request, $albumId, $imageId)
    {
        return "patch update " . print_r($request, true). "albumID : $albumId, ImageID : $imageId";
    }

    public function delete($albumId, $imageId)
    {
        return "delete albumId: $albumId, imagesId : $imageId";
    }

    public function queryImage($albumId, $imageId)
    {
        return "get albumId: $albumId, imagesId : $imageId";
    }

    public function queryImageInfo($imageId)
    {
        return "get ImageId: $imageId";
    }
}
