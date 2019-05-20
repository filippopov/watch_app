<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 20.5.2019 г.
 * Time: 15:34
 */

namespace WatchApp\Repositories\WatchData;


use WatchApp\Repositories\AbstractRepository;

class GlassRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'glass',
            'primaryKeyName' => 'id'
        ];
    }
}