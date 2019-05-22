<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 8:15
 */

namespace WatchApp\Adapter;


class Database
{
    private static $inst = null;

    private $pdo;

    public static function instance($host, $user, $pass, $dbName)
    {
        if (self::$inst === null) {
            self::$inst = new Database($host, $user, $pass, $dbName);
        }

        return self::$inst;
    }

    private function __construct($host, $user, $pass, $dbName)
    {
        $this->pdo = new \PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    }

    public function prepare($statement) : DatabaseStatementInterface
    {
        return new DatabaseStatement($this->pdo->prepare($statement));
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}