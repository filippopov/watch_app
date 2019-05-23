<?php
/**
 * Created by PhpStorm.
 * User: Popov
 * Date: 23.5.2019 г.
 * Time: 22:29
 */

namespace WatchApp\Repositories\Picture;


use WatchApp\Repositories\AbstractRepository;

class UploadPictureWatchRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setOptions()
    {
        return [
            'tableName' => 'upload_picture_watches',
            'primaryKeyName' => 'id'
        ];
    }
}