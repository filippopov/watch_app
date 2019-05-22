<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 22.5.2019 г.
 * Time: 21:40
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class WatchesRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'watches',
            'primaryKeyName' => 'id'
        ];
    }
}