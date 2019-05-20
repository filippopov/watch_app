<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.5.2019 г.
 * Time: 17:59
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class WatchFunctionsRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'watch_functions',
            'primaryKeyName' => 'id'
        ];
    }
}