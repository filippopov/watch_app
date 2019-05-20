<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.5.2019 г.
 * Time: 16:18
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class DialRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'dial',
            'primaryKeyName' => 'id'
        ];
    }
}