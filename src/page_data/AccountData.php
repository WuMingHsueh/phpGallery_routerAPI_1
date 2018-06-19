<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class AccountData
{
    private $dbTool;
    private $sqlSelectAccountExist = 'select account from account where account = :account';
    private $sqlinsertAccount = "insert into account (account, bio, id, create_date) values (:account, :bio, :id, :create_date)";

    public function __construct()
    {
        $this->dbTool = new DbService();
    }

    public function selectAccountExist($account): bool
    {
        return (count($this->dbTool->queryResult($this->sqlSelectAccountExist, ['account' => $account])) == 0);
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
