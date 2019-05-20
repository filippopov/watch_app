<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.5.2019 г.
 * Time: 11:57
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class BraceletColorRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'bracelet_color',
            'primaryKeyName' => 'id'
        ];
    }
}