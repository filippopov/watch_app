<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 8:11
 */

namespace WatchApp\Repositories;


use WatchApp\Adapter\Database;
use WatchApp\Config\DbConfig;
use WatchApp\Exceptions\ApplicationException;

abstract class AbstractRepository
{
    protected $tableName;
    protected $primaryKeyName;
    protected $db;
    protected $orderField = null;

    public function __construct()
    {
        $options = $this->setOptions();
        $this->tableName = isset($options['tableName']) ? $options['tableName'] : '';
        $this->primaryKeyName = isset($options['primaryKeyName']) ? $options['primaryKeyName'] : '';
        $this->orderField = isset($options['orderField']) ? $options['orderField'] : $this->primaryKeyName;
        $this->db = Database::instance(
            DbConfig::DB_HOST,
            DbConfig::DB_USER,
            DbConfig::DB_PASS,
            DbConfig::DB_NAME
        );
    }

    abstract public function setOptions();

    public function create(array $bindParams = array()) : bool
    {
        if (count($bindParams) == 0) {
            throw new ApplicationException('Please set params');
        }

        $comma = '';
        $cols = '';
        $placeholders = '';
        $placeholdersValues = [];

        foreach ($bindParams as $key => $value) {
            $cols .= $comma . "{$key}";
            $placeholders .= $comma . "?";
            $comma = ', ';
            $placeholdersValues[] = $value;
        }

        $placeholders = '(' . $placeholders . ')';
        $cols = '(' . $cols . ')';

        $query = "
            INSERT INTO {$this->tableName} {$cols} VALUES {$placeholders}
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($placeholdersValues);
    }
}