<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.5.2019 г.
 * Time: 18:05
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class BraceletMaterialsRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'bracelet_material',
            'primaryKeyName' => 'id'
        ];
    }
}