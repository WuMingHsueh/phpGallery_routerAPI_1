<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class ImageData
{
    private $dbTool;
    private $sqlInsertImage = 'insert into images (id, title, description, upload_date, width, height, size, link, album_name) values (:id, :title, :description, :upload_date, :width, :height, :size, :link, :album_name)';
    private $sqlSelectImageExist = 'select id from images where id = :id';
    private $sqlSelectImageInfo = 'select id, title,description, upload_date as datetime, width, height, size, views, link from images where id = :id and album_name = :album_name';

    public function __construct()
    {
        $this->dbTool = new DbService;
    }

    public function insertImage($id, $title, $description, $uploadDate, $width, $height, $size, $link, $albumId): bool
    {
        return $this->dbTool->transcationSQLExecute($this->sqlInsertImage, [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'upload_date' => $uploadDate,
            'width' => $width,
            'height' => $height,
            'size' => $size,
            'link' => $link,
            'album_name' => $albumId,
        ]);
    }

    public function selectImageExist(string $imageId): bool
    {
        $result = $this->dbTool->queryResult($this->sqlSelectImageExist, ['id' => $imageId]);
        return (count($result) != 0);
    }

    public function selectImageInfo(string $albumId, string $imageId): array
    {
        $result = $this->dbTool->queryResult($this->sqlSelectImageInfo, ['id' => $imageId, 'album_name' => $albumId]);
        return $result[0];
    }
}
