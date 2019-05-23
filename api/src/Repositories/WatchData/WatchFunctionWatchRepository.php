<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 23.5.2019 г.
 * Time: 23:01
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class WatchFunctionWatchRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'watch_function_watch',
            'primaryKeyName' => 'id'
        ];
    }
}