<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 22.5.2019 г.
 * Time: 14:40
 */

namespace WatchApp\Repositories\Picture;


use WatchApp\Repositories\AbstractRepository;

class UploadPictureRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'upload_picture',
            'primaryKeyName' => 'id'
        ];
    }
}