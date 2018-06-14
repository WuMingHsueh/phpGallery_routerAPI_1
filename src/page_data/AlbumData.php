<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class AlbumData
{
    private $dbTool;
    private $sqlInsertAlbum = 'insert into albums (id, title, description, owner, create_date) values (:id, :title, :description, :owner, :create_date)';
    private $sqlSelectOwnerAlbum = 'select id from account where account = :account';

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

    private function selectOwnerAlbum($userAccount)
    {
        $result = $this->dbTool->queryResult($this->sqlSelectOwnerAlbum, ['account' => $userAccount]);
        return $result[0]['id'];
    }
    
}
