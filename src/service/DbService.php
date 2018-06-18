<?php
namespace GalleryAPI\service;

class DbService
{
    public $pdo;
    public $pdoState;
    private $projectName = 'galleryPHPAPI';

    public function __construct()
    {
        $configPath = dirname($_SERVER['DOCUMENT_ROOT']) . "/phpWarehouse/{$this->projectName}/config/database.ini";
        $params = parse_ini_file($configPath);
        $dns = \sprintf("pgsql:host=%s;port=%d;dbname=%s", $params['host'], $params['port'], $params['database']);
        $this->pdo = new \PDO($dns, $params['user'], $params['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function connection() : \PDO
    {
        return $this->pdo;
    }

    public function pdoState(string $sql)
    {
        $this->pdoState = $this->pdo->prepare($sql);
        return $this->pdoState;
    }

    public function queryResult(string $sql, array $params = null) : array
    {
        $this->pdoState = $this->pdo->prepare($sql);
        (is_null($params)) ? $this->pdoState->execute() : $this->pdoState->execute($params);
        return $this->pdoState->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function transcationSQLExecute(string $sql, array $params = null)
    {
        $this->pdoState = $this->pdo->prepare($sql);
        return (is_null($params)) ? $this->pdoState->execute() : $this->pdoState->execute($params);
    }
}
