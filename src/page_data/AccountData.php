<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class AccountData
{
    private $dbTool;
    private $sqlSelectAccountExist = 'select account from account where account = :account';
    private $sqlinsertAccount = "insert into account (account, bio, id, create_date) values (:account, :bio, :id, :create_date)";

    private $sqlSelectAccountInfo = 'select account, bio, create_date as created from account where id = :account';
    private $sqlSelectAccountAlbumInfo = 'select album_name as id, count(album_name) as count from images group by album_name having  album_name in (select id from albums where owner = :id)';

    public function __construct()
    {
        $this->dbTool = new DbService();
    }

    public function selectAccountExist($account): bool
    {
        return (count($this->dbTool->queryResult($this->sqlSelectAccountExist, ['account' => $account])) == 0);
    }

    public function selectAccountInfo($accountId): array 
    {
        return $this->dbTool->queryResult($this->sqlSelectAccountInfo, ['account' => $accountId]);
    }

    public function selectAccountAlbumInfo($accountId): array 
    {
        return $this->dbTool->queryResult($this->sqlSelectAccountAlbumInfo, ['id' => $accountId]);
    }

    public function insertAccount($account, $bio, $id)
    {
        $this->dbTool->transcationSQLExecute($this->sqlinsertAccount, [
            'account'     => $account,
            'bio'         => $bio,
            'id'       => $id,
            'create_date' => date('U')
        ]);
    }

}
