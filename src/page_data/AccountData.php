<?php
namespace GalleryAPI\page_data;

use GalleryAPI\service\DbService;

class AccountData
{
    private $dbTool;
    private $sqlSelectAccountExist = 'select account from account where account = :account';
    private $sqlinsertAccount = "insert into account (account, bio, token, create_date) values (:account, :bio, :token, :create_date)";

    public function __construct()
    {
        $this->dbTool = new DbService();
    }

    public function selectAccountExist($account): bool
    {
        return (count($this->dbTool->queryResult($this->sqlSelectAccountExist, ['account' => $account])) == 0);
    }

    public function insertAccount($account, $bio, $token)
    {
        $this->dbTool->transcationSQLExecute($this->sqlinsertAccount, [
            'account'     => $account,
            'bio'         => $bio,
            'token'       => $token,
            'create_date' => date('U')
        ]);
    }
}
