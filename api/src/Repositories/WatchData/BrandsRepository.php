<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 19.5.2019 г.
 * Time: 11:25
 */

namespace WatchApp\Repositories\WatchData;

use WatchApp\Repositories\AbstractRepository;

class BrandsRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'brands',
            'primaryKeyName' => 'id'
        ];
    }
}