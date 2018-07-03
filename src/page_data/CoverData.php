<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class CoverData
{
    private $dbTool;
    private $sqlSelectCheckIdExist = "select id from cover where id = :id";
    private $sqlSelectCoverCount = "select count(cover_order) as cover_order from cover where album_id = :album_id";
    private $sqlInsertCover = "insert into cover (id, album_id, cover_order, file_name) values (:id, :album_id, :cover_order, :file_name)";
    private $sqlSelectFileNames = "select file_name from cover where album_id = :album_id order by cover_order";

    public function __construct()
    {
        $this->dbTool = new DbService();
    }

    public function selectCheckIdExist(string $id): bool
    {
        $result = $this->dbTool->queryResult($this->sqlSelectCheckIdExist, ['id' => $id]);
        return (count($result) != 0);
    }

    public function selectCoverCount(string $albumId)
    {
        $result = $this->dbTool->queryResult($this->sqlSelectCoverCount, ['album_id' => $albumId]);
        return $result[0]['cover_order'];
    }

    public function selectFileNames(string $albumId): array
    {
        $result = $this->dbTool->queryResult($this->sqlSelectFileNames, ['album_id' => $albumId]);
        $temp = [];
        foreach($result as $record) {
            $temp[] = $record['file_name'];
        }
        return $temp;
    }

    public function insertCover($coverId, $albumId, $coverOrder, $fileName): bool
    {
        return $this->dbTool->transcationSQLExecute($this->sqlInsertCover, [
            'id'          => $coverId,
            'album_id'    => $albumId,
            'cover_order' => $coverOrder,
            'file_name'   => $fileName
        ]);
    }

}
