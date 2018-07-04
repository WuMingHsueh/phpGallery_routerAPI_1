<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class AlbumData
{
    private $dbTool;
    private $sqlInsertAlbum = 'insert into albums (id, title, description, owner, create_date) values (:id, :title, :description, :owner, :create_date)';
    private $sqlSelectOwnerAlbum = 'select id from account where account = :account';
    private $sqlSelectAlbumInfo = 'select id, title, description, create_date as datetime, owner as account  from albums where id = :id';
    private $sqlSelectAlbumCovers = 'select id as cover from cover where album_id = :album_id';
    private $sqlSelectAlbumImageCount = 'select count(*) as images_count from images where album_name = :album_name';
    private $sqlSelectAlbumImageItem = 'select id, title, description, upload_date as datetime, width, height, size, views, link from images where album_name = :album_name';
    private $sqlSelectAlbumExist = 'select id from albums where id = :id';

    public function __construct()
    {
        $this->dbTool = new DbService();   
    }

    public function insertAlbum($id, $title, $description, $userAccount): bool
    {
        $owner = $this->selectOwnerAlbum($userAccount);
        return $this->dbTool->transcationSQLExecute($this->sqlInsertAlbum, [
            'id'          => $id,
            'title'       => $title,
            'description' => $description,
            'owner'       => $owner,
            'create_date' => date('U')
        ]);
    }

    public function selectAlbumExist($albumId): bool 
    {
        $result = $this->dbTool->queryResult($this->sqlSelectAlbumExist, ['id' => $albumId]);
        return (count($result) != 0);
    }

    public function selectAlbumCovers($albumId): array
    {
        return $this->dbTool->queryResult($this->sqlSelectAlbumCovers, ['album_id' => $albumId]);
    }

    public function selectAlbumImageCount($albumId): array
    {
        return $this->dbTool->queryResult($this->sqlSelectAlbumImageCount, ['album_name' => $albumId])[0];
    }

    public function selectAlbumImageItem($albumId): array
    {
        $temp = [];
        foreach ($this->dbTool->queryResult($this->sqlSelectAlbumImageItem, ['album_name' => $albumId]) as $record) {
            $temp[] = ['item' => $record];
        }
        return $temp;
    }

    public function selectAlbumInfo($albumId): array
    {
        return $this->dbTool->queryResult($this->sqlSelectAlbumInfo, ['id' => $albumId])[0];
    }

    private function selectOwnerAlbum($userAccount)
    {
        $result = $this->dbTool->queryResult($this->sqlSelectOwnerAlbum, ['account' => $userAccount]);
        return $result[0]['id'];
    }
    
}
