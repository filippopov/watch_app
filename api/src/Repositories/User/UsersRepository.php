<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 12.5.2019 г.
 * Time: 9:02
 */

namespace WatchApp\Repositories\User;


use WatchApp\Repositories\AbstractRepository;

class UsersRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'users',
            'primaryKeyName' => 'id'
        ];
    }
}