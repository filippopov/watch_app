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

    public function create(array $bindParams = array())
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

        $isSave = $stmt->execute($placeholdersValues);

        if ($isSave) {
            return $this->db->lastInsertId();
        }

        return $isSave;
    }

    public function update(int $id, array $bindParams = array()) : bool
    {
        if (count($bindParams) == 0) {
            throw new ApplicationException('Please set params');
        }

        $comma = '';
        $placeholders = '';
        $placeholdersValues = [];
        foreach ($bindParams AS $key => $value) {
            $placeholders .= $comma . "{$key} = ?,";
            $placeholdersValues[] = $value;
        }
        $placeholders = substr($placeholders, 0, count($placeholders) - 2);
        $placeholdersValues[] = $id;

        $query = "
            UPDATE
                {$this->tableName}
            SET
                {$placeholders}
            WHERE
                id = ?
        ";

        $stmt = $this->db->prepare($query);

        return $stmt->execute($placeholdersValues);
    }

    public function delete($id) : bool
    {
        $query = "
            DELETE FROM
                {$this->tableName}
            WHERE
                id = ?
        ";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }


    public function findOneRowById(int $id, $dbClass = null)
    {
        $query = "
            SELECT * FROM {$this->tableName} WHERE {$this->primaryKeyName} = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        if (empty($dbClass)) {
            return $stmt->fetch();
        }

        return $stmt->fetchObject($dbClass);
    }

    public function findAll($dbClass = null)
    {
        $query = "
            SELECT * FROM {$this->tableName} ORDER BY {$this->primaryKeyName} ASC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        if (empty($dbClass)) {
            return $stmt->fetchAll();
        } else {
            $arrOfObjects = [];
            while ($result = $stmt->fetchObject($dbClass)) {
                $arrOfObjects[] = $result;
            }
            return $arrOfObjects;
        }
    }

    public function findByCondition($condition, $dbClass = null, $sortBy = null, $sortDir = 'asc', $limit = null, $offset = 0)
    {
        if (false === $where = $this->buildWhereCondition($condition)) {
            return false;
        }

        $sort = '';
        if (! is_null($sortBy)) {
            $sort = " ORDER BY {$sortBy} " . strtoupper($sortDir);
        }

        $limitBy = '';
        if (! is_null($limit)) {
            $limit = (int) $limit;
            $offset = (int) $offset;
            $limitBy = " LIMIT {$limit} OFFSET {$offset} ";
        }

        $query = "
            SELECT 
                *
            FROM
                {$this->tableName}
            WHERE
                {$where}
                {$sort}
                {$limitBy}
        ";

        $stmt = $this->db->prepare($query);

        $stmt->execute($condition);
        if (empty($dbClass)) {
            return $stmt->fetchAll();
        } else {
            $arrOfObjects = [];
            while ($result = $stmt->fetchObject($dbClass)) {
                $arrOfObjects[] = $result;
            }
            return $arrOfObjects;
        }
    }

    private function buildWhereCondition(array &$conditions = array())
    {
        if (count($conditions) == 0) {
            return false;
        }

        $and = '';
        $where = '';
        $placeholder = '?';

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                if (isset($value['comparator']) && isset($value['value'])) {
                    $where .= $and . $column . ' ' . $value['comparator'] . ' ' . $placeholder;
                } else {
                    $valueData = [];
                    $valuesAsString = '(';
                    foreach ($value as $singleValue) {
                        $valuesAsString .= $placeholder . ', ';
                        $valueData[] = $singleValue;
                    }
                    $valuesAsString = substr($valuesAsString, 0, count($valuesAsString) - 3) . ')';
                    $where .= $and . $column . ' IN ' . $valuesAsString;
                    unset($conditions[$column]);
                    $conditions = $valueData;
                }
            } else {
                $where .= $and . $column . ' = ' . $placeholder;
                unset($conditions[$column]);
                $conditions[] = $value;
            }
            $and = ' AND ';

        }

        return $where;
    }

}